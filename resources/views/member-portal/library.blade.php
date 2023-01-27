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
        {{ $product }}
        <div class="grid grid-cols-12 gap-4 mt-16">
            @foreach($plans as $membership)
                <div class="col-span-3">
                    <div class="max-w-sm bg-white 
                        border border-gray-200
                        rounded-lg shadow-md">
                        <a href="javascript:void(0)">
                            <div class="rounded-t-lg h-40 w-full"></div>
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
                                    class="inline-flex items-center px-6 py-3 text-sm 
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
            @foreach($product as $prod)
                <div class="col-span-3">
                    <div class="max-w-sm bg-white 
                        border border-gray-200
                        rounded-lg shadow-md">
                        <a href="javascript:void(0)">
                            @php $images = json_decode($prod->images); @endphp
                            @if(count($images) > 0)
                            <img class="rounded-t-lg h-40 w-64" 
                            src="{{asset($images[0])}}" alt="digital product" />
                            @else
                            <div class="rounded-t-lg h-40 w-full"></div>
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
                            <div class="mb-3 font-normal text-gray-700 text-center truncate">
                                {!! $prod->description !!}
                            </div>
                            <div class="flex justify-center mt-6">
                                <a href="" 
                                    target="_blank" 
                                    class="inline-flex items-center px-6 py-3 text-sm 
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