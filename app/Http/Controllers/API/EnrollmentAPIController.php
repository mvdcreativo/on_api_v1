<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;

class EnrollmentAPIController extends OrderAPIController
{
    public function indexEnrollments(Request $request)
    {
        $query = Order::query();
        if ($request->get('per_page')) {
            $per_page = $request->get('per_page');
        } else {
            $per_page = 20;
        }

        if ($request->get('sort')) {
            $sort = $request->get('sort');
        } else {
            $sort = "desc";
        }

        if ($request->get('filter')) {
            $filter = $request->get('filter');
        } else {
            $filter = "";
        }
        if ($request->get('user_id')) {
            $user_id = $request->get('user_id');
        } else {
            $user_id = "";
        }


        $orders = $query
            ->with('courses', 'currency', 'user')
            ->filter_enroll($filter)
            ->user($user_id)
            // ->whereIn('status_id', [1,3])
            ->orderBy('id', $sort)
            ->paginate($per_page);

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully');

    }
}
