<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLicenseClassAPIRequest;
use App\Http\Requests\API\UpdateLicenseClassAPIRequest;
use App\Models\LicenseClass;
use App\Repositories\LicenseClassRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class LicenseClassAPIController
 */
class LicenseClassAPIController extends AppBaseController
{
    private LicenseClassRepository $licenseClassRepository;

    public function __construct(LicenseClassRepository $licenseClassRepo)
    {
        $this->licenseClassRepository = $licenseClassRepo;
    }

    /**
     * Display a listing of the LicenseClasses.
     * GET|HEAD /license-classes
     */
    public function index(Request $request): JsonResponse
    {
        $licenseClasses = $this->licenseClassRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($licenseClasses->toArray(), 'License Classes retrieved successfully');
    }

    /**
     * Store a newly created LicenseClass in storage.
     * POST /license-classes
     */
    public function store(CreateLicenseClassAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $licenseClass = $this->licenseClassRepository->create($input);

        return $this->sendResponse($licenseClass->toArray(), 'License Class saved successfully');
    }

    /**
     * Display the specified LicenseClass.
     * GET|HEAD /license-classes/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var LicenseClass $licenseClass */
        $licenseClass = $this->licenseClassRepository->find($id);

        if (empty($licenseClass)) {
            return $this->sendError('License Class not found');
        }

        return $this->sendResponse($licenseClass->toArray(), 'License Class retrieved successfully');
    }

    /**
     * Update the specified LicenseClass in storage.
     * PUT/PATCH /license-classes/{id}
     */
    public function update($id, UpdateLicenseClassAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var LicenseClass $licenseClass */
        $licenseClass = $this->licenseClassRepository->find($id);

        if (empty($licenseClass)) {
            return $this->sendError('License Class not found');
        }

        $licenseClass = $this->licenseClassRepository->update($input, $id);

        return $this->sendResponse($licenseClass->toArray(), 'LicenseClass updated successfully');
    }

    /**
     * Remove the specified LicenseClass from storage.
     * DELETE /license-classes/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var LicenseClass $licenseClass */
        $licenseClass = $this->licenseClassRepository->find($id);

        if (empty($licenseClass)) {
            return $this->sendError('License Class not found');
        }

        $licenseClass->delete();

        return $this->sendSuccess('License Class deleted successfully');
    }
}
