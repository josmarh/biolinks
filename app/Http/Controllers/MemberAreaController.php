<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Project;
use App\Models\Post;
use App\Models\Plan;
use App\Models\MembershipBlog;
use App\Models\Subscriber;
use App\Models\Product;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\CustomerPaymentMethod;
use App\Models\CustomerLead;
use App\Models\PaymentIntegration;
use App\Services\StripePayment;
use App\Services\PaypalPayment;
use App\Jobs\OrderJob;
use Log;


class MemberAreaController extends Controller
{
    public function index($projectName, $routeName)
    {
        $project = Project::where('name', $projectName)->first();
        
        if(!$project) {
            return view('errors.404');
        }

        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $blogSetting = json_decode($blog->main_setting);
        if($routeName != $blogSetting->urlPath) {
            return view('errors.404');
        }

        $posts = Post::where('project_id', $project->custom_id)
            ->orderBy('id', 'desc')
            ->paginate(15);

        $totalSubs = Order::selectRaw('distinct email')
            ->where('project_id', $project->custom_id)
            ->where('product_source', 'member_product')
            ->where('status', 'success')
            ->get();

        if($totalSubs->count() > 1) {
            $memberName = $blogSetting->memberNickNamePlural ? $blogSetting->memberNickNamePlural : 'Members';
        }else {
            $memberName = $blogSetting->memberNickName ? $blogSetting->memberNickName : 'Member';
        }

        $plan = Plan::where('project_id', $project->custom_id)->first();
        if($plan && $plan->monthly_pricing == 'yes') {
            $planPrice = [ 'price' => $plan->monthly_price, 'type' => 'month'];
        }elseif($plan && $plan->annual_pricing == 'yes') {
            $planPrice = [ 'price' => $plan->annual_price, 'type' => 'year'];
        }else {
            $planPrice = [ 'price' => '', 'type' => ''];
        }

        return view('member-portal.index', compact('blog','posts','project','memberName','totalSubs','planPrice'));
    }

    public function login($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $blogSetting = json_decode($blog->main_setting);
        $blogRouteName = $blogSetting->urlPath;

        if(!$project) {
            return view('errors.404');
        }

        return view('member-portal.login', compact('projectName','project','blog','blogRouteName'));
    }

    public function loginMember(Request $request, $projectName)
    {
        $project = Project::where('name', $projectName)->first();
  
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'remember' => $request->remember
        ];
        
