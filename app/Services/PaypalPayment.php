<?php

namespace App\Services;

use Omnipay\Omnipay;

class PaypalPayment
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
    	$this->gateway->setClientId(env('PAYPAL_SANDBOX_CLIENT_ID'));
    	$this->gateway->setSecret(env('PAYPAL_SANDBOX_SECRET'));
    	$this->gateway->setTestMode(true);
    }

    public function pay($paymentInfo)
    {
        try {
    		$response = $this->gateway->purchase(array(
    			'amount' => $paymentInfo['amount'],
    			'currency' => env('PAYPAL_CURRENCY'),
    			'returnUrl' => url('paypal/success'),
    			'cancelUrl' => url('paypal/error'),
    		))->send();
    		if ($response->isRedirect()) {
    			$response->redirect();
    		}else{
    			return $response->getMessage();
    		}
    		
    	} catch (Exception $e) {
    		return $this->getMessage();
    	}
    }

    public function success($payerId, $paymentId)
    {
        $transaction = $this->gateway->completePurchase(array(
            'payer_id' => $payerId,
            'transactionReference' => $paymentId
        ));

        $response = $transaction->send();

        if ($response->isSuccessful()) {
            return [
                'status' => 'success',
                'arr' => $response->getData()
            ];
        }else {
            return [
                'status' => 'failed',
                'message' => $response->getMessage()
            ];
        }
    }
}