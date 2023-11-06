<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KkiapayServices;
class PaiementController extends Controller
{
    public function makePayment(KkiapayServices $kkiapayService, )
    {
        $amount = 100; // Montant du paiement
        $currency = 'XOF'; // Devise
        $description = 'Achat de produit'; // Description de la transaction
        $reference = '123456'; // Référence de la transaction

        $response = $kkiapayService->makePayment($amount, $currency, $description, $reference);

        // Traitez la réponse de KKiapay ici

        return view('payment.success', ['response' => $response]);
    }  
}
