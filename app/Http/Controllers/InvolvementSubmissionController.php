<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvolvementSubmissionRequest;
use App\Http\Requests\UpdateInvolvementSubmissionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\InvolvementSubmissionRepository;
use Illuminate\Http\Request;
use Flash;

class InvolvementSubmissionController extends AppBaseController
{
    /** @var InvolvementSubmissionRepository $involvementSubmissionRepository*/
    private $involvementSubmissionRepository;

    public function __construct(InvolvementSubmissionRepository $involvementSubmissionRepo)
    {
        $this->involvementSubmissionRepository = $involvementSubmissionRepo;
    }

    /**
     * Display a listing of the InvolvementSubmission.
     */
    public function index(Request $request)
    {
        $involvementSubmissions = $this->involvementSubmissionRepository->paginate(10);

        return view('involvement_submissions.index')
            ->with('involvementSubmissions', $involvementSubmissions);
    }

    /**
     * Show the form for creating a new InvolvementSubmission.
     */
    public function create()
    {
        return view('involvement_submissions.create');
    }

    /**
     * Store a newly created InvolvementSubmission in storage.
     */
    public function store(CreateInvolvementSubmissionRequest $request)
    {
        $input = $request->all();

        $involvementSubmission = $this->involvementSubmissionRepository->create($input);

        Flash::success('Involvement Submission saved successfully.');

        return redirect(route('involvementSubmissions.index'));
    }

    /**
     * Display the specified InvolvementSubmission.
     */
    public function show($id)
    {
        $involvementSubmission = $this->involvementSubmissionRepository->find($id);

        if (empty($involvementSubmission)) {
            Flash::error('Involvement Submission not found');

            return redirect(route('involvementSubmissions.index'));
        }

        return view('involvement_submissions.show')->with('involvementSubmission', $involvementSubmission);
    }

    /**
     * Show the form for editing the specified InvolvementSubmission.
     */
    public function edit($id)
    {
        $involvementSubmission = $this->involvementSubmissionRepository->find($id);

        if (empty($involvementSubmission)) {
            Flash::error('Involvement Submission not found');

            return redirect(route('involvementSubmissions.index'));
        }

        return view('involvement_submissions.edit')->with('involvementSubmission', $involvementSubmission);
    }

    /**
     * Update the specified InvolvementSubmission in storage.
     */
    public function update($id, UpdateInvolvementSubmissionRequest $request)
    {
        $involvementSubmission = $this->involvementSubmissionRepository->find($id);

        if (empty($involvementSubmission)) {
            Flash::error('Involvement Submission not found');

            return redirect(route('involvementSubmissions.index'));
        }

        $involvementSubmission = $this->involvementSubmissionRepository->update($request->all(), $id);

        Flash::success('Involvement Submission updated successfully.');

        return redirect(route('involvementSubmissions.index'));
    }

    /**
     * Remove the specified InvolvementSubmission from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $involvementSubmission = $this->involvementSubmissionRepository->find($id);

        if (empty($involvementSubmission)) {
            Flash::error('Involvement Submission not found');

            return redirect(route('involvementSubmissions.index'));
        }

        $this->involvementSubmissionRepository->delete($id);

        Flash::success('Involvement Submission deleted successfully.');

        return redirect(route('involvementSubmissions.index'));
    }
}
