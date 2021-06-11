<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;

use App\Exports\StudentsCourseExport;
use App\Models\Status;
use Maatwebsite\Excel\Facades\Excel;


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
        if ($request->get('course_id')) {
            $course_id = $request->get('course_id');
        } else {
            $course_id = "";
        }

        
        
        $orders = $query
            ->with('courses', 'currency', 'user', 'status')
            ->filter($filter)
            ->user($user_id)
            ->course_id($course_id)
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
        if($request->get('payment_status_slug')){
            $status = Status::where('slug',$request->get('payment_status_slug'))->first();
            $order->status_id = $status->id;
        }else{
            $status = Status::where('slug','payment_required')->first();
            $order->status_id = $status->id;
        }
        


        if (count($request->get('products')) >= 1) {


            foreach ($request->get('products') as $key => $product) {

                $course = Course::find($product['course_id']);
                if (empty($course)) {
                    return $this->sendError('Course not found');
                }
                $cupos_confirmed = $course->cupos_confirmed;

                if ($cupos_confirmed <= $course->cupos) {
                    $course->cupos_confirmed = $cupos_confirmed + 1;
                    if ($course->cupos_confirmed >= $course->cupos){
                        $course->status_id = 2;
                        $course->save();
                        $new_course = Course::whereIn('original_id', [$course->original_id, $course->id])
                            ->where('group', $course->group + 1)
                            ->first();
                        if (empty($new_course)) {
                            return $this->sendError('New Course not found');
                        }
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
            $course->save();
            $order->save();
            $order->courses()->attach($request->get('products'));
            $order->courses;
            $order->user->account;
            
            if($request->get('type_pay') && $request->get('type_pay') == "PL"){
                return $this->sendResponse($order->toArray(), 'Order saved successfully');
            }
            if($order->courses) {
                $generate_payment = new MercadoPagoAPIController;
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

        $order = Order::with('courses','user','status')->find($id);

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
        $input = $request->all();
        $order = Order::find($id);
        $order->fill($input);
        if($request->get('payment_status_slug')){
            $status = Status::where('slug',$request->get('payment_status_slug'))->first();
            $order->status_id = $status->id;
        }
        


        if (count($request->get('products')) >= 1) {


            foreach ($request->get('products') as $key => $product) {

                $course = Course::find($product['course_id']);
                if (empty($course)) {
                    return $this->sendError('Course not found');
                }
                $cupos_confirmed = $course->cupos_confirmed;

                if ($cupos_confirmed <= $course->cupos) {
                    $course->cupos_confirmed = $cupos_confirmed + 1;
                    if ($course->cupos_confirmed >= $course->cupos){
                        $course->status_id = 2;
                        $course->save();
                        $new_course = Course::whereIn('original_id', [$course->original_id, $course->id])
                            ->where('group', $course->group + 1)
                            ->first();
                        if (empty($new_course)) {
                            return $this->sendError('New Course not found');
                        }
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
            $course->save();
            $order->save();
            $order->courses()->attach($request->get('products'));
            $order->courses;
            $order->user->account;
            
            if($request->get('type_pay') && $request->get('type_pay') == "PL"){
                return $this->sendResponse($order->toArray(), 'Order saved successfully');
            }
            if($order->courses) {
                $generate_payment = new MercadoPagoAPIController;
                return response()->json(["init_point" => $generate_payment->generate_payment_initpoint($order)], 200);
            }
        }

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




        ////////  EXPORTS ///////////   

        public function export_students_course_excel(Request $request){
            // Storage::disk('public')->put('images/productos',  $img);

            $course_id = $request->get('course_id');

            return Excel::download(new StudentsCourseExport($course_id), 'lista_alumnos.xlsx');
            
        }
       
        ///////////////////////
}
