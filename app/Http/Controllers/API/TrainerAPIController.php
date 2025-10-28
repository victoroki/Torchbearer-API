<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTrainerAPIRequest;
use App\Http\Requests\API\UpdateTrainerAPIRequest;
use App\Models\Trainer;
use App\Repositories\TrainerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TrainerAPIController
 */
class TrainerAPIController extends AppBaseController
{
    private TrainerRepository $trainerRepository;

    public function __construct(TrainerRepository $trainerRepo)
    {
        $this->trainerRepository = $trainerRepo;
    }

    /**
     * Display a listing of the Trainers.
     * GET|HEAD /trainers
     */
    public function index(Request $request): JsonResponse
    {
        $trainers = $this->trainerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($trainers->toArray(), 'Trainers retrieved successfully');
    }

    /**
     * Store a newly created Trainer in storage.
     * POST /trainers
     */
    public function store(CreateTrainerAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $trainer = $this->trainerRepository->create($input);

        return $this->sendResponse($trainer->toArray(), 'Trainer saved successfully');
    }

    /**
     * Display the specified Trainer.
     * GET|HEAD /trainers/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Trainer $trainer */
        $trainer = $this->trainerRepository->find($id);

        if (empty($trainer)) {
            return $this->sendError('Trainer not found');
        }

        return $this->sendResponse($trainer->toArray(), 'Trainer retrieved successfully');
    }

    /**
     * Update the specified Trainer in storage.
     * PUT/PATCH /trainers/{id}
     */
    public function update($id, UpdateTrainerAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Trainer $trainer */
        $trainer = $this->trainerRepository->find($id);

        if (empty($trainer)) {
            return $this->sendError('Trainer not found');
        }

        $trainer = $this->trainerRepository->update($input, $id);

        return $this->sendResponse($trainer->toArray(), 'Trainer updated successfully');
    }

    /**
     * Remove the specified Trainer from storage.
     * DELETE /trainers/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Trainer $trainer */
        $trainer = $this->trainerRepository->find($id);

        if (empty($trainer)) {
            return $this->sendError('Trainer not found');
        }

        $trainer->delete();

        return $this->sendSuccess('Trainer deleted successfully');
    }
}
