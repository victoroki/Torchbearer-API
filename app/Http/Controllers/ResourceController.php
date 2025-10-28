<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ResourceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Flash;

class ResourceController extends AppBaseController
{
    /** @var ResourceRepository $resourceRepository*/
    private $resourceRepository;

    public function __construct(ResourceRepository $resourceRepo)
    {
        $this->resourceRepository = $resourceRepo;
    }

    /**
     * Display a listing of the Resource.
     */
    public function index(Request $request)
    {
        $resources = $this->resourceRepository->paginate(10);

        return view('resources.index')
            ->with('resources', $resources);
    }

    /**
     * Show the form for creating a new Resource.
     */
    public function create()
    {
        return view('resources.create');
    }



    /**
     * Display the specified Resource.
     */
    public function show($id)
    {
        $resource = $this->resourceRepository->find($id);

        if (empty($resource)) {
            Flash::error('Resource not found');
            return redirect(route('resources.index'));
        }

        return view('resources.show')->with('resource', $resource);
    }

    /**
     * Show the form for editing the specified Resource.
     */
    public function edit($id)
    {
        $resource = $this->resourceRepository->find($id);

        if (empty($resource)) {
            Flash::error('Resource not found');
            return redirect(route('resources.index'));
        }

        return view('resources.edit')->with('resource', $resource);
    }

/**
 * Store a newly created Resource in storage.
 */
public function store(CreateResourceRequest $request)
{
    $input = $request->all();

    // Handle file upload
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        
        // Generate unique filename
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store file in public/storage/resources
        $filePath = $file->storeAs('resources', $fileName, 'public');
        
        // Save the file path in database
        $input['file_url'] = '/storage/' . $filePath;
        
        // Calculate and store file size
        $fileSize = $file->getSize();
        if ($fileSize < 1024) {
            $input['size'] = $fileSize . ' B';
        } elseif ($fileSize < 1048576) {
            $input['size'] = round($fileSize / 1024, 2) . ' KB';
        } else {
            $input['size'] = round($fileSize / 1048576, 2) . ' MB';
        }
    }

    // Convert tags from comma-separated string to JSON array
    if (isset($input['tags']) && is_string($input['tags'])) {
        $tagsArray = array_map('trim', explode(',', $input['tags']));
        $input['tags'] = json_encode($tagsArray);
    } else {
        $input['tags'] = json_encode([]);
    }

    // Set default values
    $input['downloads'] = 0;
    $input['featured'] = isset($input['featured']) ? 1 : 0;
    $input['preview'] = isset($input['preview']) ? 1 : 0;

    $resource = $this->resourceRepository->create($input);

    Flash::success('Resource saved successfully.');

    return redirect(route('resources.index'));
}

/**
 * Update the specified Resource in storage.
 */
public function update($id, UpdateResourceRequest $request)
{
    $resource = $this->resourceRepository->find($id);

    if (empty($resource)) {
        Flash::error('Resource not found');
        return redirect(route('resources.index'));
    }

    $input = $request->all();

    // Handle file upload if new file is provided
    if ($request->hasFile('file')) {
        // Delete old file if exists
        if ($resource->file_url) {
            $oldFilePath = str_replace('/storage/', '', $resource->file_url);
            Storage::disk('public')->delete($oldFilePath);
        }

        // Upload new file
        $file = $request->file('file');
        
        // Generate unique filename
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store file in public/storage/resources
        $filePath = $file->storeAs('resources', $fileName, 'public');
        
        // Save the file path in database
        $input['file_url'] = '/storage/' . $filePath;
        
        // Calculate and store file size
        $fileSize = $file->getSize();
        if ($fileSize < 1024) {
            $input['size'] = $fileSize . ' B';
        } elseif ($fileSize < 1048576) {
            $input['size'] = round($fileSize / 1024, 2) . ' KB';
        } else {
            $input['size'] = round($fileSize / 1048576, 2) . ' MB';
        }
    }

    // Convert tags from comma-separated string to JSON array
    if (isset($input['tags']) && is_string($input['tags'])) {
        $tagsArray = array_map('trim', explode(',', $input['tags']));
        $input['tags'] = json_encode($tagsArray);
    }

    // Set default values
    $input['featured'] = isset($input['featured']) ? 1 : 0;
    $input['preview'] = isset($input['preview']) ? 1 : 0;

    $resource = $this->resourceRepository->update($input, $id);

    Flash::success('Resource updated successfully.');

    return redirect(route('resources.index'));
}

    /**
     * Remove the specified Resource from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $resource = $this->resourceRepository->find($id);

        if (empty($resource)) {
            Flash::error('Resource not found');
            return redirect(route('resources.index'));
        }

        // Delete file from storage before deleting record
        if ($resource->file_url) {
            $filePath = str_replace('/storage/', '', $resource->file_url);
            Storage::disk('public')->delete($filePath);
        }

        $this->resourceRepository->delete($id);

        Flash::success('Resource deleted successfully.');

        return redirect(route('resources.index'));
    }
}