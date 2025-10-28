<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCourseAPIRequest;
use App\Http\Requests\API\UpdateCourseAPIRequest;
use App\Models\Course;
use App\Repositories\CourseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CourseAPIController
 */
class CourseAPIController extends AppBaseController
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepo)
    {
        $this->courseRepository = $courseRepo;
    }

    /**
     * Display a listing of the Courses.
     * GET|HEAD /courses
     */
    public function index(Request $request): JsonResponse
    {
        $courses = $this->courseRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($courses->toArray(), 'Courses retrieved successfully');
    }

    /**
     * Store a newly created Course in storage.
     * POST /courses
     */
    public function store(CreateCourseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $course = $this->courseRepository->create($input);

        return $this->sendResponse($course->toArray(), 'Course saved successfully');
    }

    /**
     * Display the specified Course.
     * GET|HEAD /courses/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Course $course */
        $course = $this->courseRepository->find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        return $this->sendResponse($course->toArray(), 'Course retrieved successfully');
    }

    /**
     * Update the specified Course in storage.
     * PUT/PATCH /courses/{id}
     */
    public function update($id, UpdateCourseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Course $course */
        $course = $this->courseRepository->find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        $course = $this->courseRepository->update($input, $id);

        return $this->sendResponse($course->toArray(), 'Course updated successfully');
    }

    /**
     * Remove the specified Course from storage.
     * DELETE /courses/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Course $course */
        $course = $this->courseRepository->find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        $course->delete();

        return $this->sendSuccess('Course deleted successfully');
    }
}
