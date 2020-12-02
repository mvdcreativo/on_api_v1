<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;



class OrderAPIController extends AppBaseController
{

    public function index(Request $request)
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
            ->filter($filter)
            ->user($user_id)
            // ->whereIn('status_id', [1,3])
            ->orderBy('id', $sort)
            ->paginate($per_page);

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $input = $request->all();
        $order = new Order;
        $order->fill($input);


        if (count($request->get('products')) >= 1) {


            foreach ($request->get('products') as $key => $product) {

                $course = Course::find($product['course_id']);

                $cupos_confirmed = $course->cupos_confirmed;

                if ($cupos_confirmed < $course->cupos) {
                    $course->cupos_confirmed = $cupos_confirmed + 1;
                    if ($course->cupos_confirmed >= $course->cupos){
                        $course->status_id = 2;
                        $course->save();
                        $new_course = Course::whereIn('original_id', [$course->original_id, $course->id])
                            ->where('group', $course->group + 1)
                            ->first();
                        $new_course->status_id = 1;
                        $new_course->save();
                        
                    } 
                        

                } else {
                    $course->status_id = 2;
                    $course->save();
                    $new_course = Course::whereIn('original_id', [$course->original_id, $course->id])
                        ->where('group', $course->group + 1)
                        ->first();
                    $new_course->status_id = 1;
                    $new_course->save();

                    return response()->json(
                        [
                            "course" => $course,
                            "new_course" => $new_course,
                            "message" => "Los cupos estan completos"
                        ],
                        200
                    );
                }
            }
            $order->save();
            $order->courses()->attach($request->get('products'));
            $generate_payment = new MercadoPagoAPIController;
            if($order->courses) {
                return response()->json(["init_point" => $generate_payment->generate_payment_initpoint($order)], 200);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $order = Order::with('courses')->find($id);

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        foreach ($order->courses as $key => $o) {
            $o->pivot->currency = $o->pivot->currency;
        }
        return $this->sendResponse($order->toArray(), 'Order retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        return $this->sendResponse($order->toArray(), 'Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        $order->delete();

        return $this->sendSuccess('Order deleted successfully');
    }
}