        if(Auth::guard('subscriber')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $credentials['remember'])) {
            $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
            $blogSetting = json_decode($blog->main_setting);
            $blogRouteName = $blogSetting->urlPath;

            return redirect()->intended('/w/'.$projectName.'/'.$blogRouteName);
        }else {
            return back()->withInput($request->only('email', 'remember'));
        }
    }

    public function register($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $blogSetting = json_decode($blog->main_setting);
        $blogRouteName = $blogSetting->urlPath;
        $plans = Plan::where('project_id', $project->custom_id)->get();
        
        if(!$project) {
            return view('errors.404');
        }

        return view('member-portal.register', compact('projectName','project','blog','blogRouteName','plans'));
    }

    public function registerMember(Request $request, $projectName)
    {
        $project = Project::where('name', $projectName)->first();

        $credentials = $request->validate([
            'email' => 'required|email|string|unique:bl_subscribers,email',
            'password' => ['required'],
        ]);

        Subscriber::create([
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
            'active' => 1,
        ]);

        if(Auth::guard('subscriber')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
            $blogSetting = json_decode($blog->main_setting);
            $blogRouteName = $blogSetting->urlPath;

            return redirect()->route('member-index', [$projectName, $blogRouteName]);
        }

        return back()->withInput($request->only('email'));
    }

    public function logoutMember(Request $request, $projectName)
    {
        Auth::guard('subscriber')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $blogSetting = json_decode($blog->main_setting);
        $blogRouteName = $blogSetting->urlPath;

        return redirect()->route('member-index', [$projectName, $blogRouteName]);
    }

    public function library($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $orders = Order::where('project_id', $project->custom_id)
        ->where('email', Auth::guard('subscriber')->user()->email)
        ->get();
        
        // get products, plans
        $product = []; 
        $plan = [];
        foreach($orders as $order) {
            if($order->product_source == 'simple_product') {
                array_push($product, $order->product_id);
            }elseif($order->product_source == 'member_product') {
                array_push($plan, $order->product_id);
            }
        }

        $plans = [];
        if(count($product)>0) {
            $product = Product::whereIn('id', $product)->get();
        }
        if(count($plan)>0) {
            $plan = Plan::whereIn('id', $plan)->get();
            foreach ($plan as $membership) {
                $blog = MembershipBlog::where('project_id', $membership->project_id)->first();
                $blogUrlPath = json_decode($blog->main_setting);
                array_push($plans, (object)[
                    'blogTitle' => $blog->title,
                    'planName' => $membership->title,
                    'projectName' => strtolower($projectName),
                    'blogPath' => $blogUrlPath->urlPath
                ]);
            }
        }

        return view('member-portal.library', compact('project','blog','plans','product'));
    }

    public function account($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $user = Subscriber::find(Auth::guard('subscriber')->user()->id);
        $paymentMethod = CustomerPaymentMethod::where('user_id', Auth::guard('subscriber')->user()->id)->first();
        $orders = Order::where('project_id', $project->custom_id)
            ->where('email', Auth::guard('subscriber')->user()->email)
            ->paginate(15);
        $subscriptions = Order::where('project_id', $project->custom_id)
            ->where('product_source', 'member_product')
            ->where('status', 'success')
            ->where('email', Auth::guard('subscriber')->user()->email)
            ->paginate(15);

        return view('member-portal.account', compact('project','blog','user','paymentMethod','orders','subscriptions'));
    }

    public function updateAccount(Request $request, $projectName)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        $user = Subscriber::find(Auth::guard('subscriber')->user()->id);

        if($request->password && $request->old_password) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
        }else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('member-account', $projectName)->with('success', 'Account updated.');
    }

    public function updatePaymethod(Request $request, $projectName)
    {
        $user = Auth::guard('subscriber')->user()->id;

        $subscriber = CustomerPaymentMethod::where('user_id', $user)->first();

        $subscriber->update([
            'card_number' => $request->card_number,
            'card_month' => $request->card_month,
            'card_year' => $request->card_year,
            'card_cvv' => $request->card_cvv,
        ]);

        return redirect()->route('member-account', $projectName)->with('success', 'Account updated.');
    }

    public function orders($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();

        return view('member-portal.orders', compact('project','blog'));
    }

    public function post($projectName, $slug)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $post = Post::where('project_id', $project->custom_id)
            ->where('slug', $slug)
            ->first();
        $author = Subscriber::find($post->author);

        if(!$post) {
            return view('errors.404');
        }

        // validate publish date and gated post
        if(!$post->published_date 
        || $post->published_date 
        && date('Y-m-d') >= \Carbon\Carbon::create($post->published_date)->toDateString()) {
            if($post->payment_setting == 'free') {

                return view('member-portal.post', compact('project','blog','post','author'));

            }else if($post->payment_setting == 'subscription') {
                if(Auth::guard('subscriber')->check()) {
                    // check if subscriber purchased a plan
                    $orders = Order::where('email', Auth::guard('subscriber')->user()->email)
                        ->where('product_source', 'member_product')
                        ->where('project_id', $project->custom_id)
                        ->get();
                    
                    if(!$orders) {
                        return view('member-portal.post-subscriber-gated', compact('project','blog','post','author'));
                    }else {
                        // Also check if plan ordered matches the required post->plan to access the post
                        $postPlans = json_decode($post->plans);
                        $planCheckCounter = 0;
                        foreach ($orders as $purchasedPlan) {                            
                            foreach($postPlans as $postPlan) {
                                if($postPlan === $purchasedPlan->product_id) { 
                                    $planCheckCounter = 1;
                                }
                            }
                        }
                        if($planCheckCounter == 1) {
                            return view('member-portal.post', compact('project','blog','post','author'));
                        }
                        return view('member-portal.post-subscriber-gated', compact('project','blog','post','author'));
                    }
                }else {
                    // return to page with preview or no-preview gated post
                    return view('member-portal.post-subscriber-gated', compact('project','blog','post','author'));
                }
            }else {
                // every user pays 
                if(Auth::guard('subscriber')->check()) {
                    // check if subscriber purchased a plan
                    $orders = Order::where('email', Auth::guard('subscriber')->user()->email)
                        ->where('product_source', 'member_post')
                        ->where('project_id', $project->custom_id)
                        ->get();

                    if(!$orders) {
                        return view('member-portal.post-otp-gated', compact('project','blog','post','author'));
                    }else {
                        $postCheckCounter = 0;
                        foreach ($orders as $purchasedPost) {
                            if($post->id === $purchasedPost->product_id) { 
                                $postCheckCounter = 1;
                            }
                        }
                        if($planCheckCounter == 1) {
                            return view('member-portal.post', compact('project','blog','post','author'));
                        }
                        return view('member-portal.post-otp-gated', compact('project','blog','post','author'));
                    }
                }else {
                    return view('member-portal.post-otp-gated', compact('project','blog','post','author'));
                }
            }
        }

        return view('errors.404-post');
    }

    public function subscribeToPlan(Request $request)
    {
        $data = $request->validate([
            'product_payType' => 'required',
            'product_amount' => 'required',
            'email' => 'required|email|string|unique:bl_subscribers,email',
            'password' => 'required',
            'product_id' => 'required',
            'product_source' => 'required',
            'plan_name' => 'required'
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

        }

        $productType = $data['product_source'] == 'member_product' ? 'Membership Plan' : 'Digital Product';
        $data['description'] = $request->description . ' ('.$productType.')';
        $project = Project::where('name', $request->project_name)->with('user')->first();
        $getPaymentProviderKey = PaymentIntegration::where('project_id', $project->custom_id)->first();
        
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
                'sectionid'     => $request->sectionId,
                'linkid'        => $request->linkId,
                'projectid'     => $project->custom_id,
                'description'   => $request->description,
                'projectlinkid' => $request->projectlinkid,
                'paymentFor'    => $productType,
                'userEmail'     => $data['email'],
                'productId'     => $data['product_id'],
                'productSource' => $data['product_source'],
                'requestMessage' => null,
                'paymentFrom'   => 'member-area',
                'projectName'   => strtolower($request->project_name), 
                'blogPath'      => $request->blog_path,
                'projectOwner' => $project->user->name,
                'successMessage' => 'You have successfully subscribe to plan '. $data['plan_name'].', thank you.'
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
                'link_id'       => $request->linkId,
                'section_id'    => $request->sectionId,
                'project_id'    => $project->custom_id,
                'total'         => $data['amount'],
                'product_id'    => $data['product_id'],
                'product_source' => $data['product_source'],
            ]);
            // add to transaction
            Transaction::create([
                'link_id'       => $request->linkId,
                'project_id'    => $project->custom_id,
                'section_id'    => $request->sectionId,
                'order_id'      => $order->id,
                'order_type'    => $productType, // donation, product, request
                'fulfilled'     => 'Digital',
                'status'        => 'success', // successful
                'description'   => $request->description, // title of sale link
                'amount'        => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type'  => 'card', // card || paypal
                'pg_tranx_id'   => $payment['balance_transaction'],
                'payment_id'    => $payment['id'],
            ]);

            // save card details
            CustomerPaymentMethod::create([
                'user_id' => $customer->id,
                'card_number' => $data['cardNumber'],
                'card_month' => $data['month'],
                'card_year' => $data['year'],
                'card_cvv' => $data['cvv']
            ]);

            // add to customer leads
            CustomerLead::create([
                'email' => $data['email'],
                'name' => '',
                'status' => 'Paying Customer',
                'orders' => 1,
                'lifetime_value' => $data['amount'],
                'project_id' => $project->custom_id
            ]);

            $message = $payment['message'] . 'You have successfully subscribe to plan '. $data['plan_name'].', thank you.';

            // send mail for completed purchased
            $order = [
                'email' => $request->email,
                'productType' => $data['product_source'],
                'productName' => $request->description,
                'price' => $data['amount'],
                'projectName' => strtolower($request->project_name),
                'projectOwner' => $project->user->name
            ];
            dispatch(new OrderJob($order))->delay(3);

        }else if($payment['message'] == 'Payment failed.') {
            Transaction::create([
                'link_id'       => $request->linkId,
                'project_id'    => $project->custom_id,
                'section_id'    => $request->sectionId,
                'order_type'    => $productType, // donation, product, request
                'fulfilled'     => 'Digital',
                'status'        => 'failed', // successful
                'description'   => $request->description, // title of sale link
                'amount'        => $data['amount'],
                'transaction_type' => 'Sale', // Sale, refund
                'payment_type'  => 'card', // card || paypal
                'pg_tranx_id'   => $payment['balance_transaction'],
                'payment_id'    => $payment['id'],
            ]);

            return back()->with('error', $payment['message']);
        }

        if(Auth::guard('subscriber')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return redirect()->route('member-index', [$request->project_name, $request->blog_path])->with('success', $message);
        }

        return redirect()->route('member-index', [$request->project_name, $request->blog_path])->with('success', $message);
    }

    public function subscribeToPlanWithAuth(Request $request)
    {
        $data = $request->validate([
            'product_payType' => 'required',
            'product_amount' => 'required',
            'product_id' => 'required',
            'product_source' => 'required',
            'plan_name' => 'required'
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
        $project = Project::where('name', $request->project_name)->with('user')->first();
        $getPaymentProviderKey = PaymentIntegration::where('project_id', $project->custom_id)->first();

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
                'sectionid'     => $request->sectionId,
                'linkid'        => $request->linkId,
                'projectid'     => $project->custom_id,
                'description'   => $request->description,
                'projectlinkid' => $request->projectlinkid,
                'paymentFor'    => $productType,
                'userEmail'     => $data['email'],
                'requestMessage' => null,
                'productId'     => $data['product_id'],
                'productSource' => $data['product_source'],
                'paymentFrom'   => 'member-area',
                'projectName'   => strtolower($request->project_name), 
                'blogPath'      => $request->blog_path,
                'projectOwner' => $project->user->name,
                'successMessage' => 'Payment successful. You have successfully subscribe to plan '. $data['plan_name'].', thank you.'
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
                'link_id'       => $request->linkId,
                'section_id'    => $request->sectionId,
                'project_id'    => $project->custom_id,
                'total'         => $data['amount'],
                'product_id'    => $data['product_id'],
                'product_source' => $data['product_source'],
            ]);
            // add to transaction
            Transaction::create([
                'link_id' => $request->linkId,
                'project_id' => $project->custom_id,
                'section_id' => $request->sectionId,
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
                ->where('project_id', $project->custom_id)
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
                    'project_id' => $project->custom_id
                ]);
            }
            
            $message = $payment['message'] . ' You have successfully subscribe to plan '. $data['plan_name'].', thank you.';

            // send mail for completed purchased
            $order = [
                'email' => $data['email'],
                'productType' => $data['product_source'],
                'productName' => $request->description,
                'price' => $data['amount'],
                'projectName' => strtolower($project->name),
                'projectOwner' => $project->user->name
            ];
            dispatch(new OrderJob($order))->delay(3);

        }else if($payment['message'] == 'Payment failed.') {
            Transaction::create([
                'link_id' => $$request->linkId,
                'project_id' => $project->custom_id,
                'section_id' => $request->sectionId,
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
            
            return back()->with('error', $payment['message']);
        }

        return redirect()->route('member-index', [$request->project_name, $request->blog_path])->with('success', $message);
    }

    public function orderPost(Request $request)
    {
        
    }

    public function orderPostWithAuth(Request $request)
    {
        
    }
}
