<?php

namespace App\Services;

use GuzzleHttp\Client;

class KKiapayService
{
    private $client;
    private $publicKey;
    private $secretKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->publicKey = config('kkiapay.KKiapay_PUBLIC_KEY');
        $this->secretKey = config('kkiapay.KKiapay_SECRET_KEY');
    }

    public function makePayment($amount, $currency, $description, $reference)
    {
        // Effectuez ici une requête HTTP pour effectuer un paiement via l'API KKiapay
        // Utilisez les clés d'API et les données de paiement fournies en argument

        // Exemple d'appel à l'API KKiapay :
        $response = $this->client->post('https://api.kkiapay.me/v1/payments', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->publicKey,
            ],
            'json' => [
                'amount' => $amount,
                'currency' => $currency,
                'description' => $description,
                'reference' => $reference,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
