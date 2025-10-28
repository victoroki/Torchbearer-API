<?php

namespace App\Http\Controllers\API;

use App\Models\Certificate;
use App\Models\Course;
use App\Repositories\CertificateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\CertificateMail;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateAPIController extends AppBaseController
{
    private CertificateRepository $certificateRepository;

    public function __construct(CertificateRepository $certificateRepo)
    {
        $this->certificateRepository = $certificateRepo;
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Fetch the single course (there's only one)
            $course = Course::first();

            if (!$course) {
                return $this->sendError('Course not found. Please set up a course first.', 404);
            }

            // Check if the course is active
            if ($course->status != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Course registration is currently unavailable. Please contact the administrator for more information.',
                    'data' => [
                        'course_name' => $course->name,
                        'status' => 'inactive'
                    ]
                ], 403);
            }

            do {
                $certificateId = 'CERT-' . strtoupper(Str::random(10));
            } while (Certificate::where('certificate_id', $certificateId)->exists());

            $certificateData = [
                'certificate_id' => $certificateId,
                'recipient_name' => $request->recipient_name,
                'recipient_email' => $request->recipient_email,
                'course_id' => $course->id,
                'course_name' => $course->name,
                'course_description' => $course->description,
                'issue_date' => now()->format('Y-m-d'),
                'status' => 'pending'
            ];

            $certificate = $this->certificateRepository->create($certificateData);

            // Refresh the certificate to ensure it's properly loaded
            $certificate->refresh();

            // FIXED: Remove the $course parameter - it's fetched inside CertificateMail
            Mail::to($request->recipient_email)->queue(new CertificateMail($certificate));

            $certificate->update([
                'status' => 'queued',
                'email_queued_at' => now()
            ]);

            return $this->sendResponse(
                $certificate->toArray(),
                'Certificate registered successfully. Email is being processed.'
            );
        } catch (\Exception $e) {
            if (isset($certificate)) {
                $this->certificateRepository->delete($certificate->id);
            }
            return $this->sendError('Failed to register certificate: ' . $e->getMessage(), 500);
        }
    }

    private function getImageAsBase64(string $url): string
    {
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $imageData = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 || !$imageData) {
                throw new \Exception('Failed to fetch image');
            }

            $base64 = base64_encode($imageData);
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($imageData);

            return "data:$mimeType;base64,$base64";
        } catch (\Exception $e) {
            return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        }
    }

    public function resendEmail($id): JsonResponse
    {
        try {
            $certificate = $this->certificateRepository->find($id);

            if (empty($certificate)) {
                return $this->sendError('Certificate not found', 404);
            }

            // FIXED: Remove the $course parameter
            Mail::to($certificate->recipient_email)->queue(new CertificateMail($certificate));

            $certificate->update([
                'status' => 'queued',
                'email_queued_at' => now()
            ]);

            return $this->sendResponse($certificate->toArray(), 'Certificate email queued for resend');
        } catch (\Exception $e) {
            if (!empty($certificate)) {
                $certificate->update(['status' => 'failed']);
            }
            return $this->sendError('Failed to queue email: ' . $e->getMessage(), 500);
        }
    }

    public function index(Request $request): JsonResponse
    {
        $certificates = $this->certificateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($certificates->toArray(), 'Certificates retrieved successfully');
    }

    public function show($id): JsonResponse
    {
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            return $this->sendError('Certificate not found');
        }

        return $this->sendResponse($certificate->toArray(), 'Certificate retrieved successfully');
    }

    public function update($id, Request $request): JsonResponse
    {
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            return $this->sendError('Certificate not found');
        }

        $certificate = $this->certificateRepository->update($request->all(), $id);

        return $this->sendResponse($certificate->toArray(), 'Certificate updated successfully');
    }

    public function destroy($id): JsonResponse
    {
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            return $this->sendError('Certificate not found');
        }

        $this->certificateRepository->delete($id);

        return $this->sendSuccess('Certificate deleted successfully');
    }
}
