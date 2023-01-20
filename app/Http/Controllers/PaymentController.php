<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\BiolinkSection;
use App\Models\ProjectLink;
use App\Services\StripePayment;
use App\Services\PaypalPayment;
use Log;

class PaymentController extends Controller
{
    public function donation(Request $request, StripePayment $stripe, PaypalPayment $paypal)
    {
        $data = $request->validate([
            'linkId' => 'required',
            'sectionId' => 'required',
            'type' => 'required',
            'amount' => 'required',
        ]);
        
        if($data['type'] == 'card') {
            $request->validate([
                'cardNumber' => 'required',
                'cvv'       => 'required',
                'month'     => 'required',
                'year'      =>  'required',
            ]);
            $data['cardNumber'] = $request->cardNumber;
            $data['cvv'] = $request->cvv;
            $data['month'] = $request->month;
            $data['year'] = $request->year;
        }
        $data['description'] = $request->description. ' (Donation)';
        $project = ProjectLink::find($data['linkId']);

        if($data['type'] == 'card') {
            $payment = $stripe->payment($data);
        }else {
            $payment = $paypal->pay($data);
            $forPaypal = [
                'sectionid'     => $data['sectionId'],
                'linkid'        => $data['linkId'],
                'projectid'     => $project->project_id,
                'description'   => $request->description,
                'projectlinkid' => $request->projectlinkid
            ];

            Cache::put(session()->getId(), json_encode($forPaypal), now()->addMinutes(5));
        }
        
        if($payment['message'] == 'Payment completed.') {            
            // add to orders
            $order = Order::create([
                'email' => 'Anonymous',
                'order_type'    => 'Donation',
                'fulfilled'     => 'Digital',
                'status'        => 'success', 
                'description'   => $request->description,
                'link_id'       => $data['linkId'],
                'section_id'    => $data['sectionId'],
                'project_id'    => $project->project_id,
                'total'         => $data['amount']
            ]);
            // add to transaction
            Transaction::create([
                'link_id' => $data['linkId'],
                'project_id' => $project->project_id,
                'section_id' => $data['sectionId'],
                'order_id' => $order->id,
                'order_type' => 'Donation', // donation, product, request
                'fulfilled' => 'Digital',
                'status' => 'success', // successful
                'description' => $request->description, // title of sale link
                'amount' => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type' => 'card', // card || paypal
                'pg_tranx_id' => $payment['balance_transaction'],
                'payment_id' => $payment['id'],
            ]);
        }else if($payment['message'] == 'Payment failed.') {
            Transaction::create([
                'link_id' => $data['linkId'],
                'project_id' => $project->project_id,
                'section_id' => $data['sectionId'],
                'order_type' => 'Donation', // donation, product, request
                'fulfilled' => 'Digital',
                'status' => 'failed', // successful
                'description' => $request->description, // title of sale link
                'amount' => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type' => 'card', // card || paypal
                'pg_tranx_id' => $payment['balance_transaction'],
                'payment_id' => $payment['id'],
            ]);
        }

        return response([
            'message' => $payment['message'],
            'status_code' => 201
        ], 201);
    }

    

    public function paypalSuccess(Request $request, PaypalPayment $paypal)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $payment = $paypal->success($request->input('PayerID'), $request->input('paymentId'));
            $forPaypal = json_decode(Cache::get(session()->getId()));
            
            if($payment['status'] == 'success') {
                $order = Order::create([
                    'email' => $payment['arr']['payer']['payer_info']['email'],
                    'order_type' => 'Donation',
                    'fulfilled' => 'Digital',
                    'status' => 'success',
                    'description' => $forPaypal->description,
                    'link_id' => $forPaypal->linkid,
                    'project_id' => $forPaypal->projectid,
                    'section_id' => $forPaypal->sectionid,
                    'total' => $payment['arr']['transactions'][0]['amount']['total']
                ]);

                Transaction::create([
                    'link_id' => $forPaypal->linkid,
                    'project_id' => $forPaypal->projectid,
                    'description' => $forPaypal->description,
                    'section_id' => $forPaypal->sectionid,
                    'order_id' => $order->id,
                    'order_type' => 'Donation',
                    'fulfilled' => 'Digital',
                    'status' => $payment['arr']['state'],
                    'amount' => $payment['arr']['transactions'][0]['amount']['total'],
                    'transaction_type' => 'Sale',
                    'payment_type' => 'paypal',
                    'pg_tranx_id' => $payment['arr']['id'],
                    'payment_id' => $payment['arr']['payer']['payer_info']['payer_id'],
                ]);

                return view('paypal.success', compact('forPaypal'));
                // return redirect()->route('paypalSuccessful')->with([
                //     'projectlinkid' => $forPaypal->projectlinkid
                // ]);
            }else {
                return $payment['message'];
            }
        }else {
            return 'Payment declined!!';
        }
    }

    public function paypalError()
    {
        $forPaypal = json_decode(Cache::get(session()->getId()));

        return view('paypal.failed', compact('forPaypal'));
        // return redirect()->route('paypalFailed')->with([
        //     'projectlinkid' => $forPaypal->projectlinkid
        // ]);
    }
}
