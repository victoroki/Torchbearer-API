<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLicenseClassRequest;
use App\Http\Requests\UpdateLicenseClassRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\LicenseClassRepository;
use Illuminate\Http\Request;
use Flash;

class LicenseClassController extends AppBaseController
{
    /** @var LicenseClassRepository $licenseClassRepository*/
    private $licenseClassRepository;

    public function __construct(LicenseClassRepository $licenseClassRepo)
    {
        $this->licenseClassRepository = $licenseClassRepo;
    }

    /**
     * Display a listing of the LicenseClass.
     */
    public function index(Request $request)
    {
        $licenseClasses = $this->licenseClassRepository->paginate(10);

        return view('license_classes.index')
            ->with('licenseClasses', $licenseClasses);
    }

    /**
     * Show the form for creating a new LicenseClass.
     */
    public function create()
    {
        return view('license_classes.create');
    }

    /**
     * Store a newly created LicenseClass in storage.
     */
    public function store(CreateLicenseClassRequest $request)
    {
        $input = $request->all();

        $licenseClass = $this->licenseClassRepository->create($input);

        Flash::success('License Class saved successfully.');

        return redirect(route('licenseClasses.index'));
    }

    /**
     * Display the specified LicenseClass.
     */
    public function show($id)
    {
        $licenseClass = $this->licenseClassRepository->find($id);

        if (empty($licenseClass)) {
            Flash::error('License Class not found');

            return redirect(route('licenseClasses.index'));
        }

        return view('license_classes.show')->with('licenseClass', $licenseClass);
    }

    /**
     * Show the form for editing the specified LicenseClass.
     */
    public function edit($id)
    {
        $licenseClass = $this->licenseClassRepository->find($id);

        if (empty($licenseClass)) {
            Flash::error('License Class not found');

            return redirect(route('licenseClasses.index'));
        }

        return view('license_classes.edit')->with('licenseClass', $licenseClass);
    }

    /**
     * Update the specified LicenseClass in storage.
     */
    public function update($id, UpdateLicenseClassRequest $request)
    {
        $licenseClass = $this->licenseClassRepository->find($id);

        if (empty($licenseClass)) {
            Flash::error('License Class not found');

            return redirect(route('licenseClasses.index'));
        }

        $licenseClass = $this->licenseClassRepository->update($request->all(), $id);

        Flash::success('License Class updated successfully.');

        return redirect(route('licenseClasses.index'));
    }

    /**
     * Remove the specified LicenseClass from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $licenseClass = $this->licenseClassRepository->find($id);

        if (empty($licenseClass)) {
            Flash::error('License Class not found');

            return redirect(route('licenseClasses.index'));
        }

        $this->licenseClassRepository->delete($id);

        Flash::success('License Class deleted successfully.');

        return redirect(route('licenseClasses.index'));
    }
}
