@extends('member-portal.layout')

@section('content')
    <!-- Title section -->
<div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full space-y-8">
        <div>
            <h5 class="mb-2 text-4xl font-bold tracking-tight 
            text-gray-900 dark:text-white text-center">
                Digital library / products
            </h5>
        </div>
        
        <div class="grid grid-cols-12 gap-4 mt-20">
            <!-- Member plan -->
            @foreach($plans as $membership)
                <div class="col-span-3">
                    <div class="max-w-sm bg-white 
                        border border-gray-200
                        rounded-lg shadow-md">
                        <a href="javascript:void(0)">
                            <div class="rounded-t-lg h-32 w-full"></div>
                        </a>
                        <div class="p-5">
                            <a href="javascript:void(0)">
                                <h5 class="mb-2 text-xl font-bold 
                                tracking-tight text-gray-900 text-center">
                                    <!-- title of the blog -->
                                    {{ $membership->blogTitle }}
                                </h5>
                            </a>
                            <div class="mb-3 font-normal text-gray-700 text-center truncate">
                                <!-- Plan name -->
                                ({{ $membership->planName }})
                            </div>
                            <div class="flex justify-center mt-6">
                                <a href="{{route('member-index',[$membership->projectName, $membership->blogPath])}}" 
                                    target="_blank" 
                                    class="inline-flex items-center px-6 py-2 text-sm 
                                    font-medium text-center text-white bg-blue-700 rounded-lg 
                                    hover:bg-blue-800 focus:ring-0 focus:outline-none 
                                    focus:ring-blue-300 dark:bg-blue-600 plan-modal">
                                    Access
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Digital products -->
            @foreach($product as $prod)
                @php $images = json_decode($prod->images); @endphp
                @php $files = json_decode($prod->files) @endphp

                @if($prod->external_link)
                    <div class="col-span-3">
                        <div class="w-full bg-white 
                            border border-gray-200
                            rounded-lg shadow-md">
                            <a href="javascript:void(0)">
                                @if(count($images) > 0)
                                <img class="rounded-t-lg h-32 w-full" 
                                src="{{asset($images[0])}}" alt="digital product" />
                                @else
                                <div class="rounded-t-lg h-32 w-full bg-gray-600"></div>
                                @endif
                            </a>
                            <div class="p-5">
                                <a href="javascript:void(0)">
                                    <h5 class="mb-2 text-xl font-bold 
                                    tracking-tight text-gray-900 text-center">
                                        <!-- title of the blog -->
                                        {{ $prod->title }}
                                    </h5>
                                </a>
                                <div class="mb-3 font-normal text-gray-700 text-center">
                                    {!! (strlen($prod->description) > 13) ? substr($prod->description,0,60).'...' : $prod->description; !!}
                                </div>
                                <div class="flex justify-center mt-6">
                                    <a href="{{$prod->external_link}}" target="_blank"
                                        class="mt-3 inline-flex items-center 
                                        px-6 py-2 text-sm font-medium text-center 
                                        text-white bg-blue-700 rounded-lg 
                                        hover:bg-blue-800 focus:ring-4 focus:outline-none 
                                        focus:ring-blue-300 dark:bg-blue-600 
                                        dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Access
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(count($files) > 0)
                    @foreach($files as $file)
                    <div class="col-span-3">
                        <div class="w-full bg-white 
                            border border-gray-200
                            rounded-lg shadow-md">
                            <a href="javascript:void(0)">
                                @if(count($images) > 0)
                                <img class="rounded-t-lg h-32 w-full" 
                                src="{{asset($images[0])}}" alt="digital product" />
                                @else
                                <div class="rounded-t-lg h-32 w-full bg-gray-600"></div>
                                @endif
                            </a>
                            <div class="p-5">
                                <a href="javascript:void(0)">
                                    <h5 class="mb-2 text-xl font-bold 
                                    tracking-tight text-gray-900 text-center">
                                        <!-- title of the blog -->
                                        {{ $prod->title }}
                                    </h5>
                                    <h5 class="mb-2 text-sm font-medium 
                                    tracking-tight text-gray-900 text-center">
                                        ({{ $file->name }})
                                    </h5>
                                </a>
                                <div class="mb-3 font-normal text-gray-700 text-center">
                                    {!! (strlen($prod->description) > 13) ? substr($prod->description,0,60).'...' : $prod->description; !!}
                                </div>
                                <div class="flex justify-center mt-6">
                                    <form action="{{ route('download.product') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="file" value="{{ $file->file }}">
                                        <input type="hidden" name="type" value="{{ $file->type }}">
                                        <button class="mt-3 inline-flex items-center 
                                            px-6 py-2 text-sm font-medium text-center 
                                            text-white bg-blue-700 rounded-lg 
                                            hover:bg-blue-800 focus:ring-4 focus:outline-none 
                                            focus:ring-blue-300 dark:bg-blue-600 
                                            dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Access
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            @endforeach

            <!-- Post -->
            @foreach($posts as $post)
            <div class="col-span-3">
                <div class="w-full bg-white 
                    border border-gray-200
                    rounded-lg shadow-md">
                    <a href="javascript:void(0)">
                        @if($post->thumbnail)
                        <img class="rounded-t-lg h-32 w-full" 
                        src="{{asset($post->thumbnail)}}" alt="Blog post" />
                        @else
                        <div class="rounded-t-lg h-32 w-full"></div>
                        @endif
                    </a>
                    <div class="p-5">
                        <a href="javascript:void(0)">
                            <h5 class="mb-2 text-xl font-bold 
                            tracking-tight text-gray-900 text-center">
                                <!-- title of the blog -->
                                {{ $post->postTitle }}
                            </h5>
                        </a>
                        <div class="mb-3 font-normal text-gray-700 text-center truncate">
                            <!-- Plan name -->
                            (Blog Post)
                        </div>
                        <div class="flex justify-center mt-6">
                            <a href="{{route('member-post',[$post->projectName, $post->slug])}}" 
                                target="_blank" 
                                class="inline-flex items-center px-6 py-2 text-sm 
                                font-medium text-center text-white bg-blue-700 rounded-lg 
                                hover:bg-blue-800 focus:ring-0 focus:outline-none 
                                focus:ring-blue-300 dark:bg-blue-600 plan-modal">
                                Access
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection