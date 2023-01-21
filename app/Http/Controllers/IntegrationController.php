<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentIntegration;
use App\Models\EmailProviderIntegration;
use App\Http\Resources\PaymentIntegrationResource;
use App\Http\Resources\EmailProviderIntegrationResource;

class IntegrationController extends Controller
{
    public function paymentChannel($projectId)
    {
        $integration = PaymentIntegration::where('project_id', $projectId)->first();
        
        if($integration){
            $integration =  new PaymentIntegrationResource($integration);
        }else {
            $integration = ['data' => (Object)[]];
        }

        return $integration;
    }

    public function storePaymentChannel(Request $request)
    {
        $data = $request->all();
        $integration = PaymentIntegration::where('project_id', $data['projectId'])->first();

        if($integration) {
            $integration->update([
                'stripe_status' => $data['stripeStatus'],
                'stripe_secret' => $data['stripeSecret'],
                'paypal_status' => $data['paypalStatus'],
                'paypal_secret' => $data['paypalSecret'],
                'paypal_client' => $data['paypalClient']
            ]);
        }else {
            $integration = PaymentIntegration::create([
                'project_id' => $data['projectId'],
                'stripe_status' => $data['stripeStatus'],
                'stripe_secret' => $data['stripeSecret'],
                'paypal_status' => $data['paypalStatus'],
                'paypal_secret' => $data['paypalSecret'],
                'paypal_client' => $data['paypalClient']
            ]);
        }

        return response([
            'message' => 'Settings Updated',
            'data' => new PaymentIntegrationResource($integration)
        ]);
    }

    public function mailChannel($projectId)
    {
        $integration = EmailProviderIntegration::where('project_id', $projectId)->first();
        
        if($integration){
            $integration =  new EmailProviderIntegrationResource($integration);
        }else {
            $integration = ['data' => (Object)[]];
        }

        return $integration;
    }

    public function storeMailChannel(Request $request)
    {
        $data = $request->all();
        $integration = EmailProviderIntegration::where('project_id', $data['projectId'])->first();

        if($integration) {
            $integration->update([
                'mailchimp' => $data['mailchimp'],
                'getresponse' => $data['getresponse'],
                'emailoctopus' => $data['emailoctopus'],
                'converterkit' => $data['converterkit'],
                'mailerlite' => $data['mailerlite'],
            ]);
        }else {
            $integration = EmailProviderIntegration::create([
                'project_id' => $data['projectId'],
                'mailchimp' => $data['mailchimp'],
                'getresponse' => $data['getresponse'],
                'emailoctopus' => $data['emailoctopus'],
                'converterkit' => $data['converterkit'],
                'mailerlite' => $data['mailerlite'],
            ]);
        }

        return response([
            'message' => 'Settings Updated',
            'data' => new EmailProviderIntegrationResource($integration)
        ]);
    }
}
