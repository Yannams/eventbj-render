<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KkiapayPaymentController extends Controller
{
    public function KkiapayPayment(Request $request){
        $public_key=env("KKIAPAY_PUBLIC");
        $private_key=env("KKIAPAY_PRIVATE");
        $secret=env("KKIAPAY_SECRET");
        $kkiapay = new \Kkiapay\Kkiapay($public_key, $private_key, $secret,  $sandbox = true);

        $kkiapay->verifyTransaction(1);
          
        
    }
}
