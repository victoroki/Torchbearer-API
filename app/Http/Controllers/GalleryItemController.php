<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGalleryItemRequest;
use App\Http\Requests\UpdateGalleryItemRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\GalleryItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Flash;

class GalleryItemController extends AppBaseController
{
    /** @var GalleryItemRepository $galleryItemRepository*/
    private $galleryItemRepository;

    public function __construct(GalleryItemRepository $galleryItemRepo)
    {
        $this->galleryItemRepository = $galleryItemRepo;
    }

    /**
     * Display a listing of the GalleryItem.
     */
    public function index(Request $request)
    {
        $galleryItems = $this->galleryItemRepository->paginate(10);

        return view('gallery_items.index')
            ->with('galleryItems', $galleryItems);
    }

    /**
     * Show the form for creating a new GalleryItem.
     */
    public function create()
    {
        return view('gallery_items.create');
    }

    /**
     * Store a newly created GalleryItem in storage.
     */
    public function store(CreateGalleryItemRequest $request)
    {
        $input = $request->all();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Generate unique filename
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store file in public/storage/gallery
            $filePath = $file->storeAs('gallery', $fileName, 'public');
            
            // Save the file path in database
            $input['file_url'] = '/storage/' . $filePath;
            
            // Optional: Store original filename
            $input['original_filename'] = $file->getClientOriginalName();
            
            // Optional: Store file size
            $input['file_size'] = $file->getSize();
            
            // Optional: Store mime type
            $input['mime_type'] = $file->getMimeType();
        }

        $galleryItem = $this->galleryItemRepository->create($input);

        Flash::success('Gallery Item saved successfully.');

        return redirect(route('gallery-items.index'));
    }

    /**
     * Display the specified GalleryItem.
     */
    public function show($id)
    {
        $galleryItem = $this->galleryItemRepository->find($id);

        if (empty($galleryItem)) {
            Flash::error('Gallery Item not found');
            return redirect(route('gallery-items.index'));
        }

        return view('gallery_items.show')->with('galleryItem', $galleryItem);
    }

    /**
     * Show the form for editing the specified GalleryItem.
     */
    public function edit($id)
    {
        $galleryItem = $this->galleryItemRepository->find($id);

        if (empty($galleryItem)) {
            Flash::error('Gallery Item not found');
            return redirect(route('gallery-items.index'));
        }

        return view('gallery_items.edit')->with('galleryItem', $galleryItem);
    }

    /**
     * Update the specified GalleryItem in storage.
     */
    public function update($id, UpdateGalleryItemRequest $request)
    {
        $galleryItem = $this->galleryItemRepository->find($id);

        if (empty($galleryItem)) {
            Flash::error('Gallery Item not found');
            return redirect(route('gallery-items.index'));
        }

        $input = $request->all();

        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($galleryItem->file_url) {
                $oldFilePath = str_replace('/storage/', '', $galleryItem->file_url);
                Storage::disk('public')->delete($oldFilePath);
            }

            // Upload new file
            $file = $request->file('file');
            
            // Generate unique filename
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store file in public/storage/gallery
            $filePath = $file->storeAs('gallery', $fileName, 'public');
            
            // Save the file path in database
            $input['file_url'] = '/storage/' . $filePath;
            
            // Optional: Update original filename
            $input['original_filename'] = $file->getClientOriginalName();
            
            // Optional: Update file size
            $input['file_size'] = $file->getSize();
            
            // Optional: Update mime type
            $input['mime_type'] = $file->getMimeType();
        }

        $galleryItem = $this->galleryItemRepository->update($input, $id);

        Flash::success('Gallery Item updated successfully.');

        return redirect(route('gallery-items.index'));
    }

    /**
     * Remove the specified GalleryItem from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $galleryItem = $this->galleryItemRepository->find($id);

        if (empty($galleryItem)) {
            Flash::error('Gallery Item not found');
            return redirect(route('gallery-items.index'));
        }

        // Delete file from storage before deleting record
        if ($galleryItem->file_url) {
            $filePath = str_replace('/storage/', '', $galleryItem->file_url);
            Storage::disk('public')->delete($filePath);
        }

        $this->galleryItemRepository->delete($id);

        Flash::success('Gallery Item deleted successfully.');

        return redirect(route('gallery-items.index'));
    }
}