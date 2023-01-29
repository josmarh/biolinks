<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\BiolinkSection;
use App\Models\ProjectLink;
use App\Services\StripePayment;
use App\Services\PaypalPayment;
use App\Models\Subscriber;
use App\Models\CustomerPaymentMethod;
use App\Models\CustomerLead;
use App\Models\PaymentIntegration;
use App\Models\Project;
use App\Jobs\OrderJob;
use Log;

class PaymentController extends Controller
{
    public function donation(Request $request)
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
        $projectMain = Project::where('custom_id', $project->project_id)->with('user')->first();
        $getPaymentProviderKey = PaymentIntegration::where('project_id', $project->project_id)->first();
        // $paymentGatways  = PaymentIntegration::where('project_id', $project->project_id)->first();

        // if($paymentGatways) {
        //     $stripe = new StripePayment($paymentGatways->stripe_secret);

        // }

        if($data['type'] == 'card') {
            if(!$getPaymentProviderKey->stripe_secret) {
                return back()->with('error', 'Provider payment gateway is not set.');
            }
 
            $stripe = new StripePayment($getPaymentProviderKey->stripe_secret);

            $payment = $stripe->payment($data);
        }else {
            if(!$getPaymentProviderKey->paypal_client && !$getPaymentProviderKey->paypal_secret) {
                return back()->with('error', 'Provider payment gateway is not set.');
            }

            $paypal = new PaypalPayment($getPaymentProviderKey->paypal_client, $getPaymentProviderKey->paypal_secret);
            
            $forPaypal = [
                'sectionid'     => $data['sectionId'],
                'linkid'        => $data['linkId'],
                'projectid'     => $project->project_id,
                'description'   => $request->description,
                'projectlinkid' => $request->projectlinkid,
                'paymentFor'    => 'Donation',
                'userEmail'     => null,
                'productId'     => null,
                'productSource' => null,
                'requestMessage' => null,
                'paymentFrom'   => 'link-area',
                'projectName'   => strtolower($projectMain->name), 
                'blogPath'      => null,
                'projectOwner' => $projectMain->user->name,
                'successMessage' => 'Your donation has successfully been completed. Thank you.'
            ];

            Cache::put(session()->getId(), json_encode($forPaypal), now()->addMinutes(5));

            $payment = $paypal->pay($data);

            return back()->with('error', $payment);
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

            // send order mail

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

    public function fanRequest(Request $request)
    {
        $data = $request->validate([
            'linkId' => 'required',
            'sectionId' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'email' => 'required|email|string|unique:bl_subscribers,email',
            'password' => 'required',
            'requestMessage' => 'required'
        ]);
        
        // create customer account
        $customer = Subscriber::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'active' => 1,
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

            // save card details
            CustomerPaymentMethod::create([
                'user_id' => $customer->id,
                'card_number' => $data['cardNumber'],
                'card_month' => $data['month'],
                'card_year' => $data['year'],
                'card_cvv' => $data['cvv']
            ]);
        }
        $data['description'] = $request->description . ' (Fan Request)';
        $project = ProjectLink::find($data['linkId']);
        $getPaymentProviderKey = PaymentIntegration::where('project_id', $project->project_id)->first();
        $projectMain = Project::where('custom_id', $project->project_id)->with('user')->first();

        if($data['type'] == 'card') {
            if(!$getPaymentProviderKey->stripe_secret) {
                return back()->with('error', 'Provider payment gateway is not set.');
            }
 
            $stripe = new StripePayment($getPaymentProviderKey->stripe_secret);

            $payment = $stripe->payment($data);
        }else {
            if(!$getPaymentProviderKey->paypal_client && !$getPaymentProviderKey->paypal_secret) {
                return back()->with('error', 'Provider payment gateway is not set.');
            }

            $paypal = new PaypalPayment($getPaymentProviderKey->paypal_client, $getPaymentProviderKey->paypal_secret);
            
            $forPaypal = [
                'sectionid'     => $data['sectionId'],
                'linkid'        => $data['linkId'],
                'projectid'     => $project->project_id,
                'description'   => $request->description,
                'projectlinkid' => $request->projectlinkid,
                'paymentFor'    => 'Fan Request',
                'userEmail'     => $data['email'],
                'productId'     => null,
                'productSource' => null,
                'requestMessage' => $data['requestMessage'],
                'paymentFrom'   => 'link-area',
                'projectName'   => strtolower($projectMain->name), 
                'blogPath'      => null,
                'projectOwner' => $projectMain->user->name,
                'successMessage' => 'Payment successful. Your request has been sent, thank you.'
            ];

            // save card details
            CustomerPaymentMethod::create([
                'user_id' => $customer->id
            ]);

            Cache::put(session()->getId(), json_encode($forPaypal), now()->addMinutes(5));

            $payment = $paypal->pay($data);

            return back()->with('error', $payment);
        }

        if($payment['message'] == 'Payment completed.') {            
            // add to orders
            $order = Order::create([
                'email' => $data['email'],
                'order_type'    => 'Fan Request',
                'fulfilled'     => 'Digital',
                'status'        => 'success', 
                'description'   => $request->description,
                'request_message' => $data['requestMessage'],
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
                'order_type' => 'Fan Request', // donation, product, request
                'fulfilled' => 'Digital',
                'status' => 'success', // successful
                'description' => $request->description, // title of sale link
                'amount' => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type' => 'card', // card || paypal
                'pg_tranx_id' => $payment['balance_transaction'],
                'payment_id' => $payment['id'],
            ]);

            // add to customer leads
            CustomerLead::create([
                'email' => $data['email'],
                'name' => '',
                'status' => 'Paying Customer',
                'orders' => 1,
                'lifetime_value' => $data['amount'],
                'project_id' => $project->project_id
            ]);

            $message = $payment['message'] . ' Request sent';

            // send mail for completed purchased
            $order = [
                'email' => $data['email'],
                'productType' => 'fan_request',
                'productName' => $request->description,
                'price' => $data['amount'],
                'projectName' => strtolower($projectMain->name),
                'projectOwner' => $projectMain->user->name
            ];
            dispatch(new OrderJob($order))->delay(3);

        }else if($payment['message'] == 'Payment failed.') {
            Transaction::create([
                'link_id' => $data['linkId'],
                'project_id' => $project->project_id,
                'section_id' => $data['sectionId'],
                'order_type' => 'Fan Request', // donation, product, request
                'fulfilled' => 'Digital',
                'status' => 'failed', // successful
                'description' => $request->description, // title of sale link
                'amount' => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type' => 'card', // card || paypal
                'pg_tranx_id' => $payment['balance_transaction'],
                'payment_id' => $payment['id'],
            ]);

            return redirect()->route('biolink-webpage', $project->link_id)->with('error', $payment['message']);
        }

        return redirect()->route('biolink-webpage', $project->link_id)->with('success', $message);
    }

