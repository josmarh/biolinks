@extends('member-portal.layout')

@section('content')
@php $settings = json_decode($blog->main_setting); @endphp
@php $media = json_decode($blog->smedia); @endphp

@if($post->content_preview == 'yes_preview')
<div style="background-color: {{$blog->bg_color}}" class="">
    <!-- post section -->
    <div class="lg:mx-96">
        <h4 class="text-gray-500 text-sm text-center">{{ $post->created_at->format('F d, Y') }}</h4>
        @if($author->name)
        <h4 class="text-gray-500 text-sm text-center mt-3">
            <em>By {{ $author->name }}</em>
        </h4>
        @endif
        <h5 class="mb-2 text-4xl font-bold tracking-tight 
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
                {!! substr($post->post,0,70).'...' !!}
            </div>
        </div>
    </div>
</div>
@endif
<div style="background-color: {{$blog->subsscriber_alert_color}}" class="lg:mx-40">
    <div id="toast-interactive" class="w-full p-4 text-center bg-white border rounded-lg shadow-md sm:p-8" 
        role="alert" style="background-color: {{$blog->subsscriber_alert_color}}">
        <div class="flex justify-center items w-full">
            <div class="items-center justify-center md:mx-48">
                <p class="mb-2">
                    {{ $blog->post_gated_content }}
                </p>
                <div class="flex items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <a href="{{route('member-register', strtolower($project->name))}}"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-0 
                        focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 
                        font-medium text-sm px-5 py-4 inline-flex 
                        justify-center text-center "
                        style="background-color: {{$blog->button_color}}">
                        Subscribe
                    </a>
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
@endsection