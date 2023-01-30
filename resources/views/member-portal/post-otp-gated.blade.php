@extends('member-portal.layout')

@section('content')
@php $settings = json_decode($blog->main_setting); @endphp
@php $media = json_decode($blog->smedia); @endphp

@if (\Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {!! \Session::get('success') !!}
    </div>
@elseif(\Session::has('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        {!! \Session::get('error') !!}
    </div>
@endif

<div style="background-color: {{$blog->bg_color}}" class="">
    <!-- post section -->
    <div class="lg:mx-96">
        <h4 class="text-gray-500 text-sm text-center">{{ $post->created_at->format('F d, Y') }}</h4>
        @if($author->name)
        <h4 class="text-gray-500 text-sm text-center mt-3">
            <em>By {{ $author->name }}</em>
        </h4>
        @endif
        <h5 class="mb-2 md:text-4xl text-2xl font-bold tracking-tight 
        text-gray-900 dark:text-white text-center mt-4"
        style="color: {{$blog->headline_color}}">
            {{ $post->title }}
        </h5>
        
        <!-- Images/media files display -->
        @php $images = json_decode($post->images); @endphp
        @php $medias = json_decode($post->media); @endphp
        <div class="mt-6">
            @if(count($images) > 0)
            <img class="rounded-lg h-80 w-full mx-auto" 
                src="{{asset($images[0])}}" alt="post" />
            @endif
            <div class="mt-10 font-normal text-gray-700"
            style="color: {{$blog->text_color}}">
                {!! substr($post->post,0,64).'...' !!}
            </div>
        </div>
    </div>
</div>

<div style="background-color: {{$blog->subsscriber_alert_color}}" class="lg:mx-40">
    <div id="toast-interactive" class="w-full p-4 text-center bg-white border rounded-lg shadow-md sm:p-8" 
        role="alert" style="background-color: {{$blog->subsscriber_alert_color}}">
        <div class="flex justify-center items w-full">
            <div class="items-center justify-center md:mx-48">
                <p class="mb-2">
                    Want to unlock this content from us?
                </p>
                <div class="flex items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 mt-4">
                    <button type="button" 
                        data-modal-toggle="post-paid-modal"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-0 
                        focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 
                        font-medium text-sm px-5 py-4 inline-flex 
                        justify-center text-center post-paid-modal" 
                        style="background-color: {{$blog->button_color}}">
                        Pay ${{ $post->otp }}
                    </button>
                </div>
                @if(!auth()->guard('subscriber')->check())
                <div class="mt-8">
                    <p class="text-sm flex justify-center text-center" :style="{color: data.textColor}"> 
                        Or login if you've already purchased 
                    </p>
                    <form action="{{route('post-login', strtolower($project->name))}}" method="post">
                        @csrf
                        <input type="hidden" name="remember" value="true">
                        <input id="remember-me" name="remember" type="checkbox" value="{{ old('remember') }}" class="hidden">
                        <div class="sm:flex flex items-center justify-center gap-3 mt-4">
                            <div>
                                <input type="email" id="email" name="email"
                                class="bg-gray-50 border border-gray-300 
                                text-gray-900 text-sm focus:ring-blue-500 
                                focus:border-blue-500 block w-full p-2.5 
                                dark:bg-gray-700 dark:border-gray-600 
                                dark:placeholder-gray-400 dark:text-white 
                                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="email@example.com" required>
                            </div>
                            <div>
                                <input type="password" id="password" name="password"
                                class="bg-gray-50 border border-gray-300 
                                text-gray-900 text-sm focus:ring-blue-500  
                                block w-full p-2.5 dark:bg-gray-700 focus:border-blue-500
                                dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 
                                dark:focus:border-blue-500" 
                                placeholder="password" required>
                            </div>
                            <button type="submit" 
                                class="text-white bg-black hover:bg-black 
                                focus:ring-0 focus:outline-none focus:ring-blue-300 
                                font-medium text-sm w-full sm:w-auto px-5 
                                py-2.5 text-center
                                dark:focus:ring-blue-800">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Payment modal -->
<div id="post-paid-modal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full 
    p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-md md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent 
                hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 
                ml-auto inline-flex items-center dark:hover:bg-gray-800 
                dark:hover:text-white" data-modal-toggle="post-paid-modal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
            Post: <h3 class="mb-4 text-md inline-flex font-medium text-gray-900 dark:text-white" id="post-form-name">{{ $post->title }}</h3>
                @if(!auth()->guard('subscriber')->check())
                <form class="space-y-3" action="{{route('order-post', strtolower($project->name))}}" method="post">
                @else
                <form class="space-y-3" action="{{route('order-post-auth', strtolower($project->name))}}" method="post">
                @endif
                    @csrf
                    <!-- Signup section -->
                    @if(!auth()->guard('subscriber')->check())
                    <div class="mt-2">
                        <div id="new-account-request">
                            <div class="flex justify-between">
                                <h3 class="text-md font-medium text-gray-900 dark:text-white">
                                    Create A Login
                                </h3>
                            </div>
                            <div class="mt-2">
                                <p class="text-gray-500 text-sm warn"></p>
                                <input type="email" name="email" 
                                class="block flex-1 rounded-md 
                                border-gray-300 focus:border-indigo-500 
                                focus:ring-indigo-500 w-full" 
                                placeholder="name@company.com">
                                <input type="password" name="password"
                                class="block flex-1 rounded-md mt-3
                                border-gray-300 focus:border-indigo-500 
                                focus:ring-indigo-500 w-full" 
                                placeholder="**********">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- data fields -->
                    <input type="text" name="linkId" value="" style="display:none"> <!-- null --->
                    <input type="text" name="sectionId" value="" style="display:none"> <!-- null --->
                    <input type="text" name="description" value="{{ $post->title }}" style="display:none">
                    <input type="text" name="projectlinkid" value="" style="display:none"> <!--  --->
                    <input type="text" name="product_id" value="{{ $post->id }}" style="display:none">
                    <input type="text" name="product_source" value="member_post" style="display:none">
                    <input type="text" name="project_name" value="{{ strtolower($project->name) }}" style="display:none">
                    <input type="text" name="blog_path" value="{{ strtolower($project->name) }}" style="display:none">
                    <input type="number" step=0.01 name="product_amount" value="{{ $post->otp }}" style="display:none">

                    <!-- Payment method -->
                    <div class="mt-4">
                        <h3 class="mb-4 text-md font-medium text-gray-900 dark:text-white">
                            Payment Method
                        </h3>
                        @if(auth()->guard('subscriber')->check())
                        <p class="mt-1 mb-1 text-sm text-gray-500">
                            You can leave empty if you have added your card to your account.
                        </p>
                        @endif
                        <div class="flex gap-3">
                            <div class="flex items-center pl-4 border w-full
                                border-gray-200 rounded dark:border-gray-700">
                                <input id="product-bordered-radio-1" type="radio" 
                                value="card" name="product_payType" 
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 
                                focus:ring-blue-500 dark:focus:ring-blue-600 
                                dark:ring-offset-gray-800 focus:ring-2 product-payType
                                dark:bg-gray-700 dark:border-gray-600"
                                checked>
                                <label for="product-bordered-radio-1" 
                                    class="w-full py-1 ml-2 text-sm font-medium 
                                    text-gray-900 dark:text-gray-300 flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                    </svg>
                                    <span class="mt-0.5 uppercase md:text-sm text-sm">Credit card</span>
                                </label>
                            </div>
                            <div class="flex items-center pl-4 border w-full
                            border-gray-200 rounded dark:border-gray-700">
                                <input id="product-bordered-radio-2" type="radio" 
                                value="paypal" name="product_payType" 
                                class="w-4 h-4 text-blue-600 bg-gray-100 
                                border-gray-300 focus:ring-blue-500 product-payType
                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="product-bordered-radio-2" 
                                    class="w-full py-1 ml-2 text-sm font-medium 
                                    text-gray-900 dark:text-gray-300 flex gap-2 uppercase">
                                    <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#00457C" class="w-4 h-4 mt-0.5">
                                        <title>PayPal</title>
                                        <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/>
                                    </svg>
                                    Paypal
                                </label>
                            </div>
                        </div>
                        <!-- Credit card details -->
                        <div class="mt-3" id="product-credit-card-slot">
                            <div class="flex rounded-md shadow-sm">
                                <input type="text" name="cardNumber" id="product-card-number" 
                                class="block w-full flex-1 rounded-none rounded-l-md 
                                border-gray-300 focus:border-indigo-500 
                                focus:ring-indigo-500 sm:text-sm" 
                                placeholder="Card number">
                                <span class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="md:flex gap-2 mt-3">
                                <div class="flex input-group w-full">
                                    <select class="block w-full rounded-none rounded-l-md 
                                        border-gray-300 focus:border-indigo-500 
                                        focus:ring-indigo-500 sm:text-sm" name="month" id="product-card-month">
                                        <option value="">MM</option>
                                        @foreach(range(1, 12) as $month)
                                            <option value="{{$month}}">{{$month}}</option>
                                        @endforeach
                                    </select>
                                    <select class="block w-full rounded-none rounded-r-md 
                                        border-gray-300 focus:border-indigo-500 
                                        focus:ring-indigo-500 sm:text-sm" name="year" id="product-card-year">
                                        <option value="">YYYY</option>
                                        @foreach(range(date('Y'), date('Y') + 10) as $year)
                                            <option value="{{$year}}">{{$year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full">
                                    <input type="text" name="cvv" id="product-cvv-number" 
                                    class="block flex-1 rounded-md 
                                    border-gray-300 focus:border-indigo-500 
                                    focus:ring-indigo-500" 
                                    placeholder="CVV">
                                </div>
                            </div>
                        </div> 
                        <!-- Total amount -->
                        <div class="flex gap-2 text-md mt-4">
                            <h2 class="font-medium ">Total: ${{ $post->otp }}</h2>
                            <span class="total-product font-medium"></span>
                        </div>
                        <!-- paypal slot -->
                        <div class="mt-3" id="product-paypal-slot" style="display:none"></div>
                    </div>
                    <button type="submit" 
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 
                        focus:ring-4 focus:outline-none focus:ring-blue-300 
                        font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                        dark:bg-blue-600 dark:hover:bg-blue-700 
                        dark:focus:ring-blue-800 mt-1">
                        Continue
                        <span id="product-loader" style="display:none">
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 ml-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                        </span>
                    </button>
                    <div class="mt-6">
                        <h4 class="flex justify-center text-center text-green-400 font-bold text-sm uppercase">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2 mb-1">
                                <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                            </svg>
                            secure payment by stripe & paypal
                        </h4>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
$(function() {

    $('.product-payType').change(function() {
        if($('input[name=product_payType]:checked').val()=='card') {
            $('#product-credit-card-slot').show();
            $('#product-paypal-slot').hide();
        }else if($('input[name=product_payType]:checked').val()=='paypal') {
            $('#product-credit-card-slot').hide();
            $('#product-paypal-slot').show();
        }
    });
})
</script>
@endsection