<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTrainingProgramRequest;
use App\Http\Requests\UpdateTrainingProgramRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TrainingProgramRepository;
use Illuminate\Http\Request;
use Flash;

class TrainingProgramController extends AppBaseController
{
    /** @var TrainingProgramRepository $trainingProgramRepository*/
    private $trainingProgramRepository;

    public function __construct(TrainingProgramRepository $trainingProgramRepo)
    {
        $this->trainingProgramRepository = $trainingProgramRepo;
    }

    /**
     * Display a listing of the TrainingProgram.
     */
    public function index(Request $request)
    {
        $trainingPrograms = $this->trainingProgramRepository->paginate(10);

        return view('training_programs.index')
            ->with('trainingPrograms', $trainingPrograms);
    }

    /**
     * Show the form for creating a new TrainingProgram.
     */
    public function create()
    {
        return view('training_programs.create');
    }

    /**
     * Store a newly created TrainingProgram in storage.
     */
    public function store(CreateTrainingProgramRequest $request)
    {
        $input = $request->all();

        if (isset($input['features']) && is_string($input['features'])) {
            if (!empty(trim($input['features']))) {
                $input['features'] = json_encode([$input['features']]);
            } else {
                $input['features'] = null;
            }
        }

        $trainingProgram = $this->trainingProgramRepository->create($input);

        Flash::success('Training Program saved successfully.');
        return redirect(route('training-programs.index'));
    }

    /**
     * Display the specified TrainingProgram.
     */
    public function show($id)
    {
        $trainingProgram = $this->trainingProgramRepository->find($id);

        if (empty($trainingProgram)) {
            Flash::error('Training Program not found');

            return redirect(route('training-programs.index'));
        }

        return view('training_programs.show')->with('trainingProgram', $trainingProgram);
    }

    /**
     * Show the form for editing the specified TrainingProgram.
     */
    public function edit($id)
    {
        $trainingProgram = $this->trainingProgramRepository->find($id);

        if (empty($trainingProgram)) {
            Flash::error('Training Program not found');

            return redirect(route('training-programs.index'));
        }

        return view('training_programs.edit')->with('trainingProgram', $trainingProgram);
    }

    /**
     * Update the specified TrainingProgram in storage.
     */
    public function update($id, UpdateTrainingProgramRequest $request)
    {
        $trainingProgram = $this->trainingProgramRepository->find($id);

        if (empty($trainingProgram)) {
            Flash::error('Training Program not found');

            return redirect(route('training-programs.index'));
        }

        $trainingProgram = $this->trainingProgramRepository->update($request->all(), $id);

        Flash::success('Training Program updated successfully.');

        return redirect(route('training-programs.index'));
    }

    /**
     * Remove the specified TrainingProgram from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $trainingProgram = $this->trainingProgramRepository->find($id);

        if (empty($trainingProgram)) {
            Flash::error('Training Program not found');

            return redirect(route('training-programs.index'));
        }

        $this->trainingProgramRepository->delete($id);

        Flash::success('Training Program deleted successfully.');

        return redirect(route('training-programs.index'));
    }
}
