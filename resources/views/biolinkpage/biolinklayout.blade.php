<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="description" content="{{$jdecoded['seo']->title}}">

        <title>{{$jdecoded['seo']->title}}</title>

        <link rel="shortcut icon" href="{{asset($jdecoded['seo']->favicon)}}" type="image/x-icon">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,500&family=Inconsolata&family=Lato&family=Karla&family=Montserrat&display=swap" rel="stylesheet">
        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/solid.min.css" integrity="sha512-uj2QCZdpo8PSbRGL/g5mXek6HM/APd7k/B5Hx/rkVFPNOxAQMXD+t+bG4Zv8OAdUpydZTU3UHmyjjiHv2Ww0PA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite('resources/css/index.css')

        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://unpkg.com/flowbite@1.5.5/dist/flowbite.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://ooblec.co/wp-content/themes/divi-child/js/google-places.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/solid.min.js" integrity="sha512-dcTe66qF6q/NW1X64tKXnDDcaVyRowrsVQ9wX6u7KSQpYuAl5COzdMIYDg+HqAXhPpIz1LO9ilUCL4qCbHN5Ng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @if($jdecoded["analytics"]->googleId)
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{$jdecoded['analytics']->googleId}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{$jdecoded["analytics"]->googleId}}');
        </script>
        @endif

        <!-- Facebook Pixel Code -->
        @if($jdecoded["analytics"]->fbPixel)
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{$jdecoded["analytics"]->fbPixel}}');
            fbq('track', 'PageView');
        </script>
        <noscript>
        <img height="1" width="1" style="display:none" 
            src="https://www.facebook.com/tr?id={{$jdecoded['analytics']->fbPixel}}&ev=PageView&noscript=1"/>
        </noscript>
        @endif
        <!-- End Facebook Pixel Code -->

    </head>
    <body class="antialiased">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-10 items-center justify-center">
                <div class="flex items-center">
                    <div class="hidden md:block">
                        <div class="flex items-center justify-center space-x-4">
                            @if(!auth()->guard('subscriber')->check())
                            <button class="text-white px-3 py-2 rounded-md text-sm font-medium" data-modal-toggle="login-modal">
                                Login
                            </button>
                            @else
                            <form action="{{route('member-link-logout', $projectLinkId)}}" method="post">
                            @csrf
                                <button type="submit" class="text-white px-3 py-2 rounded-md text-sm font-medium">
                                    Logout
                                </button>
                            </form>
                            @endif

                            <a href="{{route('member-index', [strtolower($proj['pname']), $proj['routename']])}}" target="_blank"
                                class="text-white px-3 py-2 rounded-md text-sm font-medium">
                                Member
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden " id="mobile-menu">
                <div class="flex justify-center gap-6 px-2 pt-2 pb-3 sm:px-3">
                    @if(!auth()->guard('subscriber')->check())
                    <a href="#" class="text-white block px-3 py-2 rounded-md text-base font-medium" data-modal-toggle="login-modal">
                        Login
                    </a>
                    @else
                    <form action="{{route('member-link-logout', $projectLinkId)}}" method="post">
                    @csrf
                        <button type="submit" class="text-white px-3 py-2 rounded-md text-sm font-medium">
                            Logout
                        </button>
                    </form>
                    @endif

                    <a href="{{route('member-index', [strtolower($proj['pname']), $proj['routename']])}}" target="_blank" 
                        class="text-white block px-3 py-2 rounded-md text-base font-medium">
                        Member
                    </a>
                </div>
            </div>
        </nav>
        @if($settings->background_type == 'preset')
        <div class="bg-white p-4 overflow-y-auto min-h-screen"
            style="{{$jdecoded['pageBckg']->presetbckg}}">
            @yield('content')
        </div>
        @endif
        @if($settings->background_type == 'gradient')
        <div class="bg-white p-4 overflow-y-auto min-h-screen"
            style="background-image: linear-gradient(109.6deg, {{$jdecoded['pageBckg']->grad1}} 11.2%, {{$jdecoded['pageBckg']->grad2}} 91.1%)">
            @yield('content')
        </div>
        @endif
        @if($settings->background_type == 'color')
        <div class="bg-white p-4 overflow-y-auto min-h-screen"
            style="background: {{$jdecoded['pageBckg']->color}}">
            @yield('content')
        </div>
        @endif
        @if($settings->background_type == 'image' && isset($jdecoded['pageBckg']->image))
        <div class="bg-white p-4 overflow-y-auto min-h-screen"
            style="backgroundImage: {{asset($jdecoded['pageBckg']->image)}};
            backgroundSize: cover;
            backgroundPosition: center;
            backgroundRepeat: no-repeat">
            @yield('content')
        </div>
        @endif
        @if($settings->background_type == 'image' && !isset($jdecoded['pageBckg']->image))
        <div class="bg-white p-4 overflow-y-auto min-h-screen"
            style="{{$jdecoded['pageBckg']->presetbckg}}">
            @yield('content')
        </div>
        @endif

        <div id="login-modal" tabindex="-1" aria-hidden="true" 
            class="fixed top-0 left-0 right-0 z-50 hidden w-full 
            p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-full h-full max-w-md md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" 
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent 
                        hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 
                        ml-auto inline-flex items-center dark:hover:bg-gray-800 
                        dark:hover:text-white" data-modal-toggle="login-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <form class="space-y-6" action="{{route('member-link-login', $projectLinkId)}}" method="post">
                            @csrf
                            <h5 class="text-xl font-medium text-gray-900 dark:text-white">Welcome Back!</h5>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input type="password" name="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                            </div>
                            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>