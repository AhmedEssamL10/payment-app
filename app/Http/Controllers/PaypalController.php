<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;


class PaypalController extends Controller
{
    public function go_payment()
    {
        return view('products.products');
    }
    public function payment()
    {
        $data = [];
        $data['items'] = [
            [
                'name' => 'Apple',
                'price' => 100,
                'description' => 'Macbook pro 14 inch',
                'qty' => 1
            ],
            [
                'name' => 'iphone',
                'price' => 200,
                'description' => 'Macbook pro 14 inch',
                'qty' => 1
            ]
        ];
        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = 300;
        $provider = new ExpressCheckout();
        $response = $provider->setExpressCheckout($data);
        $response = $provider->setExpressCheckout($data, true);

        return redirect($response['paypal_link']);
    }
    public function cancel()
    {
    }
    public function success(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            dd('Your payment was success');
        }
        dd('please try again latter');
    }
}
