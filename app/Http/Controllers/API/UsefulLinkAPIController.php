<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUsefulLinkAPIRequest;
use App\Http\Requests\API\UpdateUsefulLinkAPIRequest;
use App\Models\UsefulLink;
use App\Repositories\UsefulLinkRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class UsefulLinkAPIController
 */
class UsefulLinkAPIController extends AppBaseController
{
    private UsefulLinkRepository $usefulLinkRepository;

    public function __construct(UsefulLinkRepository $usefulLinkRepo)
    {
        $this->usefulLinkRepository = $usefulLinkRepo;
    }

    /**
     * Display a listing of the UsefulLinks.
     * GET|HEAD /useful-links
     */
    public function index(Request $request): JsonResponse
    {
        $usefulLinks = $this->usefulLinkRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($usefulLinks->toArray(), 'Useful Links retrieved successfully');
    }

    /**
     * Store a newly created UsefulLink in storage.
     * POST /useful-links
     */
    public function store(CreateUsefulLinkAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $usefulLink = $this->usefulLinkRepository->create($input);

        return $this->sendResponse($usefulLink->toArray(), 'Useful Link saved successfully');
    }

    /**
     * Display the specified UsefulLink.
     * GET|HEAD /useful-links/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var UsefulLink $usefulLink */
        $usefulLink = $this->usefulLinkRepository->find($id);

        if (empty($usefulLink)) {
            return $this->sendError('Useful Link not found');
        }

        return $this->sendResponse($usefulLink->toArray(), 'Useful Link retrieved successfully');
    }

    /**
     * Update the specified UsefulLink in storage.
     * PUT/PATCH /useful-links/{id}
     */
    public function update($id, UpdateUsefulLinkAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var UsefulLink $usefulLink */
        $usefulLink = $this->usefulLinkRepository->find($id);

        if (empty($usefulLink)) {
            return $this->sendError('Useful Link not found');
        }

        $usefulLink = $this->usefulLinkRepository->update($input, $id);

        return $this->sendResponse($usefulLink->toArray(), 'UsefulLink updated successfully');
    }

    /**
     * Remove the specified UsefulLink from storage.
     * DELETE /useful-links/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var UsefulLink $usefulLink */
        $usefulLink = $this->usefulLinkRepository->find($id);

        if (empty($usefulLink)) {
            return $this->sendError('Useful Link not found');
        }

        $usefulLink->delete();

        return $this->sendSuccess('Useful Link deleted successfully');
    }
}
