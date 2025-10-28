<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInvolvementSubmissionAPIRequest;
use App\Http\Requests\API\UpdateInvolvementSubmissionAPIRequest;
use App\Models\InvolvementSubmission;
use App\Repositories\InvolvementSubmissionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class InvolvementSubmissionAPIController
 */
class InvolvementSubmissionAPIController extends AppBaseController
{
    private InvolvementSubmissionRepository $involvementSubmissionRepository;

    public function __construct(InvolvementSubmissionRepository $involvementSubmissionRepo)
    {
        $this->involvementSubmissionRepository = $involvementSubmissionRepo;
    }

    /**
     * Display a listing of the InvolvementSubmissions.
     * GET|HEAD /involvement-submissions
     */
    public function index(Request $request): JsonResponse
    {
        $involvementSubmissions = $this->involvementSubmissionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($involvementSubmissions->toArray(), 'Involvement Submissions retrieved successfully');
    }

    /**
     * Store a newly created InvolvementSubmission in storage.
     * POST /involvement-submissions
     */
    public function store(CreateInvolvementSubmissionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $involvementSubmission = $this->involvementSubmissionRepository->create($input);

        return $this->sendResponse($involvementSubmission->toArray(), 'Involvement Submission saved successfully');
    }

    /**
     * Display the specified InvolvementSubmission.
     * GET|HEAD /involvement-submissions/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var InvolvementSubmission $involvementSubmission */
        $involvementSubmission = $this->involvementSubmissionRepository->find($id);

        if (empty($involvementSubmission)) {
            return $this->sendError('Involvement Submission not found');
        }

        return $this->sendResponse($involvementSubmission->toArray(), 'Involvement Submission retrieved successfully');
    }

    /**
     * Update the specified InvolvementSubmission in storage.
     * PUT/PATCH /involvement-submissions/{id}
     */
    public function update($id, UpdateInvolvementSubmissionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var InvolvementSubmission $involvementSubmission */
        $involvementSubmission = $this->involvementSubmissionRepository->find($id);

        if (empty($involvementSubmission)) {
            return $this->sendError('Involvement Submission not found');
        }

        $involvementSubmission = $this->involvementSubmissionRepository->update($input, $id);

        return $this->sendResponse($involvementSubmission->toArray(), 'InvolvementSubmission updated successfully');
    }

    /**
     * Remove the specified InvolvementSubmission from storage.
     * DELETE /involvement-submissions/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var InvolvementSubmission $involvementSubmission */
        $involvementSubmission = $this->involvementSubmissionRepository->find($id);

        if (empty($involvementSubmission)) {
            return $this->sendError('Involvement Submission not found');
        }

        $involvementSubmission->delete();

        return $this->sendSuccess('Involvement Submission deleted successfully');
    }
}
