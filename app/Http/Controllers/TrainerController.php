<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTrainerRequest;
use App\Http\Requests\UpdateTrainerRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TrainerRepository;
use Illuminate\Http\Request;
use Flash;

class TrainerController extends AppBaseController
{
    /** @var TrainerRepository $trainerRepository*/
    private $trainerRepository;

    public function __construct(TrainerRepository $trainerRepo)
    {
        $this->trainerRepository = $trainerRepo;
    }

    /**
     * Display a listing of the Trainer.
     */
    public function index(Request $request)
    {
        $trainers = $this->trainerRepository->paginate(10);

        return view('trainers.index')
            ->with('trainers', $trainers);
    }

    /**
     * Show the form for creating a new Trainer.
     */
    public function create()
    {
        return view('trainers.create');
    }

    /**
     * Store a newly created Trainer in storage.
     */
    public function store(CreateTrainerRequest $request)
    {
        $input = $request->all();

        $trainer = $this->trainerRepository->create($input);

        Flash::success('Trainer saved successfully.');

        return redirect(route('trainers.index'));
    }

    /**
     * Display the specified Trainer.
     */
    public function show($id)
    {
        $trainer = $this->trainerRepository->find($id);

        if (empty($trainer)) {
            Flash::error('Trainer not found');

            return redirect(route('trainers.index'));
        }

        return view('trainers.show')->with('trainer', $trainer);
    }

    /**
     * Show the form for editing the specified Trainer.
     */
    public function edit($id)
    {
        $trainer = $this->trainerRepository->find($id);

        if (empty($trainer)) {
            Flash::error('Trainer not found');

            return redirect(route('trainers.index'));
        }

        return view('trainers.edit')->with('trainer', $trainer);
    }

    /**
     * Update the specified Trainer in storage.
     */
    public function update($id, UpdateTrainerRequest $request)
    {
        $trainer = $this->trainerRepository->find($id);

        if (empty($trainer)) {
            Flash::error('Trainer not found');

            return redirect(route('trainers.index'));
        }

        $trainer = $this->trainerRepository->update($request->all(), $id);

        Flash::success('Trainer updated successfully.');

        return redirect(route('trainers.index'));
    }

    /**
     * Remove the specified Trainer from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $trainer = $this->trainerRepository->find($id);

        if (empty($trainer)) {
            Flash::error('Trainer not found');

            return redirect(route('trainers.index'));
        }

        $this->trainerRepository->delete($id);

        Flash::success('Trainer deleted successfully.');

        return redirect(route('trainers.index'));
    }
}
