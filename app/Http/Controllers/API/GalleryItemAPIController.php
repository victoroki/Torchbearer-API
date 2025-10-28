<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGalleryItemAPIRequest;
use App\Http\Requests\API\UpdateGalleryItemAPIRequest;
use App\Models\GalleryItem;
use App\Repositories\GalleryItemRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class GalleryItemAPIController
 */
class GalleryItemAPIController extends AppBaseController
{
    private GalleryItemRepository $galleryItemRepository;

    public function __construct(GalleryItemRepository $galleryItemRepo)
    {
        $this->galleryItemRepository = $galleryItemRepo;
    }

    /**
     * Display a listing of the GalleryItems.
     * GET|HEAD /gallery-items
     */
    public function index(Request $request): JsonResponse
    {
        $galleryItems = $this->galleryItemRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($galleryItems->toArray(), 'Gallery Items retrieved successfully');
    }

    /**
     * Store a newly created GalleryItem in storage.
     * POST /gallery-items
     */
    public function store(CreateGalleryItemAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $galleryItem = $this->galleryItemRepository->create($input);

        return $this->sendResponse($galleryItem->toArray(), 'Gallery Item saved successfully');
    }

    /**
     * Display the specified GalleryItem.
     * GET|HEAD /gallery-items/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var GalleryItem $galleryItem */
        $galleryItem = $this->galleryItemRepository->find($id);

        if (empty($galleryItem)) {
            return $this->sendError('Gallery Item not found');
        }

        return $this->sendResponse($galleryItem->toArray(), 'Gallery Item retrieved successfully');
    }

    /**
     * Update the specified GalleryItem in storage.
     * PUT/PATCH /gallery-items/{id}
     */
    public function update($id, UpdateGalleryItemAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var GalleryItem $galleryItem */
        $galleryItem = $this->galleryItemRepository->find($id);

        if (empty($galleryItem)) {
            return $this->sendError('Gallery Item not found');
        }

        $galleryItem = $this->galleryItemRepository->update($input, $id);

        return $this->sendResponse($galleryItem->toArray(), 'GalleryItem updated successfully');
    }

    /**
     * Remove the specified GalleryItem from storage.
     * DELETE /gallery-items/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var GalleryItem $galleryItem */
        $galleryItem = $this->galleryItemRepository->find($id);

        if (empty($galleryItem)) {
            return $this->sendError('Gallery Item not found');
        }

        $galleryItem->delete();

        return $this->sendSuccess('Gallery Item deleted successfully');
    }
}
