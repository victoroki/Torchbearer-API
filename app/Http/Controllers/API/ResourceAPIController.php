<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResourceAPIRequest;
use App\Http\Requests\API\UpdateResourceAPIRequest;
use App\Models\Resource;
use App\Repositories\ResourceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ResourceAPIController
 */
class ResourceAPIController extends AppBaseController
{
    private ResourceRepository $resourceRepository;

    public function __construct(ResourceRepository $resourceRepo)
    {
        $this->resourceRepository = $resourceRepo;
    }

    /**
     * Display a listing of the Resources.
     * GET|HEAD /resources
     */
    public function index(Request $request): JsonResponse
    {
        $resources = $this->resourceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($resources->toArray(), 'Resources retrieved successfully');
    }

    /**
     * Store a newly created Resource in storage.
     * POST /resources
     */
    public function store(CreateResourceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $resource = $this->resourceRepository->create($input);

        return $this->sendResponse($resource->toArray(), 'Resource saved successfully');
    }

    /**
     * Display the specified Resource.
     * GET|HEAD /resources/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Resource $resource */
        $resource = $this->resourceRepository->find($id);

        if (empty($resource)) {
            return $this->sendError('Resource not found');
        }

        return $this->sendResponse($resource->toArray(), 'Resource retrieved successfully');
    }

    /**
     * Update the specified Resource in storage.
     * PUT/PATCH /resources/{id}
     */
    public function update($id, UpdateResourceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Resource $resource */
        $resource = $this->resourceRepository->find($id);

        if (empty($resource)) {
            return $this->sendError('Resource not found');
        }

        $resource = $this->resourceRepository->update($input, $id);

        return $this->sendResponse($resource->toArray(), 'Resource updated successfully');
    }

    /**
     * Remove the specified Resource from storage.
     * DELETE /resources/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Resource $resource */
        $resource = $this->resourceRepository->find($id);

        if (empty($resource)) {
            return $this->sendError('Resource not found');
        }

        $resource->delete();

        return $this->sendSuccess('Resource deleted successfully');
    }
}
