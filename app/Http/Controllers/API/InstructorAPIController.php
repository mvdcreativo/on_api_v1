<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInstructorAPIRequest;
use App\Http\Requests\API\UpdateInstructorAPIRequest;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\API\UserAPIController;
use App\Models\Course;
use App\User;
use Response;

/**
 * Class InstructorController
 * @package App\Http\Controllers\API
 */

class InstructorAPIController extends UserAPIController
{
    /**
     * Display a listing of the Instructor.
     * GET|HEAD /instructors
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->get('per_page')) {
            $per_page = $request->get('per_page');
        }else{
            $per_page = 20;
        }
        
        if ($request->get('sort')) {
            $sort = $request->get('sort');
        }else{
            $sort = "desc";
        }

        if ($request->get('filter')) {
            $filter = $request->get('filter');
        }else{
            $filter = "";
        }

        $user = $query
            ->with('account', 'courses_instructor')
            ->filter($filter)
            ->whereHas('account', function($q){
                $q->where('role_id', 1);
            })
            // ->whereIn('status_id', [1,3])
            // ->orderBy('user.name', $sort)
            ->paginate($per_page);

        return $this->sendResponse($user->toArray(), 'Statuses retrieved successfully');
    }


    

    public function show($slug)
    {
        $user = User::with('account', 'courses_instructor')->where('slug', $slug)->first();

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }


    public function courses_instructor(Request $request)
    {
        $query = Course::query();


        $courses = $query->with('categories', 'lengthUnit', 'user_instructor', 'courseSections', 'currency')
        ->whereIn('status_id', [1,3])
        ->where('user_instructor_id', $request->get('instructor_id'))
        ->get();

        return $this->sendResponse($courses->toArray(), 'Courses retrieved successfully');
    }
}