    public function fanRequestWithAuth(Request $request)
    {
        $data = $request->validate([
            'linkId' => 'required',
            'sectionId' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'requestMessage' => 'required',
        ]);

        if(!Auth::guard('subscriber')->check()) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            $data['email'] = $request->email;
            $data['password'] = $request->password;
            
            if(!Auth::guard('subscriber')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return back()->withInput($request->only('email', 'remember'))->with('error', 'Login failed');
            }
        }

        $data['email'] = Auth::guard('subscriber')->user()->email;
        $data['description'] = $request->description . ' (Fan Request)';
        $project = ProjectLink::find($data['linkId']);
        $projectMain = Project::where('custom_id', $project->project_id)->with('user')->first();
        $getPaymentProviderKey = PaymentIntegration::where('project_id', $project->project_id)->first();

        if($data['type'] == 'card') {
            if(!$getPaymentProviderKey->stripe_secret) {
                return back()->with('error', 'Provider payment gateway is not set.');
            }
 
            $stripe = new StripePayment($getPaymentProviderKey->stripe_secret);

            if(!$request->cardNumber) {
                $customer = Subscriber::where('email', $data['email'])->first();
                $isPaySet = CustomerPaymentMethod::where('user_id', $customer->id)->first();

                if(!$isPaySet->card_number || !$isPaySet->card_month || !$isPaySet->card_year || !$isPaySet->card_cvv) {

                    return back()->with('error', 'No card saved. Please add card details.');
                }else {
                    $data['cardNumber'] = $isPaySet->card_number;
                    $data['cvv'] = $isPaySet->card_cvv;
                    $data['month'] = $isPaySet->card_month;
                    $data['year'] = $isPaySet->card_year;

                    $payment = $stripe->payment($data);
                }
            }else {
                // if $request comes with card 
                $data['cardNumber'] = $request->cardNumber;
                $data['cvv'] = $request->cvv;
                $data['month'] = $request->month;
                $data['year'] = $request->year;

                // save card details
                $user = auth()->guard('subscriber')->user();
                CustomerPaymentMethod::where('user_id', $user->id)
                    ->update(['card_number' => $data['cardNumber'],
                        'card_month' => $data['month'],
                        'card_year' => $data['year'],
                        'card_cvv' => $data['cvv']
                    ]);

                $payment = $stripe->payment($data);
            }
        }else {
            if(!$getPaymentProviderKey->paypal_client && !$getPaymentProviderKey->paypal_secret) {
                return back()->with('error', 'Provider payment gateway is not set.');
            }

            $paypal = new PaypalPayment($getPaymentProviderKey->paypal_client, $getPaymentProviderKey->paypal_secret);

            $forPaypal = [
                'sectionid'     => $data['sectionId'],
                'linkid'        => $data['linkId'],
                'projectid'     => $project->project_id,
                'description'   => $request->description,
                'projectlinkid' => $request->projectlinkid,
                'paymentFor'    => 'Fan Request',
                'userEmail'     => $data['email'],
                'productId'     => null,
                'productSource' => null,
                'requestMessage' => $data['requestMessage'],
                'paymentFrom'   => 'link-area',
                'projectName'   => strtolower($projectMain->name), 
                'blogPath'      => null,
                'projectOwner' => $projectMain->user->name,
                'successMessage' => 'Payment successful. Your request has been sent, thank you.'
            ];

            Cache::put(session()->getId(), json_encode($forPaypal), now()->addMinutes(10));

            $payment = $paypal->pay($data);

            return back()->with('error', $payment);
        }

