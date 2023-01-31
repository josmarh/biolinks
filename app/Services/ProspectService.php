<?php

namespace App\Services;

use App\Http\Requests\MailRequest;
use App\Http\Requests\ProspectRequest;
use App\Jobs\MessageJob;
use App\Mail\Message;
use App\Prospect;
use App\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProspectService
{
    /**
     * Send Mail Service
     *
     * @param MailRequest $request
     * @return void
     */
    public function sendMail(MailRequest $request)
    {
        $email = $request->get('email');
        $status = $this->sendMailByData($email, $request->get('subject'), $request->get('content'));

        return response()->json(['success' => $status,], 200);
    }
    /**
     * Undocumented function
     *
     * @param [type] $email
     * @param [type] $subject
     * @param [type] $content
     * @return Int
     */
    private function sendMailByData($email, $subject, $content)
    {
        $user = auth()->user();
//        dd(empty($user->get('mailhost')));
        if ($user->mailhost === '') {
            $configuration = [
                'smtp_host' => $user->mailhost,
                'smtp_port' => $user->mailport,
                'smtp_username' => $user->mailusername,
                'smtp_password' => $user->mailpassword,
                'smtp_encryption' => $user->mailencryption,
                'from_email' => $user->mailfromname,
                'from_name' => $user->mailfromaddress,
            ];
        } else {
            $configuration = false;
        }

        $mail_details = [
            'email' => $email,
            'subject' => $subject ?: 'We are reaching out to inquire about sponsored posts',
            'message' => nl2br($content),
            'from_email' => Auth::user()->getAttribute('email'),
            'from_name' => Auth::user()->getAttribute('name'),
        ];

        if (!$configuration) {
            $messageQueue = (new Message($mail_details))->onQueue('emails');
            return Mail::to($email)->queue($messageQueue);
        }

        return MessageJob::dispatch($configuration, $email, $mail_details);
    }

    /**
     * @param ProspectRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(ProspectRequest $request, $id): JsonResponse
    {
        $element = Prospect::findOrFail($id);
        $element->name = $request->get('name');
        $element->url = $request->get('url');
        $element->email = $request->get('email');
        $element->country = $request->get('country');
        $element->city = $request->get('city');
        $update = $element->save();
        if (!$update) {
            return response()->json([
                                        'success' => false,
                                        'data'=> null
                                    ], ResponseAlias::HTTP_BAD_REQUEST);
        }
        return response()->json([
                                       'success' => true,
                                       'data' => $element
                                   ], ResponseAlias::HTTP_OK);
    }

    public function destroy(int $id)
    {
        $delete = Prospect::destroy($id);
        if (!$delete) {
            return response()->json([
                                        'success' => false,
                                    ], ResponseAlias::HTTP_BAD_REQUEST);
        }
        return response()->json([
                                       'success' => true,
        ]);
    }
}
