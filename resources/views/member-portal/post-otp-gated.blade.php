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
                    <button type="button" data-modal-toggle="post-paid-modal"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-0 
                        focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 
                        font-medium text-sm px-5 py-4 inline-flex 
                        justify-center text-center" 
                        style="background-color: {{$blog->button_color}}">
                        Pay ${{ $post->otp }}
                    </button data-modal-toggle="plan-modal">
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
                    <!-- Login section -->
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

                </form>
            </div>

        </div>
    </div>
</div>
@endsection