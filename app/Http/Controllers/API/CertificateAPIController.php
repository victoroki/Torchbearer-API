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
use App\Mail\CertificateMailKenya; 
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
            $course = Course::orderBy('id')->first();

            if (!$course) {
                return $this->sendError('Course not found. Please set up a course first.', 404);
            }

            

            do {
                $certificateId = 'CERT-' . strtoupper(Str::random(10));
            } while (Certificate::where('certificate_id', $certificateId)->exists());

            $certificateData = [
                'certificate_id' => $certificateId,
                'recipient_name' => $request->recipient_name,
                'recipient_email' => $request->recipient_email,
                'course_name' => $course->name,
            ];

            $certificate = $this->certificateRepository->create($certificateData);

            $certificate->refresh();

            Mail::to($request->recipient_email)->queue(new CertificateMail($certificate));
            

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

    public function registerCourseTwo(Request $request): JsonResponse
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
            $course = Course::orderBy('id')->skip(1)->first();

            if (!$course) {
                return $this->sendError('Second course not found. Please set up another course.', 404);
            }

            do {
                $certificateId = 'CERT-' . strtoupper(Str::random(10));
            } while (Certificate::where('certificate_id', $certificateId)->exists());

            $certificateData = [
                'certificate_id' => $certificateId,
                'recipient_name' => $request->recipient_name,
                'recipient_email' => $request->recipient_email,
                'course_name' => $course->name,
            ];

            $certificate = $this->certificateRepository->create($certificateData);
            $certificate->refresh();

            Mail::to($request->recipient_email)->queue(new CertificateMail($certificate));

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

    public function registerKenya(Request $request): JsonResponse
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
            do {
                $certificateId = 'CERT-KE-' . strtoupper(Str::random(10));
            } while (Certificate::where('certificate_id', $certificateId)->exists());

            // Hardcoded course details for Kenya certificates
            $hardcodedCourseName = 'Solar Energy Systems Design';
            $hardcodedCourseDescription = 'Successfully completed comprehensive training in solar photovoltaic system design, installation best practices, and renewable energy solutions for Kenya.';

            // Create certificate with only the fields that exist in your table
            $certificateData = [
                'certificate_id' => $certificateId,
                'recipient_name' => $request->recipient_name,
                'recipient_email' => $request->recipient_email,
                'course_name' => $hardcodedCourseName,
            ];

            $certificate = $this->certificateRepository->create($certificateData);
            $certificate->refresh();

            // Queue the email with hardcoded description
            // The CertificateMailKenya class will handle image fetching when the job processes
            Mail::to($request->recipient_email)->queue(
                new CertificateMailKenya($certificate, $hardcodedCourseDescription)
            );

            return $this->sendResponse(
                array_merge($certificate->toArray(), [
                    'course_description' => $hardcodedCourseDescription,
                    'status' => 'queued'
                ]),
                'Certificate registered successfully. Email is being processed.'
            );
        } catch (\Exception $e) {
            \Log::error('Kenya certificate registration error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if (isset($certificate)) {
                $this->certificateRepository->delete($certificate->id);
            }
            return $this->sendError('Failed to register certificate: ' . $e->getMessage(), 500);
        }
    }

    public function resendEmail($id): JsonResponse
    {
        try {
            $certificate = $this->certificateRepository->find($id);

            if (empty($certificate)) {
                return $this->sendError('Certificate not found', 404);
            }

            Mail::to($certificate->recipient_email)->queue(new CertificateMail($certificate));
            

            return $this->sendResponse($certificate->toArray(), 'Certificate email queued for resend');
        } catch (\Exception $e) {
            if (!empty($certificate)) {
                
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
