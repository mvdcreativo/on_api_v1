<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadoPagoAPIController extends AppBaseController
{
  public function __construct()
  {
    SDK::setAccessToken(
      config("payment-methods.mercadopago.access_token")
    );
    // SDK::setClientSecret(
    //       config("payment-methods.mercadopago.secret")
    //  );
  }

  public function generate_payment_initpoint(Order $order)
  {
    
    # Create a preference object
    $preference = new Preference();
    // dd($order);

    foreach ($order->courses as $key => $o) {
      $o->pivot->currency = $o->pivot->currency;
    }

     # Create an item object
    $items = Array();

    foreach ($order->courses as $product) {
      $item = new Item();
      $item->id = $product->id;
      $item->title = $product->title;
      // $item->category_id = "learnings";
      $item->description = $product->description;
      $item->quantity = $product->pivot->quantity;
      $item->currency_id = $product->pivot->currency->symbol;//"UYU" / "USD"
      $item->unit_price = $product->pivot->price;

      $items[] = $item;
    }
    // $item = new Item();
    // $item->id = 12456;
    // $item->title = "NOMBRE";
    // $item->quantity = 1;
    // $item->currency_id = 'UYU';
    // $item->unit_price = 5200;
    // $item->picture_url = asset("storage/");



    # Create a payer object
    $payer = new Payer();
    $payer->email = $order->email;
    $payer->name = $order->name;
    $payer->date_created  = $order->created_at;
    $payer->surname = $order->last_name;
    $payer->phone = array(
      "area_code" => "",
      "number" => $order->phone_one
    );

    $payer->identification = array(
      "type" => $order->type_doc_iden,
      "number" => $order->n_doc_iden
    );

    // $preference->binary_mode= true;
    
    # Setting preference properties
    $preference->items = $items;
    $preference->payer = $payer;


    # Save External Reference
    $preference->external_reference = $order->id;
    $preference->back_urls = [
      "success" => env('MP_URL_SUCCESS', 'https://oncapacitaciones.com/mi-cuenta'),
      "pending" => env('MP_URL_PENDING', 'https://oncapacitaciones.com/mi-cuenta'),
      "failure" => env('MP_URL_FAILURE', 'https://oncapacitaciones.com/mi-cuenta'),
    ];

    $preference->auto_return = "approved";
    $preference->notification_url = env('MP_URL_NOTIFICACION', 'https://api.oncapacitaciones.com/api/api/notification-cobro');
    // $preference->notification_url = 'http://mvdcreativo.servehttp.com/apiNuevaEra/public/api/notification-cobro';
    # Save and POST preference
    // dd($preference);
    $preference->save();

    if (config('payment-methods.use_sandbox')) {
      $init_point =  $preference->sandbox_init_point;
      return $init_point;
      
    }

    return $preference->init_point;
  }
}
