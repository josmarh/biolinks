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
    <div class="mt-4 text-center font-semibold"
    style="color: {{$settings->text_color}}; 'font-family': {{$settings->font}}">
        {!! $settings->description !!}
    </div>
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
        <div class="mt-6 mb-4 lg:mx-72">
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
        <div class="mt-6 mb-4 lg:mx-72">
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
        <div class="mt-6 mb-4 lg:mx-72 link-section" 
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
        <div class="mt-6 mb-4 lg:mx-72">
            {!! $sectionField->codeBlock !!}
        </div>
        @endif
        <!-- Google Reviews -->
        @if($item->section_name == 'GoogleReview' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-72">
            <div class="google-reviews" 
            data-key="{{$sectionField->googleKey}}" 
            data-placeid="{{$sectionField->googlePlaceId}}"></div>
        </div>
        @endif
        <!-- Lead Gen -->
        @if($item->section_name == 'Lead Generation' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-72">
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
        @endif
        <!-- Mail Signup -->
        @if($item->section_name == 'Mail signup' && $item->status == 1)
        <div class="mt-6 mb-4 lg:mx-72">
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

    <!-- Main Modal -->
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
        formName: ''
    };

    // Submit leads
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
                    sectionId: model.sectionId 
                },
                success: function(res) {
                    $('#name').val('')
                    $('#phone').val('')
                    $('#email').val('')
                    setSuccessAlert(res.message)
                    $('#leadgen-submit').attr('disabled', false)
                },
                error: function(err) {
                    setErrorAlert(err.error)
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

    // Submit mail
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
                data: { email: model.mailEmail, sectionId: model.sectionId },
                success: function(res) {
                    $('#mail-email').val('')
                    setSuccessAlert(res.message)
                    $('#mail-submit').attr('disabled', false)
                },
                error: function(err) {
                    setErrorAlert(err.error)
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

    function setErrorAlert(message) {
        $('.alert').removeClass('hidden')
            .addClass('text-red-700 bg-red-100 block')
            .text(message)

        setTimeout(() => {
            $('.alert').removeClass('text-red-700 bg-red-100 block')
                .addClass('hidden')
                .text('')
        }, 1600)
    }

    function setSuccessAlert(message) {
        $('.alert').removeClass('hidden')
            .addClass('text-green-700 bg-green-100 block')
            .text(message)
        setTimeout(() => {
            $('.alert').removeClass('text-green-700 bg-green-100 block')
                .addClass('hidden')
                .text('')
        }, 1600)
    }

    function isEmailValid(email) {
        let validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (email.match(validRegex)) {
            return true;
        }else{
            return false;
        }
    }

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