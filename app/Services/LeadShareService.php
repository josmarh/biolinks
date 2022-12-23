<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Log;

trait LeadShareService
{
    protected function shareWithMailchimp($data)
    {
        $explode = explode('-', $data['mailchimpKey']);

        if(count($explode) < 2) {
            die();
        }

        $dc = $explode[1];
        $url = 'https://' . $dc . '.api.mailchimp.com/3.0/lists/' . $data['mailchimpList'] . '/members';

        /* Try to subscribe the user to mailchimp list */
        $response = Http::withToken($data['mailchimpKey'])
            ->post($url, [
                'email_address' => $data['email'],
                'status' => 'subscribed',
                'merge_fields' => [
                    'FNAME' => $data['name']
                ],
            ]);

        $responseBody = json_decode($response->getBody());
        Log::info($response->getBody());

        return $responseBody;
    }

    protected function shareWithWebhook($data)
    {
        $response = Http::asForm()->post($data['webhook'], [
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

        $responseBody = json_decode($response->getBody());
        Log::info($response->getBody());

        return $responseBody;
    }
}