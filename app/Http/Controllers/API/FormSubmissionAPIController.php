<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFormSubmissionAPIRequest;
use App\Http\Requests\API\UpdateFormSubmissionAPIRequest;
use App\Models\FormSubmission;
use App\Repositories\FormSubmissionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class FormSubmissionAPIController
 */
class FormSubmissionAPIController extends AppBaseController
{
    private FormSubmissionRepository $formSubmissionRepository;

    public function __construct(FormSubmissionRepository $formSubmissionRepo)
    {
        $this->formSubmissionRepository = $formSubmissionRepo;
    }

    /**
     * Display a listing of the FormSubmissions.
     * GET|HEAD /form-submissions
     */
    public function index(Request $request): JsonResponse
    {
        $formSubmissions = $this->formSubmissionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($formSubmissions->toArray(), 'Form Submissions retrieved successfully');
    }

    /**
     * Store a newly created FormSubmission in storage.
     * POST /form-submissions
     */
    public function store(CreateFormSubmissionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $formSubmission = $this->formSubmissionRepository->create($input);

        return $this->sendResponse($formSubmission->toArray(), 'Form Submission saved successfully');
    }

    /**
     * Display the specified FormSubmission.
     * GET|HEAD /form-submissions/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var FormSubmission $formSubmission */
        $formSubmission = $this->formSubmissionRepository->find($id);

        if (empty($formSubmission)) {
            return $this->sendError('Form Submission not found');
        }

        return $this->sendResponse($formSubmission->toArray(), 'Form Submission retrieved successfully');
    }

    /**
     * Update the specified FormSubmission in storage.
     * PUT/PATCH /form-submissions/{id}
     */
    public function update($id, UpdateFormSubmissionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var FormSubmission $formSubmission */
        $formSubmission = $this->formSubmissionRepository->find($id);

        if (empty($formSubmission)) {
            return $this->sendError('Form Submission not found');
        }

        $formSubmission = $this->formSubmissionRepository->update($input, $id);

        return $this->sendResponse($formSubmission->toArray(), 'FormSubmission updated successfully');
    }

    /**
     * Remove the specified FormSubmission from storage.
     * DELETE /form-submissions/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var FormSubmission $formSubmission */
        $formSubmission = $this->formSubmissionRepository->find($id);

        if (empty($formSubmission)) {
            return $this->sendError('Form Submission not found');
        }

        $formSubmission->delete();

        return $this->sendSuccess('Form Submission deleted successfully');
    }
}
