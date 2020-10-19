<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInstructorAPIRequest;
use App\Http\Requests\API\UpdateInstructorAPIRequest;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\API\UserAPIController;
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
            ->with('account')
            ->filter($filter)
            ->whereHas('account', function($q){
                $q->where('role_id', 1);
            })
            // ->whereIn('status_id', [1,3])
            // ->orderBy('user.name', $sort)
            ->paginate($per_page);


        return $this->sendResponse($user->toArray(), 'Statuses retrieved successfully');
    }
}
