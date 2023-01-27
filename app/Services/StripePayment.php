<?php

namespace App\Services;

use Exception;
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class StripePayment
{
    private $stripe;

    public function __construct($secretKey)
    {
        $this->stripe = new StripeClient($secretKey);
    }

    public function payment($paymentInfo)
    {
        $token = $this->createToken($paymentInfo);

        if (!empty($token['error'])) {
            return ['message' => $token['error']];
        }
        if (empty($token['id'])) {
            return ['message' => 'Payment failed.'];
        }

        $charge = $this->createCharge($token['id'], $paymentInfo);
        
        if (!empty($charge) && $charge['status'] == 'succeeded') {
            return [
                'message' => 'Payment completed.',
                'id' => $charge['id'],
                'balance_transaction' => $charge['balance_transaction']
            ];
        } else {
            return ['message' => 'Payment failed.'];
        }
    }

    private function createToken($cardData)
    {
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $cardData['cardNumber'],
                    'exp_month' => $cardData['month'],
                    'exp_year' => $cardData['year'],
                    'cvc' => $cardData['cvv']
                ]
            ]);
        } catch (CardException $e) {
            $token['error'] = $e->getError()->message;
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        }
        return $token;
    }

    private function createCharge($tokenId, $amount)
    {
        $charge = null;
        try {
            $charge = $this->stripe->charges->create([
                'amount' => $amount['amount'] * 100,
                'currency' => 'usd',
                'source' => $tokenId,
                'description' => $amount['description']
            ]);
        } catch (Exception $e) {
            $charge['error'] = $e->getMessage();
        }
        return $charge;
    }
}