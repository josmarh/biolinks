<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BioLink</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,500&family=Inconsolata&family=Lato&family=Karla&family=Montserrat&display=swap" rel="stylesheet">
        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/brands.min.css" integrity="sha512-G/T7HQJXSeNV7mKMXeJKlYNJ0jrs8RsWzYG7rVACye+qrcUhEAYKYzaa+VFy6eFzM2+/JT1Q+eqBbZFSHmJQew==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/fontawesome.min.css" integrity="sha512-giQeaPns4lQTBMRpOOHsYnGw1tGVzbAIHUyHRgn7+6FmiEgGGjaG0T2LZJmAPMzRCl+Cug0ItQ2xDZpTmEc+CQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/regular.min.css" integrity="sha512-k2UAKyvfA7Xd/6FrOv5SG4Qr9h4p2oaeshXF99WO3zIpCsgTJ3YZELDK0gHdlJE5ls+Mbd5HL50b458z3meB/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/solid.min.css" integrity="sha512-6mc0R607di/biCutMUtU9K7NtNewiGQzrvWX4bWTeqmljZdJrwYvKJtnhgR+Ryvj+NRJ8+NnnCM/biGqMe/iRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite('resources/css/index.css')

        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://unpkg.com/flowbite@1.5.5/dist/flowbite.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/brands.min.js" integrity="sha512-rbApvPERCHI8cOpTOKfMLVJNlXSCs4QRu8UsJ0HieeHyNKkHtUIQTZq3hv0pT7X0SUsLrRGEUsMTTpzwpdeIuw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/fontawesome.min.js" integrity="sha512-nKvEIGRKw2OQCR34yLfnWnvrOBxidLG9aK+vzsBxCZ/9ZxgcS4FrYcN+auWUTkCitTVZAt82InDKJ7x+QtKu6g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/regular.min.js" integrity="sha512-H1PxHAj13z6ipNSlyM5ftUSOSvQXeH0eOsPjEpSOcjSROPLIxhKB0PLGSAbFDqEqe2vd2xPkUnEfVtBS/RNlmw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/solid.min.js" integrity="sha512-F0Gp9qi8/3qyo+62Pi1ZgGe6hAUxPbzOnqhhpJYAMUGDmOys95dCRCVYfQawlUeoGp1Rj/K9V7NboA9sQ9BtKw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
    </head>
    <body class="antialiased block px-10 pb-16 pt-3">
        @php $settings = json_decode($blog->main_setting); @endphp
        @php $media = json_decode($blog->smedia); @endphp

        @if(Route::current()->getName() == 'member-post' 
        || Route::current()->getName() == 'member-login'
        || Route::current()->getName() == 'member-register')
        <div class="flex justify-between">
        @else
        <div class="flex justify-end">
        @endif
            @if(Route::current()->getName() == 'member-post' 
            || Route::current()->getName() == 'member-login'
            || Route::current()->getName() == 'member-register')
            <a href="{{route('member-index', [strtolower($project->name), $settings->urlPath])}}"
            class="text-gray-900 bg-white border border-white 
            focus:outline-none focus:ring-0 text-blue-600
            focus:ring-gray-200 font-medium text-sm 
            px-5 py-3 mb-5 dark:bg-gray-800 dark:text-white 
            dark:border-gray-600 dark:hover:bg-gray-700 
            dark:hover:border-gray-600 dark:focus:ring-gray-700">
                <i class="fa-solid fa-left-long"></i>
                @if(Route::current()->getName() == 'member-post')
                Back to all posts
                @else
                Back to home
                @endif
            </a>
            @endif
            @if($settings->showSubLoginBar =='yes')
            <div class="flex gap-2 md:justify-end justify-center mb-4">
                @if(!auth()->guard('subscriber')->check())
                    <a href="{{route('member-register', strtolower($project->name))}}" 
                    class="text-white bg-blue-500 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-5 py-3 mb-2 dark:bg-blue-600 
                    dark:hover:bg-blue-700 focus:outline-none 
                    dark:focus:ring-blue-800"
                    style="background-color: {{$blog->button_color}}">
                        Subscribe
                    </a>
                    <a href="{{route('member-login', strtolower($project->name))}}"
                    class="text-gray-900 bg-white border border-gray-300 
                    focus:outline-none focus:ring-0 
                    focus:ring-gray-200 font-medium text-sm 
                    px-5 py-2.5 mb-2 dark:bg-gray-800 dark:text-white 
                    dark:border-gray-600 dark:hover:bg-gray-700 
                    dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        Login
                    </a>
                @elseif(auth()->guard('subscriber')->check())
                    <!-- Profile dropdown -->
                    <button id="dropdownDefaultButton" 
                    data-dropdown-toggle="dropdown" 
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:outline-none focus:ring-blue-300 
                    font-medium rounded-full text-sm px-2.5 py-2.5 text-center 
                    inline-flex items-center dark:bg-blue-600" type="button">
                    <i class="fa fa-circle-user w-6 h-6"></i>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <div class="font-medium truncate">{{ auth()->guard('subscriber')->user()->email }}</div>
                        </div>
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="{{route('member-index', [strtolower($project->name), $settings->urlPath])}}" 
                                class="block px-4 py-2 hover:bg-gray-100">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="{{route('member-library', strtolower($project->name))}}" 
                                class="block px-4 py-2 hover:bg-gray-100">
                                    Digital Library
                                </a>
                            </li>
                            <li>
                                <a href="{{route('member-account', strtolower($project->name))}}" 
                                class="block px-4 py-2 hover:bg-gray-100">
                                    Account
                                </a>
                            </li>
                            <!-- <li>
                                <a href="{{route('member-orders', strtolower($project->name))}}" 
                                class="block px-4 py-2 hover:bg-gray-100">
                                    Past Orders
                                </a>
                            </li> -->
                            <li >
                                <form action="{{route('member-logout', $project->name)}}" method="post">
                                    @csrf
                                    <button class="block px-4 py-2 hover:bg-gray-100 text-start w-full">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
            @endif
        </div>

        @yield('content')
    </body>
</html>