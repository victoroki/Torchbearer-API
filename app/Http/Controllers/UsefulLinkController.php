<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsefulLinkRequest;
use App\Http\Requests\UpdateUsefulLinkRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\UsefulLinkRepository;
use Illuminate\Http\Request;
use Flash;

class UsefulLinkController extends AppBaseController
{
    /** @var UsefulLinkRepository $usefulLinkRepository*/
    private $usefulLinkRepository;

    public function __construct(UsefulLinkRepository $usefulLinkRepo)
    {
        $this->usefulLinkRepository = $usefulLinkRepo;
    }

    /**
     * Display a listing of the UsefulLink.
     */
    public function index(Request $request)
    {
        $usefulLinks = $this->usefulLinkRepository->paginate(10);

        return view('useful_links.index')
            ->with('usefulLinks', $usefulLinks);
    }

    /**
     * Show the form for creating a new UsefulLink.
     */
    public function create()
    {
        return view('useful_links.create');
    }

    /**
     * Store a newly created UsefulLink in storage.
     */
    public function store(CreateUsefulLinkRequest $request)
    {
        $input = $request->all();

        $usefulLink = $this->usefulLinkRepository->create($input);

        Flash::success('Useful Link saved successfully.');

        return redirect(route('useful-links.index'));
    }

    /**
     * Display the specified UsefulLink.
     */
    public function show($id)
    {
        $usefulLink = $this->usefulLinkRepository->find($id);

        if (empty($usefulLink)) {
            Flash::error('Useful Link not found');

            return redirect(route('useful-links.index'));
        }

        return view('useful_links.show')->with('usefulLink', $usefulLink);
    }

    /**
     * Show the form for editing the specified UsefulLink.
     */
    public function edit($id)
    {
        $usefulLink = $this->usefulLinkRepository->find($id);

        if (empty($usefulLink)) {
            Flash::error('Useful Link not found');

            return redirect(route('useful-links.index'));
        }

        return view('useful_links.edit')->with('usefulLink', $usefulLink);
    }

    /**
     * Update the specified UsefulLink in storage.
     */
    public function update($id, UpdateUsefulLinkRequest $request)
    {
        $usefulLink = $this->usefulLinkRepository->find($id);

        if (empty($usefulLink)) {
            Flash::error('Useful Link not found');

            return redirect(route('useful-links.index'));
        }

        $usefulLink = $this->usefulLinkRepository->update($request->all(), $id);

        Flash::success('Useful Link updated successfully.');

        return redirect(route('useful-links.index'));
    }

    /**
     * Remove the specified UsefulLink from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $usefulLink = $this->usefulLinkRepository->find($id);

        if (empty($usefulLink)) {
            Flash::error('Useful Link not found');

            return redirect(route('useful-links.index'));
        }

        $this->usefulLinkRepository->delete($id);

        Flash::success('Useful Link deleted successfully.');

        return redirect(route('useful-links.index'));
    }
}
