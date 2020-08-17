<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCourseAPIRequest;
use App\Http\Requests\API\UpdateCourseAPIRequest;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CourseController
 * @package App\Http\Controllers\API
 */

class CourseAPIController extends AppBaseController
{
    /**
     * Display a listing of the Course.
     * GET|HEAD /courses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $courses = $query->with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency')
        ->whereIn('status_id', [1,3])
        ->get();

        return $this->sendResponse($courses->toArray(), 'Courses retrieved successfully');
    }

    /**
     * Store a newly created Course in storage.
     * POST /courses
     *
     * @param CreateCourseAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCourseAPIRequest $request)
    {
        $input = $request->all();

        /** @var Course $course */
        $course = Course::create($input);

        return $this->sendResponse($course->toArray(), 'Course saved successfully');
    }

    /**
     * Display the specified Course.
     * GET|HEAD /courses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Course $course */
        $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency')
        ->whereIn('status_id', [1,3])
        ->find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        return $this->sendResponse($course->toArray(), 'Course retrieved successfully');
    }





    /**
     * Update the specified Course in storage.
     * PUT/PATCH /courses/{id}
     *
     * @param int $id
     * @param UpdateCourseAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourseAPIRequest $request)
    {
        /** @var Course $course */
        $course = Course::find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        $course->fill($request->all());
        $course->save();

        return $this->sendResponse($course->toArray(), 'Course updated successfully');
    }



    /**
     * Remove the specified Course from storage.
     * DELETE /courses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Course $course */
        $course = Course::find($id);

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        $course->delete();

        return $this->sendSuccess('Course deleted successfully');
    }





            /**
     * Display the specified Course.
     * GET|HEAD /course/{slug}
     *
     * @param string $slug
     *
     * @return Response
     */
    public function showBySlug($slug)
    {
        /** @var Course $course */
        $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency','adquiredSkills', 'level', 'schedules')
                ->where('slug',$slug)
                ->whereIn('status_id', [1,3])
                ->first();

        if (empty($course)) {
            return $this->sendError('Course not found');
        }

        return $this->sendResponse($course->toArray(), 'Course retrieved successfully');
    }



    /**
     * Display a listing of the Course by slug Category
     * GET|HEAD courses-category/{slug}
     *
     * @param String $slug
     * @return Response
     */
    public function getByCategorySlug($slug)
    {
        $category = Category::select(['id','slug','color'])
        ->with('courses','courses.courseSections', 'courses.lengthUnit','courses.categories', 'courses.currency', 'courses.user_instructor')
        ->filter_status()
        ->where('slug',$slug)
        // ->whereIn('status_id', [1,3])
        ->firstOrFail();

        $courses = $category;

        // $course = Course::with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency')
        // ->where('category_id',$category_id)->get();

        if (empty($courses)) {
            return $this->sendError('Course not found');
        }

        return $this->sendResponse($courses->toArray(), 'Course retrieved successfully');
    }


    /**
     * Display a listing of the Course destac
     * GET|HEAD courses-destac/
     *
     * @param String $slug
     * @return Response
     */
    public function getCoursesDestac(Request $request)
    {
        $query = Course::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $courses = $query->with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency')
        ->where('status_id', 3)
        ->get();

        return $this->sendResponse($courses->toArray(), 'Courses retrieved successfully');     
    }

    

}
