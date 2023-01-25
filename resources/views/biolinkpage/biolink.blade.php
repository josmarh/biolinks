@extends('biolinkpage.biolinklayout')

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
    <div class="mt-4 text-center font-semibold"
    style="color: {{$settings->text_color}}; 'font-family': {{$settings->font}}">
        {!! $settings->description !!}
    </div>
    @endif
    <!-- Video Display -->
    @if($jdecoded['video']->type == 'youtube' && $jdecoded['video']->link)
    <div class="mt-6 mx-auto lg:mx-72">
        <x-iframe-video :videoUrl="$jdecoded['video']->link"/>
    </div>
    @endif
    @if($jdecoded['video']->type == 'vimeo' && $jdecoded['video']->link)
    <div class="mt-0 mx-auto">
        <x-iframe-video :videoUrl="$jdecoded['video']->link"/>
    </div>
    @endif

    <!-- Section views -->
    @foreach($section as $item)
        @php $sectionField = json_decode($item['core_section_fields']); @endphp
        <!-- product/membership -->
        @if($item->section_name == 'Product/Membership' && $item->status == 1)
        @if(!$sectionField->schedule || ($sectionField->schedule && $sectionField->schedule >= date('Y-m-d')))
            <div class="mt-6 mb-4 mx-auto lg:mx-96">
                <div class="items-center bg-white border rounded-lg p-2
                    shadow-md md:flex-row cursor-pointer product-modal
                    dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-modal-toggle="product-modal"
                    data-section-id="{{$item->section_id}}"
                    data-description="{{ $sectionField->description }}"
                    data-form-name="{{$sectionField->title}}"
                    data-amount="{{ $sectionField->productInfo->cost ?? 0}}"
                    data-link-id="{{$settings->link_id}}"
                    data-product-id="{{$sectionField->productInfo->id}}"
                    data-product-type="{{$sectionField->productType}}"
                    style="color: {{$item->button_text_color}};background-color: {{$item->button_bg_color}}">
                    <div class="flex justify-between">
                        <div class="flex ">
                            @if(isset($sectionField->thumbnail))
                            <img :src="{{asset($sectionField->thumbnail)}}"
                            class="ml-4 w-14 h-14 mx-auto rounded-full"/>
                            @else
                            <span class="ml-4 mt-2 mb-2 bg-orange-500 rounded p-3 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 007.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 004.902-5.652l-1.3-1.299a1.875 1.875 0 00-1.325-.549H5.223z" />
                                    <path fill-rule="evenodd" d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 009.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 002.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 010 1.5H2.25a.75.75 0 010-1.5H3zm3-6a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75v-3zm8.25-.75a.75.75 0 00-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-5.25a.75.75 0 00-.75-.75h-3z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            @endif
                            <div class="flex flex-col justify-between p-3 leading-normal">
                                <h5 class="text-lg font-semibold tracking-tight text-gray-900 
                                dark:text-white truncate">
                                    {{ $sectionField->title }}
                                </h5>
                                @if($sectionField->description)
                                <div v-if="item.sectionFields.description" 
                                    class="font-normal text-gray-700 dark:text-gray-400 text-sm">
                                    {!! $sectionField->description !!}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-3 px-2">
                            ${{ $sectionField->productInfo->cost ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endif
        <!-- Donation -->
        @if($item->section_name == 'Donation' && $item->status == 1)
        <!-- Include time schedule -->
            @if(!$sectionField->schedule || ($sectionField->schedule && $sectionField->schedule >= date('Y-m-d')))
            <div class="mt-6 mb-4 mx-auto lg:mx-96">
                <div class="items-center bg-white border rounded-lg p-2
                shadow-md md:flex-row cursor-pointer donation-modal
                dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                data-modal-toggle="donation-modal"
                data-section-id="{{$item->section_id}}"
                data-description="{{$sectionField->description}}"
                data-title="{{$sectionField->title}}"
                data-link-id="{{$settings->link_id}}"
                data-form-name="Donation"
                style="color: {{$item->button_text_color}};background-color: {{$item->button_bg_color}}">
                    <div class="flex justify-between">
                        <div class="flex">
                            @if(isset($sectionField->thumbnail))
                            <img :src="{{asset($sectionField->thumbnail)}}"
                            class="ml-4 w-14 h-14 mx-auto rounded-full"/>
                            @else
                            <span class="ml-4 mt-2 mb-2 bg-green-500 rounded p-3 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                            </span>
                            @endif
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <p class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white truncate">
                                    {{ $sectionField->title }}
                                </p>
                                <!-- @if($sectionField->description)
                                <div class="font-normal text-gray-700 dark:text-gray-400 text-sm">
                                    {!! $sectionField->description !!}
                                </div>
                                @endif -->
                            </div>
                        </div>
                        <span class="mt-4 px-4">$</span>
                    </div>
                </div>
            </div>
            @endif
        @endif
        <!-- Fan Request -->
        @if($item->section_name == 'Fan Request' && $item->status == 1)
            @if(!$sectionField->schedule || ($sectionField->schedule && $sectionField->schedule >= date('Y-m-d')))
            <div class="mt-6 mb-4 mx-auto lg:mx-96">
                <div class="items-center bg-white border rounded-lg p-2
                shadow-md md:flex-row cursor-pointer fanrequest-modal
                dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                data-modal-toggle="fanrequest-modal"
                data-section-id="{{$item->section_id}}"
                data-description="{{ $sectionField->description }}"
                data-title="{{ $sectionField->title }}"
                data-link-id="{{$settings->link_id}}"
                data-form-name="Request"
                data-amount="{{$sectionField->requestCost}}"
                style="color: {{$item->button_text_color}};background-color: {{$item->button_bg_color}}">
                    <div class="flex justify-between">
                        <div class="flex">
                            @if(isset($sectionField->thumbnail))
                            <img :src="{{asset($sectionField->thumbnail)}}"
                            class="ml-4 w-14 h-14 mx-auto rounded-full"/>
                            @else
                            <span class="ml-4 mt-2 mb-2 bg-orange-500 rounded p-3 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                </svg>
                            </span>
                            @endif
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <p class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white truncate">
                                    {{ $sectionField->title }}
                                </p>
                                <!-- @if($sectionField->description)
                                <div class="font-normal text-gray-700 dark:text-gray-400 text-sm">
                                    {!! $sectionField->description !!}
                                </div>
                                @endif -->
                            </div>
                        </div>
                        <span class="mt-4 px-4">${{ $sectionField->requestCost }}</span>
                    </div>
                </div>
            </div>
            @endif
        @endif
         <!-- Vimeo -->
        @if($item->section_name == 'Vimeo' && $item->status == 1)
        <div class="mt-6 mb-4 mx-auto lg:mx-96">
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
        <div class="mt-6 mb-4 mx-auto lg:mx-96">
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
        <div class="mt-6 mb-6 mx-auto lg:mx-96">
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
        <div class="mt-6 mb-4 lg:mx-96">
            <iframe class="embed-responsive-item" scrolling="no" frameborder="no" width="100%" height="350"
            src="https://w.soundcloud.com/player/?url={{$sectionField->soundcloudUrl}}&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>
        </div>
        @endif
        <!-- Twitch -->
        @if($item->section_name == 'Twitch' && $item->status == 1)
        <div class="mt-6 mb-4 mx-auto lg:mx-96">
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
        <div class="mt-6 mb-4 mx-auto lg:mx-96">
            <h1 class="font-bold text-3xl text-center" 
                style="color: {{$sectionField->titleColor}}">
                {{$sectionField->title}}
            </h1>
            <div class="mt-4 text-center font-semibold"
                style="color: {{$sectionField->titleColor}};">
                {!! $sectionField->description !!}
            </div>
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
        <div class="mt-6 mb-4 lg:mx-96">
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
        <div class="mt-6 mb-4 lg:mx-96">
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
            <div class="mt-4 text-center font-semibold"
                style="color: {{$sectionField->titleColor}};">
                {!! $sectionField->description !!}
            </div>
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
        <div class="mt-6 mb-4 lg:mx-96">
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
        <div class="mt-6 mb-4 lg:mx-96">
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
            <div class="mt-2 text-center font-semibold"
                style="color: {{$sectionField->titleColor}};">
                {!! $sectionField->description !!}
            </div>
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
        <div class="mt-6 mb-4 lg:mx-96">
            <h1 class="font-bold text-3xl text-center mt-6" 
                style="color: {{$sectionField->titleColor}}">
                {{$sectionField->title}}
            </h1>
            <div class="mt-2 text-center font-semibold"
                style="color: {{$sectionField->titleColor}};">
                {!! $sectionField->description !!}
            </div>
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
        <div class="mt-6 mb-4 lg:mx-96">
            <h1 class="font-bold text-3xl text-center mt-6" 
                style="color: {{$sectionField->titleColor}}">
                {{$sectionField->title}}
            </h1>
            <div class="mt-2 text-center font-semibold"
                style="color: {{$sectionField->textColor}};">
                {!! $sectionField->text !!}
            </div>
            <!-- Accordion -->
            @if($sectionField->qestion)
            <div style="background-color: {{$sectionField->qstnBgColor}}" class="mt-4">
                <div id="accordion-collapse" data-accordion="collapse">
                    <h2 id="accordion-collapse-heading-001">
                        <button type="button" 
                            class="flex items-center justify-between w-full 
                            p-5 font-medium text-left text-gray-500 border 
                            border-b-0 border-gray-200 rounded-t-xl focus:ring-4 
                            focus:ring-gray-200 dark:focus:ring-gray-800 
                            dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 
                            dark:hover:bg-gray-800" 
                            data-accordion-target="#accordion-collapse-body-001" 
                            aria-expanded="false" 
                            aria-controls="accordion-collapse-body-001"
                            style="color: {{$sectionField->qstnTextColor}}; background-color: {{$sectionField->qstnBgColor}}">
                            <span>{{$sectionField->qestion}}</span>
                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-001" class="hidden" aria-labelledby="accordion-collapse-heading-001">
                        <div class="p-5 font-normal border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <p class="text-gray-900 dark:text-gray-400">
                                {{$sectionField->answer}}
                            </p>
                        </div>
                    </div>
                    @foreach($sectionField->moreFaq as $i => $faq)
                    <h2 id="accordion-collapse-heading-{{$i}}">
                        <button type="button" 
                            class="flex items-center justify-between w-full 
                            p-5 font-medium text-left text-gray-500 border 
                            border-b-0 border-gray-200 focus:ring-4 
                            focus:ring-gray-200 dark:focus:ring-gray-800 
                            dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 
                            dark:hover:bg-gray-800" 
                            data-accordion-target="#accordion-collapse-body-{{$i}}" 
                            aria-expanded="false" 
                            aria-controls="accordion-collapse-body-{{$i}}"
                            style="color: {{$sectionField->qstnTextColor}}; background-color: {{$sectionField->qstnBgColor}}">
                            <span>{{$faq->question}}</span>
                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-{{$i}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$i}}">
                        <div class="p-5 font-normal border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <p class="text-gray-900 dark:text-gray-400">
                                {{$faq->answer}}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif
        <!-- Link -->
        @if($item->section_name == 'Link' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-96 link-section" 
            data-schedule="{{$sectionField->scheduleSwitch}}"
            data-schedule-start="{{$sectionField->scheduleStart}}"
            data-schedule-end="{{$sectionField->scheduleEnd}}">
            @if(isset($sectionField->destinationURL))
            <div class="flex justify-center">
                <a href="{{$sectionField->destinationURL}}"
                    target="_blank"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:outline-none focus:ring-0 focus:ring-blue-300 
                    font-medium rounded-full text-md px-5 py-2.5 
                    text-center mr-2 mb-2 dark:bg-blue-600 w-full
                    dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    style="color: {{$item->button_text_color}}; background-color: {{$item->button_bg_color}}">
                    <!-- fontawesome -->
                    @if(isset($sectionField->buttonIcon))
                    <i class="{{$sectionField->buttonIcon}}"></i>
                    @endif
                    {{$item->button_text}}
                </a>
            </div>
            @endif
        </div>
        @endif
        <!-- HtmlJsBlock -->
        @if($item->section_name == 'HtmlJsBlock' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-96">
            {!! $sectionField->codeBlock !!}
        </div>
        @endif
        <!-- Google Reviews -->
        @if($item->section_name == 'GoogleReview' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-96">
            <div class="google-reviews" 
            data-key="{{$sectionField->googleKey}}" 
            data-placeid="{{$sectionField->googlePlaceId}}"></div>
        </div>
        @endif
        <!-- Lead Gen -->
        @if($item->section_name == 'Lead Generation' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-96">
            <div class="flex justify-center mt-2">
                <button type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:outline-none focus:ring-0 focus:ring-blue-300 
                    font-medium rounded-full text-md px-5 py-2.5 
                    text-center mr-2 mb-2 dark:bg-blue-600 w-full
                    dark:hover:bg-blue-700 dark:focus:ring-blue-800 leadgen-modal"
                    data-modal-toggle="leadgen-modal"
                    data-section-id="{{$item->section_id}}"
                    data-show-phone="{{$sectionField->showPhone}}"
                    data-require-phone="{{$sectionField->requirePhone}}"
                    data-lead-text="{{$sectionField->text}}"
                    data-show-agreement="{{$sectionField->showAgreement}}"
                    data-agreement-text="{{$sectionField->agreementText}}"
                    data-agreement-url="{{$sectionField->agreementURL}}"
                    data-form-name="{{$sectionField->formName}}"
                    style="color: {{$item->button_text_color}};
                    background-color: {{$item->button_bg_color}}">
                    {{$item->button_text}}
                </button>
            </div>
        </div>
        @if($sectionField->customConvertCode)
            {!! $sectionField->customConvertCode !!}
        @endif
        @endif
        <!-- Mail Signup -->
        @if($item->section_name == 'Mail signup' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-96">
            <div class="flex justify-center mt-2">
                <button type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:outline-none focus:ring-0 focus:ring-blue-300 
                    font-medium rounded-full text-md px-5 py-2.5 
                    text-center mr-2 mb-2 dark:bg-blue-600 w-full
                    dark:hover:bg-blue-700 dark:focus:ring-blue-800 mailsignup-modal"
                    data-modal-toggle="mailsignup-modal"
                    data-section-id="{{$item->section_id}}"
                    data-show-agreement="{{$sectionField->showAgreement}}"
                    data-agreement-text="{{$sectionField->agreementText}}"
                    data-agreement-url="{{$sectionField->agreementURL}}"
                    data-form-name="{{$sectionField->name}}"
                    style="color: {{$item->button_text_color}};
                    background-color: {{$item->button_bg_color}}">
                    <i class="{{$sectionField->buttonIcon}}"></i>
                    {{$item->button_text}}
                </button>
            </div>
        </div>
        @endif
    @endforeach

    <!-- Socials -->
    <x-biolink-socials :socials="$jdecoded['socials']"/>

    <!-- Branding -->
    @if($jdecoded['branding']->display == 'yes' && isset($jdecoded['branding']->name))
    <div class="mt-10 text-center">
        <a href="{{$jdecoded['branding']->url}}" target="_blank" class="font-bold text-md">
            <span class="hover:underline">{{$jdecoded['branding']->name}}</span>
        </a>
    </div>
    @endif

    <!-- Modals -->
    <div id="leadgen-modal" tabindex="-1" aria-hidden="true" 
        class="fixed top-0 left-0 right-0 z-50 hidden w-full 
        p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" 
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent 
                    hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 
                    ml-auto inline-flex items-center dark:hover:bg-gray-800 
                    dark:hover:text-white" data-modal-toggle="leadgen-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white" id="leadgen-form-name"></h3>
                    <p class="mt-2 font-normal hidden" id="leadgen-text"></p>
                    <form class="space-y-6" action="" method="post">
                        <div class="p-4 mb-4 text-sm rounded-lg dark:bg-red-200 dark:text-red-800 hidden alert" 
                        role="alert"></div>
                        <div>
                            <input type="text" name="name" id="name" 
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 
                            dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" 
                            placeholder="E.g Bob Smith">
                        </div>
                        <div>
                            <input type="text" name="phone" id="phone" 
                            class="bg-gray-50 border border-gray-300 hidden
                            text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 
                            dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" 
                            placeholder="E.g +44 7867836733">
                        </div>
                        <div>
                            <input type="email" name="email" id="email" 
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 
                            dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" 
                            placeholder="email@domain.com" required>
                        </div>
                        <div id="agreement-section" class="hidden">
                            <div class="flex items-center mb-4">
                                <input id="agreement-checkbox" type="checkbox" 
                                class="w-4 h-4 text-blue-600 bg-gray-100 
                                rounded border-gray-300 focus:ring-blue-500 
                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="agreement-checkbox" 
                                    class="ml-2 text-sm font-normal 
                                    text-gray-900 dark:text-gray-300">
                                    <a href="" target="_blank" id="agreement-text-url" class="hover:underline"></a>
                                </label>
                            </div>
                        </div>
                        <button type="button" id="leadgen-submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 
                            focus:ring-4 focus:outline-none focus:ring-blue-300 
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                            dark:bg-blue-600 dark:hover:bg-blue-700 
                            dark:focus:ring-blue-800">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="mailsignup-modal" tabindex="-1" aria-hidden="true" 
        class="fixed top-0 left-0 right-0 z-50 hidden w-full 
        p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" 
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent 
                    hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 
                    ml-auto inline-flex items-center dark:hover:bg-gray-800 
                    dark:hover:text-white" data-modal-toggle="mailsignup-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white" id="mailsignup-form-name"></h3>
                    <form class="space-y-6">
                        <div class="p-4 mb-4 text-sm rounded-lg dark:bg-red-200 dark:text-red-800 hidden alert" 
                        role="alert"></div>
                        <div>
                            <input type="email" name="email" id="mail-email" 
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 
                            dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" 
                            placeholder="email@domain.com" required>
                        </div>
                        <div id="mail-agreement-section" class="hidden">
                            <div class="flex items-center mb-4">
                                <input id="mail-agreement-checkbox" type="checkbox" 
                                class="w-4 h-4 text-blue-600 bg-gray-100 
                                rounded border-gray-300 focus:ring-blue-500 
                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="mail-agreement-checkbox" 
                                    class="ml-2 text-sm font-normal 
                                    text-gray-900 dark:text-gray-300">
                                    <a href="" target="_blank" id="mail-agreement-text-url" class="hover:underline"></a>
                                </label>
                            </div>
                        </div>
                        <button type="button" id="mail-submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 
                            focus:ring-4 focus:outline-none focus:ring-blue-300 
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                            dark:bg-blue-600 dark:hover:bg-blue-700 
                            dark:focus:ring-blue-800">
                            Sign up
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Donation -->
    <div id="donation-modal" tabindex="-1" aria-hidden="true" 
        class="fixed top-0 left-0 right-0 z-50 hidden w-full 
        p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" 
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent 
                    hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 
                    ml-auto inline-flex items-center dark:hover:bg-gray-800 
                    dark:hover:text-white" data-modal-toggle="donation-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white" id="donation-form-name"></h3>
                    <!-- <form class="space-y-6"> -->
                        <!-- alert -->
                        <div class="p-4 mb-4 text-sm rounded-lg hidden alert" role="alert"></div>
                        <p id="donation-desc" class="text-sm"></p>
                        <div class="flex gap-2" id="regular-amount">
                            <select id="donation-times" 
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 
                            block p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500 max-w-sm">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="100">100</option>
                            </select>
                            <span class="font-semibold mt-2 px-2">x</span>
                            <span class="font-semibold mt-2">$5</span>
                            <span class="font-semibold mt-2 pl-2">=</span>
                            <span class="font-semibold mt-2 total-donation">$5</span>
                            <span id="to-custom-amount" class="font-semibold mt-2 pl-6 text-blue-400 cursor-pointer">
                                Custom amount?
                            </span>
                        </div>
                        <div class="flex gap-2" id="custom-amount" style="display:none">
                            <span class="font-semibold mt-2 px-2">$</span>
                            <input type="number" id="custom-amount-field" value="5"
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm rounded-lg 
                            focus:ring-blue-500 focus:border-blue-500 
                            block p-2 dark:bg-gray-700 mx-w-sm
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500">
                            <span id="to-regular-amount" class="font-semibold mt-2 pl-4 text-blue-400 cursor-pointer">
                                To regular amount?
                            </span>
                        </div>
                        <div class="mt-4">
                            <!-- Payment methods -->
                            <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-white">
                                Payment Method
                            </h3>
                            <div class="flex gap-3">
                                @if($proj['stripe'])
                                <div class="flex items-center pl-4 border w-full
                                    border-gray-200 rounded dark:border-gray-700">
                                    <input id="bordered-radio-1" type="radio" 
                                    value="card" name="payType" 
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 
                                    focus:ring-blue-500 dark:focus:ring-blue-600 
                                    dark:ring-offset-gray-800 focus:ring-2 payType
                                    dark:bg-gray-700 dark:border-gray-600"
                                    checked>
                                    <label for="bordered-radio-1" 
                                        class="w-full py-4 ml-2 text-sm font-medium 
                                        text-gray-900 dark:text-gray-300 flex gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                        </svg>
                                        <span class="mt-0.5 uppercase md:text-sm text-sm">Credit card</span>
                                    </label>
                                </div>
                                @endif
                                @if($proj['paypal'])
                                <div class="flex items-center pl-4 border w-full
                                border-gray-200 rounded dark:border-gray-700">
                                    <input id="bordered-radio-2" type="radio" 
                                    value="paypal" name="payType" 
                                    class="w-4 h-4 text-blue-600 bg-gray-100 
                                    border-gray-300 focus:ring-blue-500 payType
                                    dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="bordered-radio-2" 
                                        class="w-full py-4 ml-2 text-sm font-medium 
                                        text-gray-900 dark:text-gray-300 flex gap-2 uppercase">
                                        <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#00457C" class="w-4 h-4 mt-0.5">
                                            <title>PayPal</title>
                                            <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/>
                                        </svg>
                                        Paypal
                                    </label>
                                </div>
                                @endif
                            </div>
                            <!-- Creadit card details -->
                            @if($proj['stripe'])
                            <div class="mt-3" id="credit-card-slot">
                                <div class="flex rounded-md shadow-sm">
                                    <input type="text" name="card-number" id="card-number" 
                                    class="block w-full flex-1 rounded-none rounded-l-md 
                                    border-gray-300 focus:border-indigo-500 
                                    focus:ring-indigo-500 sm:text-sm" 
                                    placeholder="Card number">
                                    <span class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="md:flex gap-2 mt-3">
                                    <div class="flex input-group w-full">
                                        <select class="block w-full rounded-none rounded-l-md 
                                            border-gray-300 focus:border-indigo-500 
                                            focus:ring-indigo-500 sm:text-sm" name="month" id="card-month">
                                            <option value="">MM</option>
                                            @foreach(range(1, 12) as $month)
                                                <option value="{{$month}}">{{$month}}</option>
                                            @endforeach
                                        </select>
                                        <select class="block w-full rounded-none rounded-r-md 
                                            border-gray-300 focus:border-indigo-500 
                                            focus:ring-indigo-500 sm:text-sm" name="year" id="card-year">
                                            <option value="">YYYY</option>
                                            @foreach(range(date('Y'), date('Y') + 10) as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <input type="text" name="cvv-number" id="cvv-number" 
                                        class="block flex-1 rounded-md 
                                        border-gray-300 focus:border-indigo-500 
                                        focus:ring-indigo-500" 
                                        placeholder="CVV">
                                    </div>
                                </div>
                            </div> 
                            @endif
                            
                            <!-- Total donation -->
                            <div class="flex gap-2 text-lg mt-6">
                                <h2 class="font-bold ">Total: </h2>
                                <span class="total-donation font-bold">$5.00</span>
                                <input type="number" value="5.00" id="actual-total-donation" style="display:none">
                            </div>
                            <!-- paypal slot -->
                            <div class="mt-3" id="paypal-slot" style="display:none">
                                <form action="{{route('paypal-payment')}}" method="post">
                                    @csrf
                                    <input type="text" value="" name="linkId" id="linkId" style="display:none">
                                    <input type="text" value="" name="sectionId" id="sectionId" style="display:none">
                                    <input type="text" value="" name="description" id="description" style="display:none">
                                    <input type="text" value="paypal" name="type" style="display:none">
                                    <input type="text" value="{{$projectLinkId}}" name="projectlinkid" style="display:none">
                                    <input type="number" value="5.00" name="amount" id="paypal-total-donation" style="display:none">
                                    <button type="submit" id="donation-paypal-submit"
                                        class="w-full text-white bg-blue-700 hover:bg-blue-800 
                                        focus:ring-4 focus:outline-none focus:ring-blue-300 
                                        font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                                        dark:bg-blue-600 dark:hover:bg-blue-700 
                                        dark:focus:ring-blue-800">
                                        Donate
                                    </button>
                                </form>
                            </div>
                        </div>
                        <button type="button" id="donation-submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 
                            focus:ring-4 focus:outline-none focus:ring-blue-300 
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                            dark:bg-blue-600 dark:hover:bg-blue-700 
                            dark:focus:ring-blue-800 mt-3">
                            Donate
                            <span id="donation-loader" style="display:none">
                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 ml-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </button>
                    <!-- </form> -->
                    <div class="mt-6">
                        <h4 class="flex justify-center text-center text-green-400 font-bold text-sm uppercase">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2 mb-1">
                                <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                            </svg>
                            secure payment by stripe & paypal
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fan request -->
    <div id="fanrequest-modal" tabindex="-1" aria-hidden="true" 
        class="fixed top-0 left-0 right-0 z-50 hidden w-full 
        p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent 
                    hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 
                    ml-auto inline-flex items-center dark:hover:bg-gray-800 
                    dark:hover:text-white" data-modal-toggle="fanrequest-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white" id="fanrequest-form-name"></h3>
                    @if(!auth()->guard('subscriber')->check())
                    <form class="space-y-6" action="{{route('fan-request', $projectLinkId)}}" method="post">
                    @else
                    <form class="space-y-6" action="{{route('fan-request-auth', $projectLinkId)}}" method="post">
                    @endif
                    @csrf
                        <p id="request-desc" class="text-sm"></p>
                        <p class="text-gray-500 text-sm message-warn mt-2"></p>
                        <div class="p-4 mb-4 text-sm rounded-lg hidden alert" role="alert"></div>
                        <textarea id="fanrequest-message" rows="2" name="requestMessage"
                        class="block p-2.5 w-full text-sm text-gray-900 
                        rounded-lg border border-gray-300 mt-2
                        focus:ring-blue-500 focus:border-blue-500 
                        dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="" required></textarea>
                        @if(!auth()->guard('subscriber')->check())
                        <!-- Login/signup section -->
                        <div class="mt-4">
                            <div id="new-account-request">
                                <div class="flex justify-between">
                                    <h3 class="text-md font-medium text-gray-900 dark:text-white">
                                        Create A Login
                                    </h3>
                                    <!-- <span id="to-login-request" class="font-normal mt-0.5 text-blue-500 text-sm cursor-pointer">
                                        Already have an account? Login
                                    </span> -->
                                </div>
                                <div class="mt-2">
                                    <p class="text-gray-500 text-sm warn"></p>
                                    <input type="email" name="email" 
                                    id="email_signup_request" 
                                    class="block flex-1 rounded-md 
                                    border-gray-300 focus:border-indigo-500 
                                    focus:ring-indigo-500 w-full" 
                                    placeholder="name@company.com">
                                    <input type="password" name="password" 
                                    id="password_signup_request" 
                                    class="block flex-1 rounded-md mt-3
                                    border-gray-300 focus:border-indigo-500 
                                    focus:ring-indigo-500 w-full" 
                                    placeholder="**********">
                                </div>
                            </div>
                            <!-- <div id="login-request" style="display:none">
                                <div class="flex justify-between">
                                    <h3 class="text-md font-medium text-gray-900 dark:text-white">
                                        Login
                                    </h3>
                                    <span id="to-signup-request" class="font-normal mt-0.5 text-blue-500 text-sm cursor-pointer">
                                        Don't have an account? Signup
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <p class="text-gray-500 text-sm warn"></p>
                                    <input type="email" name="email_login_request" 
                                    id="email_login_request" 
                                    class="block flex-1 rounded-md 
                                    border-gray-300 focus:border-indigo-500 
                                    focus:ring-indigo-500 w-full" 
                                    placeholder="name@company.com">
                                    <input type="password" name="password_login_request" 
                                    id="password_login_request" 
                                    class="block flex-1 rounded-md mt-3
                                    border-gray-300 focus:border-indigo-500 
                                    focus:ring-indigo-500 w-full" 
                                    placeholder="**********">
                                </div>
                            </div> -->
                        </div>
                        @endif

                        <!-- data fields -->
                        <input type="text" name="linkId" value="{{$settings->link_id}}" style="display:none">
                        <input type="text" name="sectionId" value="" id="section-id-request" style="display:none">
                        <input type="number" name="amount" value="" id="actual-total-request" style="display:none">
                        <input type="text" name="description" value="" id="payment-description" style="display:none">
                        <input type="text" value="{{$projectLinkId}}" name="projectlinkid" style="display:none">
                        <!-- Payment method -->
                        <div class="mt-4">
                            <h3 class="mb-2 text-md font-medium text-gray-900 dark:text-white">
                                Payment Method
                            </h3>
                            @if(auth()->guard('subscriber')->check())
                            <p class="mt-1 mb-1 text-sm text-gray-500">
                                You can leave empty if you have added your card to your account.
                            </p>
                            @endif
                            <div class="flex gap-3">
                                @if($proj['stripe'])
                                <div class="flex items-center pl-4 border w-full
                                    border-gray-200 rounded dark:border-gray-700">
                                    <input id="request-bordered-radio-1" type="radio" 
                                    value="card" name="type" 
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 
                                    focus:ring-blue-500 dark:focus:ring-blue-600 
                                    dark:ring-offset-gray-800 focus:ring-0 request-payType
                                    dark:bg-gray-700 dark:border-gray-600"
                                    checked>
                                    <label for="request-bordered-radio-1" 
                                        class="w-full py-1 ml-2 text-sm font-medium 
                                        text-gray-900 dark:text-gray-300 flex gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                        </svg>
                                        <span class="mt-0.5 uppercase md:text-sm text-sm">Credit card</span>
                                    </label>
                                </div>
                                @endif
                                @if($proj['paypal'])
                                <div class="flex items-center pl-4 border w-full
                                    border-gray-200 rounded dark:border-gray-700">
                                    <input id="request-bordered-radio-2" type="radio" 
                                    value="paypal" name="type" 
                                    class="w-4 h-4 text-blue-600 bg-gray-100 
                                    border-gray-300 focus:ring-blue-500 request-payType
                                    dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="request-bordered-radio-2" 
                                        class="w-full py-1 ml-2 text-sm font-medium 
                                        text-gray-900 dark:text-gray-300 flex gap-2 uppercase">
                                        <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#00457C" class="w-4 h-4 mt-0.5">
                                            <title>PayPal</title>
                                            <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/>
                                        </svg>
                                        Paypal
                                    </label>
                                </div>
                                @endif
                            </div>
                            <!-- Creadit card details -->
                            @if($proj['stripe'])
                            <div class="mt-3" id="request-credit-card-slot">
                                <div class="flex rounded-md shadow-sm">
                                    <input type="text" name="cardNumber" id="request-card-number" 
                                    class="block w-full flex-1 rounded-none rounded-l-md 
                                    border-gray-300 focus:border-indigo-500 
                                    focus:ring-indigo-500 sm:text-sm" 
                                    placeholder="Card number">
                                    <span class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="md:flex gap-2 mt-3">
                                    <div class="flex input-group w-full">
                                        <select class="block w-full rounded-none rounded-l-md 
                                            border-gray-300 focus:border-indigo-500 
                                            focus:ring-indigo-500 sm:text-sm" name="month" id="request-card-month">
                                            <option value="">MM</option>
                                            @foreach(range(1, 12) as $month)
                                                <option value="{{$month}}">{{$month}}</option>
                                            @endforeach
                                        </select>
                                        <select class="block w-full rounded-none rounded-r-md 
                                            border-gray-300 focus:border-indigo-500 
                                            focus:ring-indigo-500 sm:text-sm" name="year" id="request-card-year">
                                            <option value="">YYYY</option>
                                            @foreach(range(date('Y'), date('Y') + 10) as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <input type="text" name="cvv" id="request-cvv-number" 
                                        class="block flex-1 rounded-md 
                                        border-gray-300 focus:border-indigo-500 
                                        focus:ring-indigo-500" 
                                        placeholder="CVV">
                                    </div>
                                </div>
                            </div> 
                            @endif
                            <!-- Total request -->
                            <div class="flex gap-2 text-md mt-6">
                                <h2 class="font-medium ">Total: </h2>
                                <span class="total-request font-medium"></span>
                            </div>
                            <!-- paypal slot -->
                            <div class="mt-3" id="request-paypal-slot" style="display:none">
                                <!-- <form action="{{route('paypal-payment')}}" method="post">
                                    @csrf
                                    <input type="text" value="" name="linkId" id="request-linkId" style="display:none">
                                    <input type="text" value="" name="sectionId" id="request-sectionId" style="display:none">
                                    <input type="text" value="" name="description" id="request-description" style="display:none">
                                    <input type="text" value="paypal" name="type" style="display:none">
                                    <input type="text" value="{{$projectLinkId}}" name="projectlinkid" style="display:none">
                                    <input type="number" value="" name="amount" id="paypal-total-request" style="display:none">
                                    <button type="submit" id="request-paypal-submit"
                                        class="w-full text-white bg-blue-700 hover:bg-blue-800 
                                        focus:ring-4 focus:outline-none focus:ring-blue-300 
                                        font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                                        dark:bg-blue-600 dark:hover:bg-blue-700 
                                        dark:focus:ring-blue-800">
                                        Continue
                                    </button>
                                </form> -->
                            </div>
                        </div>
                        
                        <button type="submit" id=""
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 
                            focus:ring-4 focus:outline-none focus:ring-blue-300 
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                            dark:bg-blue-600 dark:hover:bg-blue-700 
                            dark:focus:ring-blue-800 mt-3">
                            Continue
                            <span id="request-loader" style="display:none">
                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 ml-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </button>
                        <div class="mt-4">
                            <h4 class="flex justify-center text-center text-green-400 font-bold text-sm uppercase">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2 mb-1">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                                </svg>
                                secure payment by stripe & paypal
                            </h4>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Product/membership -->
    <div id="product-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full 
        p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent 
                    hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 
                    ml-auto inline-flex items-center dark:hover:bg-gray-800 
                    dark:hover:text-white" data-modal-toggle="product-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white" id="product-form-name"></h3>
                    @if(!auth()->guard('subscriber')->check())
                    <form class="space-y-6" action="{{route('product', $projectLinkId)}}" method="post">
                    @else
                    <form class="space-y-6" action="{{route('product-auth', $projectLinkId)}}" method="post">
                    @endif
                        @csrf
                        <p id="product-desc" class="text-sm"></p>

                        <!-- Login section -->
                        @if(!auth()->guard('subscriber')->check())
                        <!-- signup section -->
                        <div class="mt-4">
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
                        <!-- data fields -->
                        <input type="text" name="linkId" value="{{$settings->link_id}}" style="display:none">
                        <input type="text" name="sectionId" value="" id="section-id-product" style="display:none">
                        <input type="number" name="amount" value="" id="actual-total-product" style="display:none">
                        <input type="text" name="description" value="" id="payment-description-product" style="display:none">
                        <input type="text" name="projectlinkid" value="{{$projectLinkId}}" style="display:none">
                        <input type="text" name="product_id" value="" id="product-id" style="display:none">
                        <input type="text" name="product_source" value="" id="product-source" style="display:none">
                        <!-- Payment method -->
                        <div class="mt-4">
                            <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-white">
                                Payment Method
                            </h3>
                            @if(auth()->guard('subscriber')->check())
                            <p class="mt-1 mb-1 text-sm text-gray-500">
                                You can leave empty if you have added your card to your account.
                            </p>
                            @endif
                            <div class="flex gap-3">
                                <div class="flex items-center pl-4 border w-full
                                    border-gray-200 rounded dark:border-gray-700">
                                    <input id="product-bordered-radio-1" type="radio" 
                                    value="card" name="product_payType" 
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 
                                    focus:ring-blue-500 dark:focus:ring-blue-600 
                                    dark:ring-offset-gray-800 focus:ring-2 product-payType
                                    dark:bg-gray-700 dark:border-gray-600"
                                    checked>
                                    <label for="product-bordered-radio-1" 
                                        class="w-full py-4 ml-2 text-sm font-medium 
                                        text-gray-900 dark:text-gray-300 flex gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                        </svg>
                                        <span class="mt-0.5 uppercase md:text-sm text-sm">Credit card</span>
                                    </label>
                                </div>
                                <div class="flex items-center pl-4 border w-full
                                border-gray-200 rounded dark:border-gray-700">
                                    <input id="product-bordered-radio-2" type="radio" 
                                    value="paypal" name="product_payType" 
                                    class="w-4 h-4 text-blue-600 bg-gray-100 
                                    border-gray-300 focus:ring-blue-500 product-payType
                                    dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="product-bordered-radio-2" 
                                        class="w-full py-4 ml-2 text-sm font-medium 
                                        text-gray-900 dark:text-gray-300 flex gap-2 uppercase">
                                        <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#00457C" class="w-4 h-4 mt-0.5">
                                            <title>PayPal</title>
                                            <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106zm14.146-14.42a3.35 3.35 0 0 0-.607-.541c-.013.076-.026.175-.041.254-.93 4.778-4.005 7.201-9.138 7.201h-2.19a.563.563 0 0 0-.556.479l-1.187 7.527h-.506l-.24 1.516a.56.56 0 0 0 .554.647h3.882c.46 0 .85-.334.922-.788.06-.26.76-4.852.816-5.09a.932.932 0 0 1 .923-.788h.58c3.76 0 6.705-1.528 7.565-5.946.36-1.847.174-3.388-.777-4.471z"/>
                                        </svg>
                                        Paypal
                                    </label>
                                </div>
                            </div>
                            <!-- Credit card details -->
                            <div class="mt-3" id="product-credit-card-slot">
                                <div class="flex rounded-md shadow-sm">
                                    <input type="text" name="cardNumber" id="product-card-number" 
                                    class="block w-full flex-1 rounded-none rounded-l-md 
                                    border-gray-300 focus:border-indigo-500 
                                    focus:ring-indigo-500 sm:text-sm" 
                                    placeholder="Card number">
                                    <span class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="md:flex gap-2 mt-3">
                                    <div class="flex input-group w-full">
                                        <select class="block w-full rounded-none rounded-l-md 
                                            border-gray-300 focus:border-indigo-500 
                                            focus:ring-indigo-500 sm:text-sm" name="month" id="product-card-month">
                                            <option value="">MM</option>
                                            @foreach(range(1, 12) as $month)
                                                <option value="{{$month}}">{{$month}}</option>
                                            @endforeach
                                        </select>
                                        <select class="block w-full rounded-none rounded-r-md 
                                            border-gray-300 focus:border-indigo-500 
                                            focus:ring-indigo-500 sm:text-sm" name="year" id="product-card-year">
                                            <option value="">YYYY</option>
                                            @foreach(range(date('Y'), date('Y') + 10) as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <input type="text" name="cvv" id="product-cvv-number" 
                                        class="block flex-1 rounded-md 
                                        border-gray-300 focus:border-indigo-500 
                                        focus:ring-indigo-500" 
                                        placeholder="CVV">
                                    </div>
                                </div>
                            </div> 
                            <!-- Total amount -->
                            <div class="flex gap-2 text-lg mt-6">
                                <h2 class="font-bold ">Total: </h2>
                                <span class="total-product font-bold"></span>
                            </div>
                            <!-- paypal slot -->
                            <div class="mt-3" id="product-paypal-slot" style="display:none">
                            </div>
                        </div>

                        <button type="submit" id=""
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 
                            focus:ring-4 focus:outline-none focus:ring-blue-300 
                            font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                            dark:bg-blue-600 dark:hover:bg-blue-700 
                            dark:focus:ring-blue-800 mt-3">
                            Continue
                            <span id="product-loader" style="display:none">
                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 ml-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                            </span>
                        </button>
                        <div class="mt-6">
                            <h4 class="flex justify-center text-center text-green-400 font-bold text-sm uppercase">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2 mb-1">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                                </svg>
                                secure payment by stripe & paypal
                            </h4>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    let greviews = $('.google-reviews');
    
    for(let rev of greviews) {
        if(rev.dataset.key && rev.dataset.placeid) {
            $.ajax({
                url: `https://cors-anywhere.herokuapp.com/https://maps.googleapis.com/maps/api/place/details/json?placeid=${rev.dataset.placeid}&key=${rev.dataset.key}`,
                dataType: "json",
                type: "GET", 
            
                success: function(json) {
                    $.each(json.result.reviews, function(i,v) {
                        if (i == 4) {
                            return false;
                        }
                        var rating = v.rating;
                    
                        rev.prepend("<div class='review-wrap'>"
                        +"<div class='review'>"+v.text+"</div>"
                        +"<div class='author'>"
                        +"<div class='author-name'>"+v.author_name+"</div>"
                        +"</div>"                            
                        +"</div>");
                    });
                },
                error: function(xhr, status, errorThrown) {
                    //do something if there was an error. Right now it will just show the default values in the html
                }
            });
        }
    }

    let model = {
        name: '',
        phone: '',
        email: '',
        mailEmail: '',
        sectionId: null,
        showPhone: '',
        requirePhone: '',
        leadText: '',
        showAgreement: '',
        agreementText: '',
        agreementUrl: '',
        isAgreementChecked: false,
        formName: '',
        fanrequestMessage: '',
        authType: ''
    };

    let payment = {
        type: '',
        cardNumber: '',
        cvv: '',
        expiryMonth: '',
        expiryYear: '',
        amount: 0,
        description: ''
    }

    // donation modal
    $('.donation-modal').click(function() {
        model.sectionId = $(this).data('section-id');
        $('#donation-form-name').text($(this).data('form-name'));
        $('#donation-desc').html($(this).data('description'));
        payment.description = $(this).data('title')

        $('#linkId').val($(this).data('link-id'));
        $('#sectionId').val($(this).data('section-id'));
        $('#description').val($(this).data('title'));
        // $('input[name=payType]:checked').val('card')
    });
    $('#donation-times').change(function() {
        let total = parseFloat($(this).val()) * 5;
        $('.total-donation').text('$'+ total.toFixed(2));
        $('#custom-amount-field').val(total);
        $('#actual-total-donation').val(total.toFixed(2));
        $('#paypal-total-donation').val(total.toFixed(2));
    });
    $('#custom-amount-field').change(function() {
        let total = parseFloat($(this).val());
        $('.total-donation').text('$'+ total.toFixed(2));
        $('#actual-total-donation').val(total.toFixed(2));
        $('#paypal-total-donation').val(total.toFixed(2));
    });
    $('#to-custom-amount').click(function() {
        $('#custom-amount').show();
        $('#regular-amount').hide();
    });
    $('#to-regular-amount').click(function() {
        $('#custom-amount').hide();
        $('#regular-amount').show();
    });
    // donation submit
    $('#donation-submit').click(function() {
        payment.type = $('input[name=payType]:checked').val();
        payment.cardNumber = $('#card-number').val();
        payment.cvv = $('#cvv-number').val();
        payment.expiryMonth = $('#card-month').val();
        payment.expiryYear = $('#card-year').val();
        payment.amount = $('#actual-total-donation').val();

        $('#donation-loader').show();
        $(this).attr('disabled', true);

        // send to backend
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/api/donation',
            method: 'post',
            data: { 
                linkId: {!! $settings->link_id !!},
                sectionId: model.sectionId,
                type: payment.type, 
                amount: payment.amount,
                cardNumber: payment.cardNumber,
                cvv: payment.cvv,
                month: payment.expiryMonth,
                year: payment.expiryYear,
                description: payment.description
            },
            success: function(res) {
                $('#donation-loader').hide();
                $('#donation-submit').attr('disabled', false)
                $('#card-number').val('')
                $('#cvv-number').val('')
                $('#card-month').val('')
                $('#card-year').val('')

                setSuccessAlert(res.message)
            },
            error: function(err) {
                $('#donation-loader').hide();
                $('#donation-submit').attr('disabled', false)
                
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

    // switch payment method
    $('.payType').change(function() {
        if($('input[name=payType]:checked').val()=='card') {
            $('#credit-card-slot').show();
            $('#paypal-slot').hide();
            $('#donation-submit').show();
        }else if($('input[name=payType]:checked').val()=='paypal') {
            $('#credit-card-slot').hide();
            $('#paypal-slot').show();
            $('#donation-submit').hide();
        }
    })
    $('.request-payType').change(function() {
        if($('input[name=type]:checked').val()=='card') {
            $('#request-credit-card-slot').show();
            $('#request-paypal-slot').hide();
            $('#request-submit').show();
        }else if($('input[name=type]:checked').val()=='paypal') {
            $('#request-credit-card-slot').hide();
            $('#request-paypal-slot').show();
            $('#request-submit').hide();
        }
    });
    $('.product-payType').change(function() {
        if($('input[name=product_payType]:checked').val()=='card') {
            $('#product-credit-card-slot').show();
            $('#product-paypal-slot').hide();
            $('#product-submit').show();
        }else if($('input[name=product_payType]:checked').val()=='paypal') {
            $('#product-credit-card-slot').hide();
            $('#product-paypal-slot').show();
            $('#product-submit').hide();
        }
    });

    // fanrequest modal
    $('.fanrequest-modal').click(function() {
        model.sectionId = $(this).data('section-id');
        $('#section-id-request').val($(this).data('section-id'));
        $('#fanrequest-form-name').text($(this).data('form-name'));
        $('#request-desc').html($(this).data('description'));
        $('.total-request').text('$'+$(this).data('amount').toFixed(2))
        $('#actual-total-request').val($(this).data('amount').toFixed(2))
        $('#paypal-total-request').val($(this).data('amount').toFixed(2));
        payment.description = $(this).data('title');
        $('#payment-description').val($(this).data('title'));
    });
    $('#to-login-request').click(function() {
        $('#new-account-request').hide();
        $('#login-request').show();
    });
    $('#to-signup-request').click(function() {
        $('#new-account-request').show();
        $('#login-request').hide();
    });
    // fanrequest submit
    $('#request-submit').click(function() {
        model.fanrequestMessage = $('#fanrequest-message').val();

        // validate forms
        if($('#new-account-request').css('display') == 'none') {
            model.authType = 'login';
            if(!$('#email_login_request').val() || !$('#password_login_request').val()) {
                $('.warn').text('Please enter login details.');
                setTimeout(() => {
                    $('.warn').text('');
                }, 2000);
                return false;
            }
        }else if($('#login-request').css('display') == 'none') {
            model.authType = 'signup';
            if(!$('#email_signup_request').val() || !$('#password_signup_request').val()) {
                $('.warn').text('Please signup to continue.');
                setTimeout(() => {
                    $('.warn').text('');
                }, 2000);
                return false;
            }
        }else if(!$('#fanrequest-message').val()) {
            $('.message-warn').text('Please describe your request.');
            return false;
        }

        // send fan request
        $('#request-loader').show();
        $(this).attr('disabled', true);

        if(model.authType == 'signup') {
            $.ajax({
                url: '/api/fanrequest',
                method: 'post',
                data: { 
                    linkId: {!! $settings->link_id !!},
                    sectionId: model.sectionId,
                    type: $('input[name=request_payType]:checked').val(), 
                    amount: $('#actual-total-request').val(),
                    cardNumber: $('#request-card-number').val(),
                    cvv: $('#request-cvv-number').val(),
                    month: $('#request-card-month').val(),
                    year: $('#request-card-year').val(),
                    description: payment.description,
                    requestMessage: $('#fanrequest-message').val(),
                    authType: model.authType,
                    email: $('#email_signup_request').val(),
                    password: $('#password_signup_request').val()
                },
                success: function(res) {
                    $('#request-loader').hide();
                    $('#request-submit').attr('disabled', false)
                    $('#request-card-number').val('')
                    $('#request-cvv-number').val('')
                    $('#request-card-month').val('')
                    $('#request-card-year').val('')
                    $('#fanrequest-message').val('')

                    if($('#new-account-request').css('display') == 'none') {
                        $('#email_login_request').val('')
                        $('#password_login_request').val('')
                    }else{
                        $('#email_signup_request').val('') 
                        $('#password_signup_request').val('')
                    }

                    setSuccessAlert(res.message);
                },
                error: function(err) {
                    $('#request-loader').hide();
                    $('#request-submit').attr('disabled', false)
                    
                    if(err.hasOwnProperty('responseJSON')) {
                        $('.message-warn').text(err.responseJSON.message);
                        setErrorAlert(err.responseJSON.message);
                    }else if(err.hasOwnProperty('statusText')) {
                        setErrorAlert(err.statusText);
                        $('.message-warn').text(err.statusText);
                    }else {
                        console.log(err)
                    }
                    setTimeout(() => {
                        $('.message-warn').text('');
                    }, 2000);
                }
            });
        }else {
            $.ajax({
                url: '/api/fanrequest-auth',
                method: 'post',
                data: { 
                    linkId: {!! $settings->link_id !!},
                    sectionId: model.sectionId,
                    type: $('input[name=request_payType]:checked').val(), 
                    amount: $('#actual-total-request').val(),
                    cardNumber: $('#request-card-number').val(),
                    cvv: $('#request-cvv-number').val(),
                    month: $('#request-card-month').val(),
                    year: $('#request-card-year').val(),
                    description: payment.description,
                    requestMessage: $('#fanrequest-message').val(),
                    authType: model.authType,
                    email: $('#email_login_request').val(),
                    password: $('#password_login_request').val()
                },
                success: function(res) {
                    $('#request-loader').hide();
                    $('#request-submit').attr('disabled', false)
                    $('#request-card-number').val('')
                    $('#request-cvv-number').val('')
                    $('#request-card-month').val('')
                    $('#request-card-year').val('')
                    $('#fanrequest-message').val('')

                    if($('#new-account-request').css('display') == 'none') {
                        $('#email_login_request').val('')
                        $('#password_login_request').val('')
                    }else{
                        $('#email_signup_request').val('') 
                        $('#password_signup_request').val('')
                    }

                    setSuccessAlert(res.message)
                },
                error: function(err) {
                    $('#request-loader').hide();
                    $('#request-submit').attr('disabled', false)
                    
                    if(err.hasOwnProperty('responseJSON')) {
                        $('.message-warn').text(err.responseJSON.message);
                        setErrorAlert(err.responseJSON.message);
                    }else if(err.hasOwnProperty('statusText')) {
                        setErrorAlert(err.statusText);
                        $('.message-warn').text(err.statusText);
                    }else if(err.response) {
                        if (err.response.data) {
                            if (err.response.data.hasOwnProperty("message"))
                                setErrorAlert(err.response.data.message);
                            else
                                setErrorAlert(err.response.data.error);
                        }
                    }else {
                        console.log(err)
                    }
                    console.log(err)
                    setTimeout(() => {
                        $('.message-warn').text('');
                    }, 2000);
                    
                }
            });
        }
    });

    // product/membership modal
    $('.product-modal').click(function() {
        model.sectionId = $(this).data('section-id');
        $('#section-id-product').val($(this).data('section-id'));
        $('#product-form-name').text($(this).data('form-name'));
        $('#product-desc').html($(this).data('description'));
        $('.total-product').text('$'+$(this).data('amount').toFixed(2))
        $('#actual-total-product').val($(this).data('amount').toFixed(2))
        $('#payment-description-product').val($(this).data('title'));
        $('#product-id').val($(this).data('product-id'));
        $('#product-source').val($(this).data('product-type')); 
    });

    // toogle leads gen modal
    $('.leadgen-modal').click(function() {
        model.sectionId = $(this).data('section-id');
        model.showPhone = $(this).data('show-phone');
        model.requirePhone = $(this).data('require-phone');
        model.leadText = $(this).data('lead-text');
        model.showAgreement = $(this).data('show-agreement');
        model.agreementText = $(this).data('agreement-text');
        model.agreementUrl = $(this).data('agreement-url');
        $('#leadgen-form-name').text($(this).data('form-name'));

        if(model.showPhone == 'yes') {
            $('#phone')
                .removeClass('hidden')
                .addClass('block')
        }
        if(model.leadText) {
            $('#leadgen-text')
                .text(model.leadText)
                .removeClass('hidden')
                .addClass('block')
        }
        if(model.showAgreement == 'yes') {
            $('#agreement-section')
                .removeClass('hidden')
                .addClass('block')
            $('#agreement-text-url')
                .attr('href', model.agreementUrl)
                .text(model.agreementText)
        }else {
            $('#agreement-section')
                .removeClass('block')
                .addClass('hidden')
        }
    });

    $('#agreement-checkbox').change(function(ev) {
        model.isAgreementChecked = ev.target.checked;
    })

    // submit leads gen form
    $('#leadgen-submit').click(function() {
        model.name = $('#name').val()
        model.phone = $('#phone').val()
        model.email = $('#email').val()
        $(this).attr('disabled', true)

        if(!model.name) {
            setErrorAlert('Name is required!');
            $(this).attr('disabled', false)
        }else if(!model.email) {
            setErrorAlert('Invalid Email!');
            $(this).attr('disabled', false)
        }else if(!isEmailValid(model.email)) {
            setErrorAlert('Invalid Email!');
            $(this).attr('disabled', false)
        }else if(model.showPhone == 'yes' && model.requirePhone == 'yes' && !model.phone) {
            setErrorAlert('Phone is required!');
            $(this).attr('disabled', false)
        }else if(model.showAgreement == 'yes' && !model.isAgreementChecked) {
            setErrorAlert('Agreement is required!');
            $(this).attr('disabled', false)
        }else {
            $.ajax({
                url: '/api/leadgen',
                method: 'post',
                data: { 
                    name: model.name,
                    phone: model.phone,
                    email: model.email, 
                    sectionId: model.sectionId,
                    projectId: {!! $projectId !!} 
                },
                success: function(res) {
                    $('#name').val('')
                    $('#phone').val('')
                    $('#email').val('')
                    setSuccessAlert(res.message)
                    $('#leadgen-submit').attr('disabled', false)
                },
                error: function(err) {
                    $('#leadgen-submit').attr('disabled', false)
                    if(err.response){
                        if (err.response.data.hasOwnProperty('message')) {
                            setErrorAlert(err.response.data.message)
                        }else {
                            setErrorAlert(err.response.data.error)
                        }
                    } 
                }
            });
        }
    })

    // toogle mail signup modal
    $('.mailsignup-modal').click(function() {
        model.sectionId = $(this).data('section-id');
        model.showAgreement = $(this).data('show-agreement');
        model.agreementText = $(this).data('agreement-text');
        model.agreementUrl = $(this).data('agreement-url');
        $('#mailsignup-form-name').text($(this).data('form-name'))

        if(model.showAgreement == 'yes') {
            $('#mail-agreement-section')
                .removeClass('hidden')
                .addClass('block')
            $('#mail-agreement-text-url')
                .attr('href', model.agreementUrl)
                .text(model.agreementText)
        }else {
            $('#mail-agreement-section')
                .removeClass('block')
                .addClass('hidden')
        }
    });

    $('#mail-agreement-checkbox').change(function(ev) {
        model.isAgreementChecked = ev.target.checked;
    })

    // submit mail signup form
    $('#mail-submit').click(function() {
        model.mailEmail = $('#mail-email').val()
        $(this).attr('disabled', true)
        
        if(!model.mailEmail) {
            setErrorAlert('Invalid Email!');
            $(this).attr('disabled', false)
        }else if(!isEmailValid(model.mailEmail)) {
            setErrorAlert('Invalid Email!');
            $(this).attr('disabled', false)
        }else if(model.showAgreement == 'yes' && !model.isAgreementChecked) {
            setErrorAlert('Agreement is required!');
            $(this).attr('disabled', false)
        }else {
            $.ajax({
                url: '/api/mail-signup',
                method: 'post',
                data: { email: model.mailEmail, sectionId: model.sectionId, projectId: {!! $projectId !!} },
                success: function(res) {
                    $('#mail-email').val('')
                    setSuccessAlert(res.message)
                    $('#mail-submit').attr('disabled', false)
                },
                error: function(err) {
                    $('#mail-submit').attr('disabled', false)
                    if(err.response){
                        if (err.response.data.hasOwnProperty('message')) {
                            setErrorAlert(err.response.data.message)
                        }else {
                            setErrorAlert(err.response.data.error)
                        }
                    } 
                }
            });
        }
    })

    function getClientInfo() {
        $.ajax({
            url: 'https://api.ipgeolocation.io/ipgeo?apiKey=71ec1774e54b4b0f979cefe8d8f0e4bb',
            method: 'get',
            success: function(res) {
                getOS(res)
            },
            error: function(err) {
                if(err.response){
                    if (err.response.data.hasOwnProperty('message')) {
                        console.log('ipgeo: ' + err.response.data.message)
                    }else {
                        console.log('ipgeo: ' + err.response.data.error)
                    }
                } 
            }
        });
    }

    function getOS(ipInfo) {
        let userAgent = window.navigator.userAgent,
        platform = window.navigator.platform,
        macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
        windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
        iosPlatforms = ['iPhone', 'iPad', 'iPod'],
        os = 'Unknown OS';

        if (macosPlatforms.indexOf(platform) !== -1) {
            os = 'Mac OS';
        } else if (iosPlatforms.indexOf(platform) !== -1) {
            os = 'iOS';
        } else if (windowsPlatforms.indexOf(platform) !== -1) {
            os = 'Windows';
        } else if (/Android/.test(userAgent)) {
            os = 'Android';
        } else if (!os && /Linux/.test(platform)) {
            os = 'Linux';
        }
        postVisitorInfo(ipInfo, os)
    }

    function postVisitorInfo(ipInfo, os) {
        $.ajax({
            url: '/api/visits',
            method: 'post',
            data: {
                linkId: {!! $settings->link_id !!},
                ip: ipInfo.ip,
                country: ipInfo.country_name,
                countryFlag: ipInfo.country_flag,
                city: ipInfo.city,
                os: os
            },
            success: (res) => {},
            error: (err) => {
                if(err.response){
                    if (err.response.data.hasOwnProperty('message')) {
                        console.log('postVisitorInfo: ' + err.response.data.message)
                    }else {
                        console.log('postVisitorInfo: ' + err.response.data.error)
                    }
                } 
            }
        });
    }

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

    function isEmailValid(email) {
        let validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (email.match(validRegex)) {
            return true;
        }else{
            return false;
        }
    }

    // getClientInfo();
});
</script>
<script>
let videoIframe = document.querySelectorAll(".video-iframe");
let linkSection = document.querySelectorAll(".link-section");
const currentDate = new Date().getTime();

for(let i of videoIframe) {
    i.src = extractVideoId(i.dataset.url)
}

for(let i of linkSection) {
    if(i.dataset.schedule == 'yes') {
        let startDate = new Date(i.dataset.scheduleStart).getTime();
        let endDate = new Date(i.dataset.scheduleEnd).getTime();

        if(currentDate < startDate) {
            i.classList.add("hidden");
        }else if(currentDate > endDate) {
            i.classList.add("hidden");
        }
    }
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