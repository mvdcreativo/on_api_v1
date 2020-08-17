<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCourseSectionAPIRequest;
use App\Http\Requests\API\UpdateCourseSectionAPIRequest;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CourseSectionController
 * @package App\Http\Controllers\API
 */

class CourseSectionAPIController extends AppBaseController
{
    /**
     * Display a listing of the CourseSection.
     * GET|HEAD /courseSections
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = CourseSection::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $courseSections = $query->get();

        return $this->sendResponse($courseSections->toArray(), 'Course Sections retrieved successfully');
    }

    /**
     * Store a newly created CourseSection in storage.
     * POST /courseSections
     *
     * @param CreateCourseSectionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCourseSectionAPIRequest $request)
    {
        $input = $request->all();

        /** @var CourseSection $courseSection */
        $courseSection = CourseSection::create($input);

        return $this->sendResponse($courseSection->toArray(), 'Course Section saved successfully');
    }

    /**
     * Display the specified CourseSection.
     * GET|HEAD /courseSections/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CourseSection $courseSection */
        $courseSection = CourseSection::find($id);

        if (empty($courseSection)) {
            return $this->sendError('Course Section not found');
        }

        return $this->sendResponse($courseSection->toArray(), 'Course Section retrieved successfully');
    }

    /**
     * Update the specified CourseSection in storage.
     * PUT/PATCH /courseSections/{id}
     *
     * @param int $id
     * @param UpdateCourseSectionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourseSectionAPIRequest $request)
    {
        /** @var CourseSection $courseSection */
        $courseSection = CourseSection::find($id);

        if (empty($courseSection)) {
            return $this->sendError('Course Section not found');
        }

        $courseSection->fill($request->all());
        $courseSection->save();

        return $this->sendResponse($courseSection->toArray(), 'CourseSection updated successfully');
    }

    /**
     * Remove the specified CourseSection from storage.
     * DELETE /courseSections/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CourseSection $courseSection */
        $courseSection = CourseSection::find($id);

        if (empty($courseSection)) {
            return $this->sendError('Course Section not found');
        }

        $courseSection->delete();

        return $this->sendSuccess('Course Section deleted successfully');
    }
}