        if($payment['message'] == 'Payment completed.') {            
            // add to orders
            $order = Order::create([
                'email'         => $data['email'],
                'order_type'    => 'Fan Request',
                'fulfilled'     => 'Digital',
                'status'        => 'success', 
                'description'   => $request->description,
                'request_message' => $data['requestMessage'],
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
                'order_type' => 'Fan Request', // donation, product, request
                'fulfilled' => 'Digital',
                'status' => 'success', // successful
                'description' => $request->description, // title of sale link
                'amount' => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type' => 'card', // card || paypal
                'pg_tranx_id' => $payment['balance_transaction'],
                'payment_id' => $payment['id'],
            ]);

            // update/create to customer leads
            $customer = CustomerLead::where('email', $data['email'])
                ->where('project_id', $project->project_id)
                ->first();
            if($customer) {
                $customer->update([
                    'orders' => $customer->orders + 1,
                    'lifetime_value' => $customer->lifetime_value + $data['amount'],
                ]);
            }else {
                CustomerLead::create([
                    'email' => $data['email'],
                    'name' => '',
                    'status' => 'Paying Customer',
                    'orders' => 1,
                    'lifetime_value' => $data['amount'],
                    'project_id' => $project->project_id
                ]);
            }
            
            $message = $payment['message'] . ' Request sent';

            // send mail for completed purchased
            $order = [
                'email' => $data['email'],
                'productType' => 'fan_request',
                'productName' => $request->description,
                'price' => $data['amount'],
                'projectName' => strtolower($projectMain->name),
                'projectOwner' => $projectMain->user->name
            ];
            dispatch(new OrderJob($order))->delay(3);

        }else if($payment['message'] == 'Payment failed.') {
            Transaction::create([
                'link_id' => $data['linkId'],
                'project_id' => $project->project_id,
                'section_id' => $data['sectionId'],
                'order_type' => 'Fan Request', // donation, product, request
                'fulfilled' => 'Digital',
                'status' => 'failed', // successful
                'description' => $request->description, // title of sale link
                'amount' => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type' => 'card', // card || paypal
                'pg_tranx_id' => $payment['balance_transaction'],
                'payment_id' => $payment['id'],
            ]);
            
            return redirect()->route('biolink-webpage', $project->link_id)->with('error', $payment['message']);
        }

