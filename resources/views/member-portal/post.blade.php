@extends('member-portal.layout')

@section('content')
@php $settings = json_decode($blog->main_setting); @endphp
@php $media = json_decode($blog->smedia); @endphp

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
            <div class="mb-3 mt-10 font-normal text-gray-700"
            style="color: {{$blog->text_color}}">
                {!! $post->post !!}
            </div>
            @if(count($images) > 0)
            <div class="mt-6">
                @foreach($images as $img)
                @if($img != $images[0])
                <img class="rounded-lg h-80 w-full mx-auto mt-4" 
                src="{{asset($img)}}" alt="post" />
                @endif
                @endforeach
            </div>
            @endif
            @if(count($medias) > 0)
            <div class="mt-6 w-full">
                @foreach($medias as $media)
                    @if(str_contains($media->type, 'video'))
                        <video class="w-full mt-4" controls>
                        <source src="{{asset($media->file)}}" type="{{$media->type}}">
                        Your browser does not support the video tag.
                        </video>
                    @elseif(str_contains($media->type, 'audio'))
                        <audio class="w-full mt-4" controls>
                        <source src="{{asset($media->file)}}" type="{{$media->type}}">
                        Your browser does not support the video tag.
                        </audio>
                    @elseif(str_contains($media->type, 'image'))
                        <img class="rounded-lg h-80 w-full mx-auto mt-4" 
                        src="{{asset($media->file)}}" alt="post" />
                    @endif
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product -->
        @if($products->count() > 0)
        <div class="mt-10">
            <h1 class="text-2xl font-bold tracking-tight 
            text-gray-900 dark:text-white"
            style="color: {{$blog->headline_color}}">Products</h1>
            <div class="mt-4">
            <div class="grid grid-cols-12 gap-4">
            @foreach($products as $product)
                @php $image = json_decode($product->images) @endphp
                @php $files = json_decode($product->files) @endphp
                <!-- add grid here -->
                
                    @foreach($files as $file)
                    <div class="col-span-6 mt-2">
                        <div class="w-full bg-white border border-gray-200 
                            rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <a href="#">
                                @if(count($image) > 0)
                                    <img class="rounded-t-lg h-32 w-full" src="{{ asset($image[0]) }}" alt="" />
                                @else
                                    <div class="rounded-t-lg h-32 w-full bg-gray-600"></div>    
                                @endif
                            </a>
                            <div class="p-5">
                                <a href="#">
                                    <h5 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $file->name }}
                                    </h5>
                                </a>
                                <div class="mb-3 font-normal text-gray-700 text-xs dark:text-gray-400 cursor-pointer"
                                    title="{!! $product->description !!}">
                                    {!! (strlen($product->description) > 13) ? substr($product->description,0,70).'...' : $product->description; !!}
                                </div>
                                <form action="{{ route('download.product') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="file" value="{{ $file->file }}">
                                    <input type="hidden" name="type" value="{{ $file->type }}">
                                    <button class="mt-3 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Download
                                    <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                
            @endforeach
            </div>
            </div>
        </div>
        @endif
        
        <!-- Categories -->
        @php $categories = json_decode($post->categories); @endphp
        @if(count($categories) > 0)
        <div class="">
            <div class="flex flex-wrap gap-1 mt-6">
                @foreach($categories as $category)
                <div class="mt-1">
                    <div class="flex mb-0.5">
                        <span class="flex bg-blue-200 text-blue-800 text-sm font-medium 
                            mr-2 px-2.5 py-1.5 rounded dark:bg-blue-200 dark:text-blue-800">
                            {{ $category }} &nbsp
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection