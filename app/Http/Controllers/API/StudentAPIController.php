<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\UserAPIController;
use App\User;

class StudentAPIController  extends UserAPIController
{
    //

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
            ->whereHas('account', function($q){
                $q->where('role_id', 2);
            })            ->filter($filter)
            // ->whereIn('status_id', [1,3])
            // ->orderBy('user.name', $sort)
            ->paginate($per_page);

        return $this->sendResponse($user->toArray(), 'Statuses retrieved successfully');
    }
}