        return redirect()->route('biolink-webpage', $project->link_id)->with('success', $message);
    }

    public function product(Request $request)
    {
        $data = $request->validate([
            'linkId' => 'required',
            'sectionId' => 'required',
            'product_payType' => 'required',
            'product_amount' => 'required',
            'email' => 'required|email|string|unique:bl_subscribers,email',
            'password' => 'required',
            'product_id' => 'required',
            'product_source' => 'required'
        ]);
        $data['amount'] = $data['product_amount'];

        // create customer account
        $customer = Subscriber::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'active' => 1,
        ]);

        if($data['product_payType'] == 'card') {
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

            // save card details
            CustomerPaymentMethod::create([
                'user_id' => $customer->id,
                'card_number' => $data['cardNumber'],
                'card_month' => $data['month'],
                'card_year' => $data['year'],
                'card_cvv' => $data['cvv']
            ]);
        }

        $productType = $data['product_source'] == 'member_product' ? 'Membership Plan' : 'Digital Product';
        $data['description'] = $request->description . ' ('.$productType.')';
        $project = ProjectLink::find($data['linkId']);
        $projectMain = Project::where('custom_id', $project->project_id)->with('user')->first();
        $getPaymentProviderKey = PaymentIntegration::where('project_id', $project->project_id)->first();

        if($data['product_payType'] == 'card') {
            if(!$getPaymentProviderKey->stripe_secret) {
                return back()->with('error', 'Provider payment gateway is not set.');
            }
 
            $stripe = new StripePayment($getPaymentProviderKey->stripe_secret);

            $payment = $stripe->payment($data);
        }else {
            if(!$getPaymentProviderKey->paypal_client && !$getPaymentProviderKey->paypal_secret) {
                return back()->with('error', 'Provider payment gateway is not set.');
            }

            $paypal = new PaypalPayment($getPaymentProviderKey->paypal_client, $getPaymentProviderKey->paypal_secret);

            $forPaypal = [
                'sectionid'     => $data['sectionId'],
                'linkid'        => $data['linkId'],
                'projectid'     => $project->project_id,
                'description'   => $request->description,
                'projectlinkid' => $request->projectlinkid,
                'paymentFor'    => $productType,
                'userEmail'     => $data['email'],
                'productId'     => $data['product_id'],
                'productSource' => $data['product_source'],
                'requestMessage' => null,
                'paymentFrom'   => 'link-area',
                'projectName'   => strtolower($projectMain->name), 
                'blogPath'      => null,
                'projectOwner' => $projectMain->user->name,
                'successMessage' => 'Payment successful. You can access your purchased item in your member account, thank you.'
            ];

            // save card details
            CustomerPaymentMethod::create([
                'user_id' => $customer->id
            ]);

            Cache::put(session()->getId(), json_encode($forPaypal), now()->addMinutes(10));

            $payment = $paypal->pay($data);

            return back()->with('error', $payment);
        }

        if($payment['message'] == 'Payment completed.') {            
            // add to orders
            $order = Order::create([
                'email' => $data['email'],
                'order_type'    => $productType,
                'fulfilled'     => 'Digital',
                'status'        => 'success', 
                'description'   => $request->description,
                'link_id'       => $data['linkId'],
                'section_id'    => $data['sectionId'],
                'project_id'    => $project->project_id,
                'total'         => $data['amount'],
                'product_id'    => $data['product_id'],
                'product_source' => $data['product_source'],
            ]);
            // add to transaction
            Transaction::create([
                'link_id' => $data['linkId'],
                'project_id' => $project->project_id,
                'section_id' => $data['sectionId'],
                'order_id' => $order->id,
                'order_type' => $productType, // donation, product, request
                'fulfilled' => 'Digital',
                'status' => 'success', // successful
                'description' => $request->description, // title of sale link
                'amount' => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type' => 'card', // card || paypal
                'pg_tranx_id' => $payment['balance_transaction'],
                'payment_id' => $payment['id'],
            ]);

            // add to customer leads
            CustomerLead::create([
                'email' => $data['email'],
                'name' => '',
                'status' => 'Paying Customer',
                'orders' => 1,
                'lifetime_value' => $data['amount'],
                'project_id' => $project->project_id
            ]);

            $message = $payment['message'] . ' You can access your purchased item in your member account, thank you.';

            // send mail for completed purchased
            $order = [
                'email' => $data['email'],
                'productType' => $data['product_source'],
                'productName' => $request->description,
                'price' => $data['amount'],
                'projectName' => strtolower($projectMain->name),
                'projectOwner' => $projectMain->user->name
            ];
            dispatch(new OrderJob($order))->delay(3);

        }else if($payment['message'] == 'Payment failed.') {
            Transaction::create([
                'link_id' => $data['linkId'],
                'project_id' => $project->project_id,
                'section_id' => $data['sectionId'],
                'order_type' => $productType, // donation, product, request
                'fulfilled' => 'Digital',
                'status' => 'failed', // successful
                'description' => $request->description, // title of sale link
                'amount' => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type' => 'card', // card || paypal
                'pg_tranx_id' => $payment['balance_transaction'],
                'payment_id' => $payment['id'],
            ]);

            return redirect()->route('biolink-webpage', $project->link_id)->with('error', $payment['message']);
        }

        return redirect()->route('biolink-webpage', $project->link_id)->with('success', $message);

    }

    public function productWithAuth(Request $request)
    {
        $data = $request->validate([
            'linkId' => 'required',
            'sectionId' => 'required',
            'product_payType' => 'required',
            'product_amount' => 'required',
            'product_id' => 'required',
            'product_source' => 'required'
        ]);
        $data['amount'] = $data['product_amount'];

        if(!Auth::guard('subscriber')->check()) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            $data['email'] = $request->email;
            $data['password'] = $request->password;
            
            if(!Auth::guard('subscriber')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return back()->withInput($request->only('email', 'remember'))->with('error', 'Login failed');
            }
        }

        $productType = $data['product_source'] == 'member_product' ? 'Membership Plan' : 'Digital Product';
        $data['email'] = Auth::guard('subscriber')->user()->email;
        $data['description'] = $request->description . ' ('.$productType.')';
        $project = ProjectLink::find($data['linkId']);
        $projectMain = Project::where('custom_id', $project->project_id)->with('user')->first();
        $getPaymentProviderKey = PaymentIntegration::where('project_id', $project->project_id)->first();

        if($data['product_payType'] == 'card') {
            if(!$getPaymentProviderKey->stripe_secret) {
                return back()->with('error', 'Provider payment gateway is not set.');
            }
 
            $stripe = new StripePayment($getPaymentProviderKey->stripe_secret);

            if(!$request->cardNumber) {
                $customer = Subscriber::where('email', $data['email'])->first();
                $isPaySet = CustomerPaymentMethod::where('user_id', $customer->id)->first();

                if(!$isPaySet->card_number || !$isPaySet->card_month || !$isPaySet->card_year || !$isPaySet->card_cvv) {

                    return back()->with('error', 'No card saved. Please add card details.');
                }else {
                    $data['cardNumber'] = $isPaySet->card_number;
                    $data['cvv'] = $isPaySet->card_cvv;
                    $data['month'] = $isPaySet->card_month;
                    $data['year'] = $isPaySet->card_year;

                    $payment = $stripe->payment($data);
                }
            }else {
                // if $request comes with card 
                $data['cardNumber'] = $request->cardNumber;
                $data['cvv'] = $request->cvv;
                $data['month'] = $request->month;
                $data['year'] = $request->year;

                // save card details
                $user = auth()->guard('subscriber')->user();
                CustomerPaymentMethod::where('user_id', $user->id)
                    ->update(['card_number' => $data['cardNumber'],
                        'card_month' => $data['month'],
                        'card_year' => $data['year'],
                        'card_cvv' => $data['cvv']
                    ]);

                $payment = $stripe->payment($data);
            }
        }else {
            if(!$getPaymentProviderKey->paypal_client && !$getPaymentProviderKey->paypal_secret) {
                return back()->with('error', 'Provider payment gateway is not set.');
            }

            $paypal = new PaypalPayment($getPaymentProviderKey->paypal_client, $getPaymentProviderKey->paypal_secret);

            $forPaypal = [
                'sectionid'     => $data['sectionId'],
                'linkid'        => $data['linkId'],
                'projectid'     => $project->project_id,
                'description'   => $request->description,
                'projectlinkid' => $request->projectlinkid,
                'paymentFor'    => $productType,
                'userEmail'     => $data['email'],
                'requestMessage' => null,
                'productId'     => $data['product_id'],
                'productSource' => $data['product_source'],
                'paymentFrom'   => 'link-area',
                'projectName'   => strtolower($projectMain->name), 
                'blogPath'      => null,
                'projectOwner' => $projectMain->user->name,
                'successMessage' => 'Payment successful. You can access your purchased item in your member account, thank you.'
            ];

            Cache::put(session()->getId(), json_encode($forPaypal), now()->addMinutes(10));

            $payment = $paypal->pay($data);

            return back()->with('error', $payment);
        }

        if($payment['message'] == 'Payment completed.') {            
            // add to orders
            $order = Order::create([
                'email'         => $data['email'],
                'order_type'    => $productType,
                'fulfilled'     => 'Digital',
                'status'        => 'success', 
                'description'   => $request->description,
                'link_id'       => $data['linkId'],
                'section_id'    => $data['sectionId'],
                'project_id'    => $project->project_id,
                'total'         => $data['amount'],
                'product_id'    => $data['product_id'],
                'product_source' => $data['product_source'],
            ]);
            // add to transaction
            Transaction::create([
                'link_id' => $data['linkId'],
                'project_id' => $project->project_id,
                'section_id' => $data['sectionId'],
                'order_id' => $order->id,
                'order_type' => $productType, // donation, product, request
                'fulfilled' => 'Digital',
                'status' => 'success', // successful
                'description' => $request->description, // title of sale link
                'amount' => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type' => 'card', // card || paypal
                'pg_tranx_id' => $payment['balance_transaction'],
                'payment_id' => $payment['id'],
            ]);

            // update/create to customer leads
            $customer = CustomerLead::where('email', $data['email'])
                ->where('project_id', $project->project_id)
                ->first();
            if($customer) {
                $customer->update([
                    'orders' => $customer->orders + 1,
                    'lifetime_value' => $customer->lifetime_value + $data['amount'],
                ]);
            }else {
                CustomerLead::create([
                    'email' => $data['email'],
                    'name' => '',
                    'status' => 'Paying Customer',
                    'orders' => 1,
                    'lifetime_value' => $data['amount'],
                    'project_id' => $project->project_id
                ]);
            }
            
            $message = $payment['message'] . ' You can access your purchased item in your member account, thank you.';

            // send mail for completed purchased
            $order = [
                'email' => $data['email'],
                'productType' => $data['product_source'],
                'productName' => $request->description,
                'price' => $data['amount'],
                'projectName' => strtolower($projectMain->name),
                'projectOwner' => $projectMain->user->name
            ];
            dispatch(new OrderJob($order))->delay(3);

        }else if($payment['message'] == 'Payment failed.') {
            Transaction::create([
                'link_id' => $data['linkId'],
                'project_id' => $project->project_id,
                'section_id' => $data['sectionId'],
                'order_type' => $productType, // donation, product, request
                'fulfilled' => 'Digital',
                'status' => 'failed', // successful
                'description' => $request->description, // title of sale link
                'amount' => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type' => 'card', // card || paypal
                'pg_tranx_id' => $payment['balance_transaction'],
                'payment_id' => $payment['id'],
            ]);
            
            return redirect()->route('biolink-webpage', $project->link_id)->with('error', $payment['message']);
        }

        return redirect()->route('biolink-webpage', $project->link_id)->with('success', $message);
    }

    public function paypalSuccess(Request $request)
    {
        $forPaypal = json_decode(Cache::get(session()->getId()));
        $getPaymentProviderKey = PaymentIntegration::where('project_id', $forPaypal->projectid)->first();
        $paypal = new PaypalPayment($getPaymentProviderKey->paypal_client, $getPaymentProviderKey->paypal_secret);

        if ($request->input('paymentId') && $request->input('PayerID')) {
            $payment = $paypal->success($request->input('PayerID'), $request->input('paymentId'));
            
            if($payment['status'] == 'success') {
                $order = Order::create([
                    'email' => $forPaypal->paymentFor == 'Donation' ? $payment['arr']['payer']['payer_info']['email'] : $forPaypal->userEmail,
                    'order_type' => $forPaypal->paymentFor,
                    'fulfilled' => 'Digital',
                    'status' => 'success',
                    'description' => $forPaypal->description,
                    'link_id' => $forPaypal->linkid,
                    'project_id' => $forPaypal->projectid,
                    'section_id' => $forPaypal->sectionid,
                    'request_message' => $forPaypal->requestMessage,
                    'product_id'     => $forPaypal->productId,
                    'product_source' => $forPaypal->productSource,
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

                $email = $forPaypal->paymentFor == 'Donation' ? $payment['arr']['payer']['payer_info']['email'] : $forPaypal->userEmail;
                $customer = CustomerLead::where('email', $email)
                    ->where('project_id', $forPaypal->projectid)
                    ->first();

                if($customer) {
                    $customer->update([
                        'orders' => $forPaypal->paymentFor == 'Donation' ? 0 : $customer->orders + 1,
                        'lifetime_value' => $customer->lifetime_value + $payment['arr']['transactions'][0]['amount']['total'],
                    ]);
                }else {
                    CustomerLead::create([
                        'email' => $email,
                        'name' => '',
                        'status' => $forPaypal->paymentFor == 'Membership Plan' || $forPaypal->paymentFor == 'Digital Product' ? 'Paying Customer' : $forPaypal->paymentFor,
                        'orders' => $forPaypal->paymentFor == 'Donation' ? 0 : 1,
                        'lifetime_value' => $payment['arr']['transactions'][0]['amount']['total'],
                        'project_id' => $forPaypal->projectid
                    ]);
                }

                // send mail for completed purchased
                $order = [
                    'email' => $forPaypal->paymentFor == 'Donation' ? $payment['arr']['payer']['payer_info']['email'] : $forPaypal->userEmail,
                    'productType' => $forPaypal->productSource,
                    'productName' => $forPaypal->description,
                    'price' => $payment['arr']['transactions'][0]['amount']['total'],
                    'projectName' => $forPaypal->projectName,
                    'projectOwner' => $forPaypal->projectOwner
                ];
                dispatch(new OrderJob($order))->delay(3);
                
                if($forPaypal->paymentFrom == 'member-area') {
                    return redirect()->route('member-index', [$forPaypal->projectName, $forPaypal->blogPath])->with('success', $forPaypal->successMessage);
                }else {
                    return redirect()->route('biolink-webpage', $forPaypal->projectlinkid)->with('success', $forPaypal->successMessage);
                }
                
                // return view('paypal.success', compact('forPaypal'));
                // return redirect()->route('paypalSuccessful')->with([
                //     'projectlinkid' => $forPaypal->projectlinkid
                // ]);
            }else {
                if($forPaypal->paymentFrom == 'member-area') {
                    return redirect()->route('member-index', [$forPaypal->projectName, $forPaypal->blogPath])->with('error', $payment['message']);
                }else {
                    return redirect()->route('biolink-webpage', $forPaypal->projectlinkid)->with('error', $payment['message']);
                }
            }
        }else {
            if($forPaypal->paymentFrom == 'member-area') {
                return redirect()->route('member-index', [$forPaypal->projectName, $forPaypal->blogPath])->with('error', 'Payment declined!!');
            }else {
                return redirect()->route('biolink-webpage', $forPaypal->projectlinkid)->with('error', 'Payment declined!!');
            }
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
