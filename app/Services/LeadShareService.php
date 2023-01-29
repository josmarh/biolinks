<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Log;

trait LeadShareService
{
    protected function shareWithESP($esp, $email, $name=null)
    {
        // mailchimp
        $mailchimp = json_decode($esp->mailchimp);
        if($mailchimp->apikey && $mailchimp->listid) {
            $mailchimp = [
                'name' => $name,
                'email' => $email,
                'mailchimpKey' => $mailchimp->apikey,
                'mailchimpList' => $mailchimp->listid
            ];
            $this->shareWithMailchimp($mailchimp);
        }

        // getresponse
        $getresponse = json_decode($esp->getresponse);
        if($getresponse->apikey && $getresponse->campaignId) {
            $getresponse = [
                'name' => $name,
                'email' => $email,
                'apiKey' => $getresponse->apikey,
                'campaignId' => $getresponse->campaignId
            ];
            $this->shareWithGetresponse($getresponse);
        }

        // emailoctopus
        $emailoctopus = json_decode($esp->emailoctopus);
        if($emailoctopus->apikey && $emailoctopus->listid) {
            $emailoctopus = [
                'name' => $name,
                'email' => $email,
                'apiKey' => $emailoctopus->apikey,
                'listId' => $emailoctopus->listid
            ];
            $this->shareWithEmailOctopus($emailoctopus);
        }

        // converterkit
        $converterkit = json_decode($esp->converterkit);
        if($converterkit->apikey && $converterkit->formId) {
            $converterkit = [
                'name' => $name,
                'email' => $email,
                'apiKey' => $converterkit->apikey,
                'formId' => $converterkit->formId
            ];
            $this->shareWithConverterKit($converterkit);
        }

        // mailerlite
        $mailerlite = json_decode($esp->mailerlite);
        if($mailerlite->apikey && $mailerlite->groupId) {
            $mailerlite = [
                'name' => $name,
                'email' => $email,
                'apiKey' => $mailerlite->apikey,
                'groupId' => $mailerlite->groupId
            ];
            $this->shareWithMailerLite($mailerlite);
        }
    }

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

    protected function shareWithGetresponse($data)
    {
        $response = Http::withHeaders([
            "X-Auth-Token" => "api-key ".$data['apiKey']
        ])->post('https://api.getresponse.com/v3/contacts', [ 
            "body" => [
                "name" => $data['name'],
                "email" => $data['email'],
                "campaign" => [
                    "campaignId" => $data["campaignId"]
                ]
            ]
        ]);

        $responseBody = json_decode($response->getBody());
        Log::info($response->getBody());

        return $responseBody;
    }

    protected function shareWithEmailOctopus($data)
    {
        $response = Http::withHeaders([
            "Content-Type" => "application/json"
        ])->post('https://emailoctopus.com/api/1.6/lists/'.$data['listId'].'/contacts', [ 
            "api_key" => $data['apiKey'],
            "email_address" => $data['email'],
            "fields" => [
                "FirstName" => $data['name'],
                "status" => "SUBSCRIBED"
            ]
        ]);

        $responseBody = json_decode($response->getBody());
        Log::info($response->getBody());

        return $responseBody;
    }

    protected function shareWithConverterKit($data)
    {
        $response = Http::withHeaders([
            "Content-Type" => "application/json; charset=utf-8"
        ])->post('https://api.convertkit.com/v3/forms/'.$data['formId'].'/subscribe', [ 
            "api_key" => $data['apiKey'],
            "email" => $data['email'],
        ]);

        $responseBody = json_decode($response->getBody());
        Log::info($response->getBody());

        return $responseBody;
    }

    protected function shareWithMailerLite($data)
    {
        $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Accept" => "application/json",
                "X-Version" => "2038-01-19"
            ])
            ->withToken($data['apiKey'])
            ->post("https://connect.mailerlite.com/api/subscribers", [
                "email" => $data["email"],
                "fields" => [
                    "name" => $data["name"],
                    "groups" => [
                        $data["groupId"]
                    ]
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