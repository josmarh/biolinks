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
    </div>
</div>
@endsection