<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\API\CreateScheduleAPIRequest;
use App\Http\Requests\API\UpdateScheduleAPIRequest;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;


class ScheduleAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Schedule::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $schedules = $query->get();

        return $this->sendResponse($schedules->toArray(), 'Adquired Skills retrieved successfully');    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateScheduleAPIRequest $request)
    {
        $input = $request->all();


        $schedules = Schedule::create($input);

        return $this->sendResponse($schedules->toArray(), 'Adquired Skill saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        $schedules = Schedule::find($schedule->id);

        if (empty($schedules)) {
            return $this->sendError('Adquired Skill not found');
        }

        return $this->sendResponse($schedules->toArray(), 'Adquired Skill retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Schedule $schedule,UpdateScheduleAPIRequest $request)
    {
        $schedules = Schedule::find($schedule->id);

        if (empty($schedules)) {
            return $this->sendError('Adquired Skill not found');
        }

        $schedules->fill($request->all());
        $schedules->save();

        return $this->sendResponse($schedules->toArray(), 'schedules updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $schedules = Schedule::find($schedule->id);

        if (empty($schedules)) {
            return $this->sendError('Adquired Skill not found');
        }

        $schedules->delete();
        return $this->sendResponse($schedules->toArray(), 'Adquired Skill deleted successfully');
    }
}
