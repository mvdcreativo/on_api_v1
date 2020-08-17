<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLevelAPIRequest;
use App\Http\Requests\API\UpdateLevelAPIRequest;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LevelController
 * @package App\Http\Controllers\API
 */

class LevelAPIController extends AppBaseController
{
    /**
     * Display a listing of the Level.
     * GET|HEAD /levels
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Level::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $levels = $query->get();

        return $this->sendResponse($levels->toArray(), 'Levels retrieved successfully');
    }

    /**
     * Store a newly created Level in storage.
     * POST /levels
     *
     * @param CreateLevelAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateLevelAPIRequest $request)
    {
        $input = $request->all();

        /** @var Level $level */
        $level = Level::create($input);

        return $this->sendResponse($level->toArray(), 'Level saved successfully');
    }

    /**
     * Display the specified Level.
     * GET|HEAD /levels/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Level $level */
        $level = Level::find($id);

        if (empty($level)) {
            return $this->sendError('Level not found');
        }

        return $this->sendResponse($level->toArray(), 'Level retrieved successfully');
    }

    /**
     * Update the specified Level in storage.
     * PUT/PATCH /levels/{id}
     *
     * @param int $id
     * @param UpdateLevelAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLevelAPIRequest $request)
    {
        /** @var Level $level */
        $level = Level::find($id);

        if (empty($level)) {
            return $this->sendError('Level not found');
        }

        $level->fill($request->all());
        $level->save();

        return $this->sendResponse($level->toArray(), 'Level updated successfully');
    }

    /**
     * Remove the specified Level from storage.
     * DELETE /levels/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Level $level */
        $level = Level::find($id);

        if (empty($level)) {
            return $this->sendError('Level not found');
        }

        $level->delete();

        return $this->sendSuccess('Level deleted successfully');
    }
}
