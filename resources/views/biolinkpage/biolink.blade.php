@extends('biolinkpage.biolinklayout')

@section('content')

<div class="mt-14">
    <!-- Top Logo -->
    @if($settings->top_logo)
    <img id="top-logo" src="{{asset($settings->top_logo)}}" class="w-32 h-32 mx-auto rounded-full">
    @endif

    <!-- Title -->
    @if($settings->title)
    <h5 class="mb-0 text-4xl font-bold tracking-tight 
        text-gray-900 dark:text-white text-center mt-4"
        style="color: {{$settings->text_color}}; 'font-family': {{$settings->font}}">
        {{$settings->title}}
    </h5>
    @endif
    <!-- Description -->
    @if($settings->description)
    <p class="text-lg font-normal text-center mt-4 tracking-tight flex justify-center"
    style="color: {{$settings->text_color}}; 'font-family': {{$settings->font}}">
        {{ $settings->description }}
    </p>
    @endif
    <!-- Video Display -->
    @if($jdecoded['video']->type == 'youtube' && isset($jdecoded['video']->link))
    <div class="mt-6 mx-auto lg:mx-72">
        <x-iframe-video :videoUrl="$jdecoded['video']->link"/>
    </div>
    @endif
    @if($jdecoded['video']->type == 'vimeo' && isset($jdecoded['video']->link))
    <div class="mt-0 mx-auto">
        <x-iframe-video :videoUrl="$jdecoded['video']->link"/>
    </div>
    @endif

    <!-- Section views -->
    @foreach($section as $item)
        @php $sectionField = json_decode($item['core_section_fields']); @endphp
         <!-- Vimeo -->
        @if($item->section_name == 'Vimeo' && $item->status == 1)
        <div class="mt-6 mb-4 mx-auto lg:mx-72">
            <iframe 
                src="" 
                frameborder="0" 
                width="100%" 
                height="350"
                data-url="{{$sectionField->vimeoUrl}}"
                class="video-iframe"
            ></iframe>
        </div>
        @endif
        <!-- Youtube -->
        @if($item->section_name == 'Youtube' && $item->status == 1)
        <div class="mt-6 mb-4 mx-auto lg:mx-72">
            <iframe 
                src=""
                frameborder="0" 
                width="100%" 
                height="350"
                data-url="{{$sectionField->youtubeUrl}}"
                class="video-iframe"
            ></iframe>
        </div>
        @endif
        <!-- Spotify -->
        @if($item->section_name == 'Spotify' && $item->status == 1)
        <div class="mt-6 mb-6 mx-auto lg:mx-72">
            @if(str_contains($sectionField->spotifyUrl, 'show') || str_contains($sectionField->spotifyUrl, 'episode'))
                <iframe 
                    src="" 
                    class="video-iframe" 
                    data-url="{{$sectionField->spotifyUrl}}"
                    width="100%" 
                    height="232" 
                    frameborder="0"
                    allowtransparency="true" 
                    allow="encrypted-media"
                ></iframe>
            @endif
            @if(str_contains($sectionField->spotifyUrl, 'track'))
            <div class="mt-6">
                <iframe 
                    scrolling="no" 
                    frameborder="no" 
                    src="" 
                    class="video-iframe" 
                    data-url="{{$sectionField->spotifyUrl}}"
                    width="100%"
                ></iframe>
            </div>
            @endif
            <div class="mt-6">
            @if(str_contains($sectionField->spotifyUrl, 'album'))
                <iframe 
                    scrolling="no" 
                    frameborder="no" 
                    src="" 
                    class="video-iframe"
                    data-url="{{$sectionField->spotifyUrl}}"
                    width="100%" 
                    style="height: 380px;"
                ></iframe>
            @endif
            </div>
        </div>
        @endif
        <!-- Soundcloud -->
        @if($item->section_name == 'Soundcloud' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-72">
            <iframe class="embed-responsive-item" scrolling="no" frameborder="no" width="100%" height="350"
            src="https://w.soundcloud.com/player/?url={{$sectionField->soundcloudUrl}}&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>
        </div>
        @endif
        <!-- Twitch -->
        @if($item->section_name == 'Twitch' && $item->status == 1)
        <div class="mt-6 mb-4 mx-auto lg:mx-72">
            <iframe
                src=""
                scrolling="no"
                frameborder="no"
                width="100%"
                height="350"
                data-url="{{$sectionField->twitchUrl}}"
                class="embed-responsive-item video-iframe"
            ></iframe>
        </div>
        @endif
        <!-- Clubhouse -->
        @if($item->section_name == 'Clubhouse' && $item->status == 1)
        <div class="mt-6 mb-4 mx-auto lg:mx-72">
            <h1 class="font-bold text-3xl text-center" 
                style="color: {{$sectionField->titleColor}}">
                {{$sectionField->title}}
            </h1>
            <p class="mt-2 text-center font-semibold" 
                :style="{color: item.sectionFields.titleColor}"
                v-html="item.sectionFields.description"></p>
            <div class="flex justify-center mt-2">
                <a href="{{$sectionField->clubhouseLink}}"
                    target="_blank"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:outline-none focus:ring-0 focus:ring-blue-300 
                    font-medium rounded-full text-md px-5 py-2.5 
                    text-center mr-2 mb-2 dark:bg-blue-600 w-full
                    dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    style="color: {{$item->button_text_color}}; background-color: {{$item->button_bg_color}}">
                    {{$item->button_text}}
                </a>
            </div>
        </div>
        @endif
        <!-- Text Block -->
        @if($item->section_name == 'Text Block' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-72">
            @if($sectionField->type == 'image' && isset($sectionField->typeContentImage))
            <img src="{{asset($sectionField->typeContentImage)}}"
                class="w-32 h-32 mx-auto rounded-full"/>
            @endif
            @if($sectionField->type == 'video')
                @if($sectionField->typeContentVideo == 'youtube' && isset($sectionField->typeContentVideoUrl))
                <iframe 
                    src="" 
                    frameborder="0" 
                    width="100%" 
                    height="350"
                    data-url="{{$sectionField->typeContentVideoUrl}}"
                    class="video-iframe"
                ></iframe>
                @endif
                @if($sectionField->typeContentVideo == 'vimeo' && isset($sectionField->typeContentVideoUrl))
                <iframe 
                    src="" 
                    frameborder="0" 
                    width="100%" 
                    height="350"
                    data-url="{{$sectionField->typeContentVideoUrl}}"
                    class="video-iframe"
                ></iframe>
                @endif
            @endif
            <h1 class="font-bold text-3xl text-center mt-6" 
                style="color: {{$sectionField->titleColor}}">
                {{$sectionField->title}}
            </h1>
            @if(isset($sectionField->link) && isset($item->button_text))
            <div class="flex justify-center mt-4">
                <a href="{{$sectionField->link}}" 
                    target="_blank"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:outline-none focus:ring-0 focus:ring-blue-300 
                    font-medium rounded-full text-md px-5 py-2.5 
                    text-center mr-2 mb-2 dark:bg-blue-600 w-full
                    dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    style="color: {{$item->button_text_color}};
                        background-color: {{$item->button_bg_color}}">
                    {{$item->button_text}}
                </a>
            </div>
            @endif
        </div>
        @endif
        <!-- FB Group -->
        @if($item->section_name == 'Facebook Group' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-72">
            @if($sectionField->type == 'image' && isset($sectionField->typeContentImage))
            <img src="{{asset($sectionField->typeContentImage)}}"
                class="w-32 h-32 mx-auto rounded-full"/>
            @endif
            @if($sectionField->type == 'video')
                @if($sectionField->typeContentVideo == 'youtube' && isset($sectionField->typeContentVideoUrl))
                <iframe 
                    src="" 
                    frameborder="0" 
                    width="100%" 
                    height="350"
                    data-url="{{$sectionField->typeContentVideoUrl}}"
                    class="video-iframe"
                ></iframe>
                @endif
                @if($sectionField->typeContentVideo == 'vimeo' && isset($sectionField->typeContentVideoUrl))
                <iframe 
                    src="" 
                    frameborder="0" 
                    width="100%" 
                    height="350"
                    data-url="{{$sectionField->typeContentVideoUrl}}"
                    class="video-iframe"
                ></iframe>
                @endif
            @endif
            <h1 class="font-bold text-3xl text-center mt-6" 
                style="color: {{$sectionField->titleColor}}">
                {{$sectionField->title}}
            </h1>
            <p class="text-lg font-normal text-center mt-4 tracking-tight flex justify-center"
                style="color: {{$sectionField->titleColor}};">
                {{ $sectionField->description }}
            </p>
            @if(isset($sectionField->fbGroupLink) && isset($item->button_text))
            <div class="flex justify-center mt-4">
                <a href="{{$sectionField->fbGroupLink}}" 
                    target="_blank"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:outline-none focus:ring-0 focus:ring-blue-300 
                    font-medium rounded-full text-md px-5 py-2.5 
                    text-center mr-2 mb-2 dark:bg-blue-600 w-full
                    dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    style="color: {{$item->button_text_color}};
                        background-color: {{$item->button_bg_color}}">
                    {{$item->button_text}}
                </a>
            </div>
            @endif
        </div>
        @endif
        <!-- TikTok -->
        @if($item->section_name == 'TikTok' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-72">
            <iframe
                class="embed-responsive-item min-h-[46em] video-iframe"
                scrolling="no"
                frameborder="no"
                width="100%"
                allow="accelerometer;autoplay;encrypted-media;gyroscope;picture-in-picture"
                src=""
                data-url="{{$sectionField->tiktokUrl}}"
            ></iframe>
        </div>
        @endif
        <!-- WhatsApp -->
        @if($item->section_name == 'WhatsApp' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-72">
            @if($sectionField->type == 'image' && isset($sectionField->typeContentImage))
            <img src="{{asset($sectionField->typeContentImage)}}"
                class="w-32 h-32 mx-auto rounded-full"/>
            @endif
            @if($sectionField->type == 'video')
                @if($sectionField->typeContentVideo == 'youtube' && isset($sectionField->typeContentVideoUrl))
                <iframe 
                    src="" 
                    frameborder="0" 
                    width="100%" 
                    height="350"
                    data-url="{{$sectionField->typeContentVideoUrl}}"
                    class="video-iframe"
                ></iframe>
                @endif
                @if($sectionField->typeContentVideo == 'vimeo' && isset($sectionField->typeContentVideoUrl))
                <iframe 
                    src="" 
                    frameborder="0" 
                    width="100%" 
                    height="350"
                    data-url="{{$sectionField->typeContentVideoUrl}}"
                    class="video-iframe"
                ></iframe>
                @endif
            @endif
            <h1 class="font-bold text-3xl text-center mt-6" 
                style="color: {{$sectionField->titleColor}}">
                {{$sectionField->title}}
            </h1>
            <p class="mt-2 text-center font-semibold"
                style="color: {{$sectionField->titleColor}};">
                {{ $sectionField->description }}
            </p>
            @if(isset($sectionField->whatsappNumber) && isset($item->button_text))
            <div class="flex justify-center mt-4">
                <a href="https://wa.me/{{$sectionField->whatsappNumber}}" 
                    target="_blank"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:outline-none focus:ring-0 focus:ring-blue-300 
                    font-medium rounded-full text-md px-5 py-2.5 
                    text-center mr-2 mb-2 dark:bg-blue-600 w-full
                    dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    style="color: {{$item->button_text_color}};
                        background-color: {{$item->button_bg_color}}">
                    {{$item->button_text}}
                </a>
            </div>
            @endif
        </div>
        @endif
        <!-- Calendly -->
        @if($item->section_name == 'Calendly' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-72">
            <h1 class="font-bold text-3xl text-center mt-6" 
                style="color: {{$sectionField->titleColor}}">
                {{$sectionField->title}}
            </h1>
            <p class="mt-2 text-center font-semibold"
                style="color: {{$sectionField->titleColor}};">
                {{ $sectionField->description }}
            </p>
            @if(isset($sectionField->calendlyLink) && isset($item->button_text))
            <div class="flex justify-center mt-4">
                <a href="{{$sectionField->calendlyLink}}" 
                    target="_blank"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:outline-none focus:ring-0 focus:ring-blue-300 
                    font-medium rounded-full text-md px-5 py-2.5 
                    text-center mr-2 mb-2 dark:bg-blue-600 w-full
                    dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    style="color: {{$item->button_text_color}};
                        background-color: {{$item->button_bg_color}}">
                    {{$item->button_text}}
                </a>
            </div>
            @endif
        </div>
        @endif
        <!-- FAQ -->
        @if($item->section_name == 'FAQ' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-72">

        </div>
        @endif

    @endforeach
</div>

<script>
let videoIframe = document.querySelectorAll(".video-iframe");

for(let i of videoIframe) {
    i.src = extractVideoId(i.dataset.url)
}

function openExternalLink(url) {
    window.open(url);
}

function extractVideoId(video) {
    if(video.includes('youtube') || video.includes('youtu')) {
        if(video.includes('https://youtube.com/watch?v=')){
            video = video.replace("https://youtube.com/watch?v=","");
        }else if(video.includes('https://www.youtube.com/watch?v=')){
            video = video.replace("https://www.youtube.com/watch?v=","");
        }else if(video.includes("https://youtu.be/")){
            video = video.replace("https://youtu.be/","");
        }
        videoURL = `https://youtube.com/embed/${video}`
    }else if(video.includes('vimeo')) {
        if(video.includes('https://vimeo.com/')){
            video = video.replace("https://vimeo.com/","");
        }else if(video.includes('https://www.vimeo.com/')){
            video = video.replace("https://www.vimeo.com/","");
        }
        videoURL = `https://player.vimeo.com/video/${video}?h=8ef4640006`
    }else if(video.includes('spotify')) {
        if(video.includes('track')) {
            video = video.replace("https://open.spotify.com/track/","");
            videoURL = `https://open.spotify.com/embed/track/${video}`
        }else if(video.includes('album')) {
            video = video.replace("https://open.spotify.com/album/","");
            videoURL = `https://open.spotify.com/embed/album/${video}`
        }else if(video.includes('show')) {
            video = video.replace("https://open.spotify.com/show/","");
            videoURL = `https://open.spotify.com/embed/show/${video}?theme=0`
        }else if(video.includes('episode')) {
            video = video.replace("https://open.spotify.com/episode/","");
            videoURL = `https://open.spotify.com/embed/episode/${video}?theme=0`
        }
    }else if(video.includes('twitch')) {
        video = video.replace("https://www.twitch.tv/","");
        videoURL = `https://player.twitch.tv/?channel=${video}&autoplay=false&parent=${window.location.host}`
    }else if(video.includes('tiktok')) {
        video = video.split('/')[5];
        videoURL = `https://www.tiktok.com/embed/${video}`
    }else {
        video = videoURL;
    }
    return videoURL;
}
</script>
@endsection