@extends('member-portal.layout')

@section('content')
@if (\Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {!! \Session::get('success') !!}
    </div>
@elseif(\Session::has('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        {!! \Session::get('error') !!}
    </div>
@endif

@php $settings = json_decode($blog->main_setting); @endphp
@php $media = json_decode($blog->smedia); @endphp

<div style="background-color: {{$blog->bg_color}}">
    <!-- Title section -->
    <div>
        <h5 class="mb-2 text-4xl font-bold tracking-tight 
        text-gray-900 dark:text-white text-center"
        style="color: {{$blog->headline_color}}">
            {{ $blog->title }}
        </h5>
        <p class="font-normal text-gray-700 dark:text-gray-400 text-center text-lg mt-4"
        style="color: {{$blog->text_color}}">
            {{ $blog->sub_heading }}
        </p>
    </div>

    <!-- Add member count and member name if exist -->
    @if($settings->showTotalSubscribers == 'yes')
    <div class="mt-6 font-bold text-center text-xl" 
        style="color: {{$blog->text_color}}">
        {{ $totalSubs->count() }} {{ $memberName }}
    </div>
    @endif

    <!-- socials -->
    <div class="flex justify-center gap-3 mt-10">
        @if($media->facebook)
        <a href="https://facebook.com/{{$media->facebook}}" target="_blank">
            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="{{ $blog->button_color }}" class="h-6 w-6">
                <title>Facebook</title>
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
        </a>
        @endif
        @if($media->instgram)
        <a href="https://instagram.com/{{$media->instgram}}" target="_blank">
            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="{{ $blog->button_color }}" class="h-6 w-6">
                <title>Instagram</title>
                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
            </svg>
        </a>
        @endif
        @if($media->twitter)
        <a href="https://twitter.com/{{$media->twitter}}" target="_blank">
            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="{{ $blog->button_color }}" class="h-6 w-6">
                <title>Twitter</title>
                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
            </svg>
        </a>
        @endif
        @if($media->pinterest)
        <a href="https://www.pinterest.com/{{$media->pinterest}}" target="_blank">
            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="{{ $blog->button_color }}" class="h-6 w-6">
                <title>Pinterest</title>
                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/>
            </svg>
        </a>
        @endif
        @if($media->youtube)
        <a href="{{$media->youtube}}" target="_blank">
            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="{{ $blog->button_color }}" class="h-6 w-6">
                <title>YouTube</title>
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
        </a>
        @endif
        @if($media->linkedin)
        <a href="{{$media->linkedin}}" target="_blank">
            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="{{ $blog->button_color }}" class="h-6 w-6">
                <title>LinkedIn</title>
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
            </svg>
        </a>
        @endif
        @if($media->tiktok)
        <a href="https://www.tiktok.com/{{'@'.$media->tiktok}}" target="_blank">
            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="{{ $blog->button_color }}" class="h-6 w-6">
                <title>TikTok</title>
                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
            </svg>
        </a>
        @endif
    </div>
    <!-- Email collection -->
    @if($blog->emailbox == 'show')
    <div class="p-4 mb-2 mt-3 text-sm rounded-lg hidden alert" role="alert"></div>
    <div class="mt-10 lg:mx-96">
        <form id="email-form">
            <div class="relative ">
                <input type="email" id="email" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm rounded-lg 
                focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5 dark:bg-gray-700 
                dark:border-gray-600 dark:placeholder-gray-400 
                dark:text-white dark:focus:ring-blue-500 
                dark:focus:border-blue-500" 
                placeholder="Enter your email" required>
                <button type="button" id="mail-submit"
                class="absolute top-0 right-0 p-2.5 text-sm 
                font-medium text-white bg-blue-500 rounded-r-lg 
                hover:bg-blue-800 focus:ring-0 
                focus:outline-none focus:ring-blue-300 dark:bg-blue-600 
                dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                style="background-color: {{ $blog->button_color }}">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
    @endif
    <!-- Disclaimer -->
    <div class="mt-6 text-center" style="color: {{$blog->text_color}}">
        {{ $blog->disclaimer }}
    </div>
    <!-- Posts -->
    <div class="mt-16">
        @if($blog->posts == 'single post')
            @forelse ($posts as $post)
                @if($post->published_status != 'Draft')
                @if(!$post->published_date || $post->published_date && date('Y-m-d') >= \Carbon\Carbon::create($post->published_date)->toDateString())
                    @php $images = json_decode($post->images); @endphp
                    <a href="{{route('member-post', [strtolower($project->name), $post->slug])}}">
                        <div class="bg-white border border-gray-200
                            rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
                            style="background-color: {{$blog->post_bg_color}}">
                            <a href="{{route('member-post', [strtolower($project->name), $post->slug])}}">
                                @if(count($images) > 0)
                                <img class="rounded-t-lg h-40 w-64" 
                                src="{{asset($images[0])}}" alt="post" />
                                @else
                                <div class="rounded-t-lg h-40 w-full"></div>
                                @endif
                            </a>
                            <div class="p-5">
                                <a href="{{route('member-post', [strtolower($project->name), $post->slug])}}">
                                    <h5 class="mb-2 text-xl font-bold tracking-tight 
                                    text-gray-900 dark:text-white"
                                    style="color: {{$blog->headline_color}}">
                                        {{ $post->title }}
                                    </h5>
                                </a>
                                <div class="mb-3 font-normal text-gray-700 "
                                style="color: {{$blog->text_color}}">
                                    {!! $post->post !!}
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
                @endif
            @empty
                <p class="font-normal text-gray-700 text-center text-lg mt-4">
                    Currently, there are no posts to show.
                </p>
            @endforelse
        @else
        <div class="lg:grid grid-cols-12 gap-4 lg:px-40">
            @forelse ($posts as $post)
                @if($post->published_status != 'Draft')
                @if(!$post->published_date || $post->published_date && date('Y-m-d') >= \Carbon\Carbon::create($post->published_date)->toDateString())
                    @php $images = json_decode($post->images); @endphp
                    <div class="col-span-4">
                        <a href="{{route('member-post', [strtolower($project->name), $post->slug])}}">
                            <div class="md:max-w-sm w-full bg-white border border-gray-200 h-80
                                rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 mt-4"
                                style="background-color: {{$blog->post_bg_color}}">
                                <a href="{{route('member-post', [strtolower($project->name), $post->slug])}}">
                                    @if(count($images) > 0)
                                    <img class="rounded-t-lg h-40 w-full" 
                                    src="{{asset($images[0])}}" alt="post" />
                                    @else
                                    <div class="rounded-t-lg h-40 w-full"></div>
                                    @endif
                                </a>
                                <div class="p-5">
                                    <a href="{{route('member-post', [strtolower($project->name), $post->slug])}}">
                                        <h5 class="mb-2 text-xl font-bold tracking-tight 
                                        text-gray-900 dark:text-white"
                                        style="color: {{$blog->headline_color}}">
                                            {{ $post->title }}
                                        </h5>
                                    </a>
                                    <div class="mb-3 font-normal text-gray-700 truncate"
                                    style="color: {{$blog->text_color}}">
                                        {!! (strlen($post->post) >= 40) ? substr($post->post,0,40).'...' : $post->post; !!}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @endif
            @empty
                <p class="font-normal text-gray-700 text-center text-lg mt-4">
                    Currently, there are no posts to show.
                </p>
            @endforelse
        </div>
        @endif
    </div>
    <!-- Subscribe Alert -->
    @if($blog->subsscriber_alert == 'show')
    @if(!auth()->guard('subscriber')->check())
        <div style="background-color: {{$blog->subsscriber_alert_color}}" 
            class="mt-6 mx-40">
            <div id="toast-interactive" class="w-full p-4 text-center bg-white border rounded-lg shadow-md sm:p-8" 
                role="alert" style="background-color: {{$blog->subsscriber_alert_color}}">
                <div class="flex justify-center items w-full">
                    <div class="items-center justify-center md:mx-48">
                        <div class="flex items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                            <a href="{{route('member-register', strtolower($project->name))}}"
                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-0 
                                focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 
                                font-medium text-sm px-5 py-4 inline-flex 
                                justify-center text-center "
                                style="background-color: {{$blog->button_color}}">
                                Subscribe 
                                @if($planPrice['price']) 
                                    for as low as ${{ $planPrice['price'] }} / {{ $planPrice['type'] }}
                                @endif
                            </a>
                        </div>
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
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-interactive" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>

        </div>
    @endif
    @endif
</div>

<script>
$(function() {
    $('form#email-form').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url: '/api/mail-signup-blog',
            method: 'post',
            data: { email: $('#email').val(), projectId: {!! $project->custom_id !!} },
            success: function(res) {
                $('#email').val('');
                $('#mail-submit').attr('disabled', false);
                setSuccessAlert(res.message)
            },
            error: function(err) {
                $('#mail-submit').attr('disabled', false);

                if(err.hasOwnProperty('responseJSON')) {
                    setErrorAlert(err.responseJSON.message);
                }else if(err.hasOwnProperty('statusText')) {
                    setErrorAlert(err.statusText);
                }else {
                    console.log(err)
                }
            }
        });
    });

    function setErrorAlert(message) {
        $('.alert').removeClass('hidden')
            .addClass('text-red-700 bg-red-100 block')
            .text(message)

        setTimeout(() => {
            $('.alert').removeClass('text-red-700 bg-red-100 block')
                .addClass('hidden')
                .text('')
        }, 5000)
    }

    function setSuccessAlert(message) {
        $('.alert').removeClass('hidden')
            .addClass('text-green-700 bg-green-100 block')
            .text(message)
        setTimeout(() => {
            $('.alert').removeClass('text-green-700 bg-green-100 block')
                .addClass('hidden')
                .text('')
        }, 5000)
    }
});
</script>
@endsection
