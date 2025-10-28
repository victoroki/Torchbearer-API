<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFormSubmissionRequest;
use App\Http\Requests\UpdateFormSubmissionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\FormSubmissionRepository;
use Illuminate\Http\Request;
use Flash;

class FormSubmissionController extends AppBaseController
{
    /** @var FormSubmissionRepository $formSubmissionRepository*/
    private $formSubmissionRepository;

    public function __construct(FormSubmissionRepository $formSubmissionRepo)
    {
        $this->formSubmissionRepository = $formSubmissionRepo;
    }

    /**
     * Display a listing of the FormSubmission.
     */
    public function index(Request $request)
    {
        $formSubmissions = $this->formSubmissionRepository->paginate(10);

        return view('form_submissions.index')
            ->with('formSubmissions', $formSubmissions);
    }

    /**
     * Show the form for creating a new FormSubmission.
     */
    public function create()
    {
        return view('form_submissions.create');
    }

    /**
     * Store a newly created FormSubmission in storage.
     */
    public function store(CreateFormSubmissionRequest $request)
    {
        $input = $request->all();

        $formSubmission = $this->formSubmissionRepository->create($input);

        Flash::success('Form Submission saved successfully.');

        return redirect(route('formSubmissions.index'));
    }

    /**
     * Display the specified FormSubmission.
     */
    public function show($id)
    {
        $formSubmission = $this->formSubmissionRepository->find($id);

        if (empty($formSubmission)) {
            Flash::error('Form Submission not found');

            return redirect(route('formSubmissions.index'));
        }

        return view('form_submissions.show')->with('formSubmission', $formSubmission);
    }

    /**
     * Show the form for editing the specified FormSubmission.
     */
    public function edit($id)
    {
        $formSubmission = $this->formSubmissionRepository->find($id);

        if (empty($formSubmission)) {
            Flash::error('Form Submission not found');

            return redirect(route('formSubmissions.index'));
        }

        return view('form_submissions.edit')->with('formSubmission', $formSubmission);
    }

    /**
     * Update the specified FormSubmission in storage.
     */
    public function update($id, UpdateFormSubmissionRequest $request)
    {
        $formSubmission = $this->formSubmissionRepository->find($id);

        if (empty($formSubmission)) {
            Flash::error('Form Submission not found');

            return redirect(route('formSubmissions.index'));
        }

        $formSubmission = $this->formSubmissionRepository->update($request->all(), $id);

        Flash::success('Form Submission updated successfully.');

        return redirect(route('formSubmissions.index'));
    }

    /**
     * Remove the specified FormSubmission from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $formSubmission = $this->formSubmissionRepository->find($id);

        if (empty($formSubmission)) {
            Flash::error('Form Submission not found');

            return redirect(route('formSubmissions.index'));
        }

        $this->formSubmissionRepository->delete($id);

        Flash::success('Form Submission deleted successfully.');

        return redirect(route('formSubmissions.index'));
    }
}
