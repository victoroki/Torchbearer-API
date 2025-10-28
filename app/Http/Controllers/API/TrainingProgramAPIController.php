<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTrainingProgramAPIRequest;
use App\Http\Requests\API\UpdateTrainingProgramAPIRequest;
use App\Models\TrainingProgram;
use App\Repositories\TrainingProgramRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TrainingProgramAPIController
 */
class TrainingProgramAPIController extends AppBaseController
{
    private TrainingProgramRepository $trainingProgramRepository;

    public function __construct(TrainingProgramRepository $trainingProgramRepo)
    {
        $this->trainingProgramRepository = $trainingProgramRepo;
    }

    /**
     * Display a listing of the TrainingPrograms.
     * GET|HEAD /training-programs
     */
    public function index(Request $request): JsonResponse
    {
        $trainingPrograms = $this->trainingProgramRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($trainingPrograms->toArray(), 'Training Programs retrieved successfully');
    }

    /**
     * Store a newly created TrainingProgram in storage.
     * POST /training-programs
     */
    public function store(CreateTrainingProgramAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $trainingProgram = $this->trainingProgramRepository->create($input);

        return $this->sendResponse($trainingProgram->toArray(), 'Training Program saved successfully');
    }

    /**
     * Display the specified TrainingProgram.
     * GET|HEAD /training-programs/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var TrainingProgram $trainingProgram */
        $trainingProgram = $this->trainingProgramRepository->find($id);

        if (empty($trainingProgram)) {
            return $this->sendError('Training Program not found');
        }

        return $this->sendResponse($trainingProgram->toArray(), 'Training Program retrieved successfully');
    }

    /**
     * Update the specified TrainingProgram in storage.
     * PUT/PATCH /training-programs/{id}
     */
    public function update($id, UpdateTrainingProgramAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var TrainingProgram $trainingProgram */
        $trainingProgram = $this->trainingProgramRepository->find($id);

        if (empty($trainingProgram)) {
            return $this->sendError('Training Program not found');
        }

        $trainingProgram = $this->trainingProgramRepository->update($input, $id);

        return $this->sendResponse($trainingProgram->toArray(), 'TrainingProgram updated successfully');
    }

    /**
     * Remove the specified TrainingProgram from storage.
     * DELETE /training-programs/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var TrainingProgram $trainingProgram */
        $trainingProgram = $this->trainingProgramRepository->find($id);

        if (empty($trainingProgram)) {
            return $this->sendError('Training Program not found');
        }

        $trainingProgram->delete();

        return $this->sendSuccess('Training Program deleted successfully');
    }
}
