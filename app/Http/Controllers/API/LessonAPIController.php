<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLessonAPIRequest;
use App\Http\Requests\API\UpdateLessonAPIRequest;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LessonController
 * @package App\Http\Controllers\API
 */

class LessonAPIController extends AppBaseController
{
    /**
     * Display a listing of the Lesson.
     * GET|HEAD /lessons
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Lesson::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $lessons = $query->get();

        return $this->sendResponse($lessons->toArray(), 'Lessons retrieved successfully');
    }

    /**
     * Store a newly created Lesson in storage.
     * POST /lessons
     *
     * @param CreateLessonAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLessonAPIRequest $request)
    {
        $input = $request->all();

        /** @var Lesson $lesson */
        $lesson = Lesson::create($input);

        return $this->sendResponse($lesson->toArray(), 'Lesson saved successfully');
    }

    /**
     * Display the specified Lesson.
     * GET|HEAD /lessons/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return $this->sendError('Lesson not found');
        }

        return $this->sendResponse($lesson->toArray(), 'Lesson retrieved successfully');
    }

    /**
     * Update the specified Lesson in storage.
     * PUT/PATCH /lessons/{id}
     *
     * @param int $id
     * @param UpdateLessonAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLessonAPIRequest $request)
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return $this->sendError('Lesson not found');
        }

        $lesson->fill($request->all());
        $lesson->save();

        return $this->sendResponse($lesson->toArray(), 'Lesson updated successfully');
    }

    /**
     * Remove the specified Lesson from storage.
     * DELETE /lessons/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return $this->sendError('Lesson not found');
        }

        $lesson->delete();

        return $this->sendSuccess('Lesson deleted successfully');
    }
}
