<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NotificationMercadoPago;
use App\Models\Order;
use App\Models\Status;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class NotificationMercadoPagoController extends Controller
{
    public function store(Request $request)
    {
        

        
        $notification = new NotificationMercadoPago;

        $notification->topic = $request->topic;
        $notification->id_notificacion = $request->id;
        $notification->save();

        // return $request;
        if($notification->topic && $notification->topic === "merchant_order"){
            
            $id = $notification->id_notificacion;
            $order_mp_client = new Client();
            $url_merchant_orders = 'https://api.mercadopago.com//merchant_orders/';

            try {
                $response = $order_mp_client->request('GET',$url_merchant_orders.$id.'?access_token='.env('MP_TOKEN'));
            }
            catch (ClientException $e) {
                $response = $e->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();
                return $responseBodyAsString;
            }
            $respuesta = json_decode($response->getBody(), true);
     
            //actualiza orden
            $order_local = Order::find($respuesta['external_reference']);
            // $order_local->payment_metod_mp = $respuesta['payment_metod'];
            $order_local->order_id_mp = $respuesta['id'];
            $order_local->order_status_mp = $respuesta['order_status'];
            $order_local->cancelled_mp = $respuesta['cancelled'];
            $order_local->status_mp = $respuesta['status'];


            $status = Status::where('slug', "=", $respuesta['order_status'])->first();
            $order_local->status_id = $status->id;

            if($respuesta['payments']){
                $paiment_mp_client = new Client();
                $url_payment = 'https://api.mercadopago.com/v1/payments/';
                $id_payment = $respuesta['payments'][0]['id'];
                $response_payment = $paiment_mp_client->request('GET',$url_payment.$id_payment.'?access_token='.env('MP_TOKEN'));
                $respuesta_payment = json_decode($response_payment->getBody(), true);

                $order_local->payment_metod_mp = $respuesta_payment['payment_method_id'];
            }

            $order_local->save();

            return $order_local;
        }
        
        // return $notification;
        return response()->json("ok", 200);

    }
}
