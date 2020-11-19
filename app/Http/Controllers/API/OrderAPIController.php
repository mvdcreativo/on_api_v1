<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;



class OrderAPIController extends AppBaseController
{

    public function index(Request $request)
    {
        $query = Order::query();

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
        if ($request->get('user_id')) {
            $user_id = $request->get('user_id');
        }else{
            $user_id = "";
        }

        $orders = $query
            ->with('courses','currency')
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
        $order->save();
        $order->courses()->attach($request->get('products'));

        if($order->courses){
            $generate_payment = new MercadoPagoAPIController;
            return response()->json(["init_point" => $generate_payment->generate_payment_initpoint($order)], 200);
            // return $generate_payment->generate_payment_initpoint($order)
            // $res = $generate_payment;
            // return $generate_payment;
            
            
            // return $this->sendResponse($res->toArray(), 'Order saved successfully');
        }
        if ($request->get('pay') === "mp") {
        }

        // return $this->sendResponse($order->toArray(), 'Order saved successfully');    
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
