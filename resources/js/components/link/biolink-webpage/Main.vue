<template>
    <div class="mt-8">
        <!-- Top Logo -->
        <div v-if="setting.topLogo">
            <img :src="setting.topLogo.includes('biolink') 
                ? helper.applink + setting.topLogo 
                : setting.topLogo"
                class="w-32 h-32 mx-auto rounded-full"/>
        </div>

        <!-- Title -->
        <h5 v-if="settings.title"
            class="mb-0 text-4xl font-bold tracking-tight 
            text-gray-900 dark:text-white text-center mt-4"
            :style="{'color': setting.textColor, 'font-family': setting.fonts}">
            {{setting.title}}
        </h5>

        <!-- Description -->
        <p v-if="settings.description"
            class="text-lg font-normal text-center mt-4 tracking-tight"
            :style="{'color': setting.textColor, 'font-family': setting.fonts}" 
            v-html="settings.description"></p>

        <!-- Video Display -->
        <div v-if="setting.video.type == 'youtube' && setting.video.link" class="mt-6 mx-auto">
            <!-- <iframe :src="extractVideoId(setting.video.link)" frameborder="0" 
            width="340" height="300" id="video-display"></iframe> -->
            <video-display :url="setting.video.link" fheight="232"/>
        </div>
        <div v-if="setting.video.type == 'vimeo' && setting.video.link" class="mt-0 mx-auto">
            <!-- <iframe title="vimeo-player" :src="extractVideoId(setting.video.link)" 
                width="340" height="300" frameborder="0" id="video-display2" allowfullscreen></iframe> -->
            <video-display :url="setting.video.link" fheight="232"/>
        </div>

        <!-- Section views -->
        <div v-if="section.length">
            <div v-for="item in section" :key="item.id">
                <!-- Vimeo -->
                <div v-if="item.section.name=='Vimeo'" class="mt-2 mb-4">
                    <!-- <iframe title="vimeo-player" :src="extractVideoId(item.sectionFields.vimeoUrl)" 
                        width="100%" height="200" frameborder="0" allowfullscreen></iframe> -->
                    <video-display :url="item.sectionFields.vimeoUrl" fheight="232"/>
                </div>
                <!-- Youtube -->
                <div v-if="item.section.name=='Youtube'" class="mt-2 mb-4">
                    <!-- <iframe :src="extractVideoId(item.sectionFields.youtubeUrl)" 
                        frameborder="0" width="100%" height="230"></iframe> -->
                    <video-display :url="item.sectionFields.youtubeUrl" fheight="232"/>
                </div>
                <!-- Spotify -->
                <div v-if="item.section.name=='Spotify'" class="mt-2 mb-4">
                    <div v-if="item.sectionFields.spotifyUrl.includes('show') || item.sectionFields.spotifyUrl.includes('episode')">
                        <!-- <iframe :src="extractVideoId(item.sectionFields.spotifyUrl)" 
                            width="100%" height="232" frameborder="0" 
                            allowtransparency="true" allow="encrypted-media"></iframe> -->
                        <video-display :url="item.sectionFields.spotifyUrl" fheight="232"/>
                    </div>
                    <div v-if="item.sectionFields.spotifyUrl.includes('track') || item.sectionFields.spotifyUrl.includes('album')">
                        <!-- <iframe scrolling="no" frameborder="no" v-if="item.sectionFields.spotifyUrl.includes('track')"
                            :src="extractVideoId(item.sectionFields.spotifyUrl)" 
                            width="100%" style="height: 80px;"></iframe> -->
                         <video-display :url="item.sectionFields.spotifyUrl" fheight="232" v-if="item.sectionFields.spotifyUrl.includes('track')"/>
                        <!-- <iframe scrolling="no" frameborder="no" v-if="item.sectionFields.spotifyUrl.includes('album')"
                            :src="extractVideoId(item.sectionFields.spotifyUrl)" 
                            width="100%" style="height: 380px;"></iframe> -->
                        <video-display :url="item.sectionFields.spotifyUrl" fheight="380" v-if="item.sectionFields.spotifyUrl.includes('album')"/>
                    </div>
                </div>
                <!-- Soundcloud -->
                <div v-if="item.section.name=='Soundcloud'" class="mt-2 mb-4">
                    <iframe class="embed-responsive-item" scrolling="no" frameborder="no" width="100%"
                    :src="`https://w.soundcloud.com/player/?url=${item.sectionFields.soundcloudUrl}&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true`"></iframe>
                </div>
                <!-- Twitch -->
                <div v-if="item.section.name=='Twitch'" class="mt-2 mb-4">
                    <!-- <iframe
                        class="embed-responsive-item"
                        scrolling="no"
                        frameborder="no"
                        width="100%"
                        :src="extractVideoId(item.sectionFields.twitchUrl)"
                    ></iframe> -->
                    <video-display :url="item.sectionFields.twitchUrl" fheight=""/>
                </div>
                <!-- Clubhouse -->
                <div v-if="item.section.name=='Clubhouse'" class="mt-2 mb-4">
                    <h1 class="font-bold text-3xl text-center" 
                        :style="{color: item.sectionFields.titleColor}">
                        {{item.sectionFields.title}}
                    </h1>
                    <p class="mt-2 text-center font-semibold" 
                        :style="{color: item.sectionFields.titleColor}"
                        v-html="item.sectionFields.description"></p>
                    <div class="flex justify-center mt-2">
                        <button type="button" 
                            @click="openExternalLink(item.sectionFields.clubhouseLink)"
                            class="text-white bg-blue-700 hover:bg-blue-800 
                            focus:outline-none focus:ring-0 focus:ring-blue-300 
                            font-medium rounded-full text-md px-5 py-2.5 
                            text-center mr-2 mb-2 dark:bg-blue-600 w-full
                            dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :style="{color: item.buttonTextColor,
                                'background-color': item.buttonBgColor
                            }">
                            {{item.buttonText}}
                        </button>
                    </div>
                </div>
                <!-- Text Block -->
                <div v-if="item.section.name=='Text Block'" class="mt-2 mb-4">
                    <img v-if="item.sectionFields.type=='image'" 
                        :src="item.sectionFields.typeContentImage.includes('biolink') 
                        ? helper.applink + item.sectionFields.typeContentImage 
                        : item.sectionFields.typeContentImage"
                        class="w-32 h-32 mx-auto rounded-full"/>
                    <div v-if="item.sectionFields.type=='video'">
                        <div v-if="item.sectionFields.typeContentVideo == 'youtube' && item.sectionFields.typeContentVideoUrl" class="mt-6 mx-auto">
                            <!-- <iframe :src="extractVideoId(item.sectionFields.typeContentVideoUrl)" frameborder="0" width="100%" height="232"></iframe> -->
                            <video-display :url="item.sectionFields.typeContentVideoUrl" fheight="232"/>
                        </div>
                        <div v-if="item.sectionFields.typeContentVideo == 'vimeo' && item.sectionFields.typeContentVideoUrl" class="mt-0 mx-auto">
                            <!-- <iframe title="vimeo-player" :src="extractVideoId(item.sectionFields.typeContentVideoUrl)" 
                                width="100%" height="232" frameborder="0" allowfullscreen></iframe> -->
                            <video-display :url="item.sectionFields.typeContentVideoUrl" fheight="232"/>
                        </div>
                    </div>
                    <h1 class="font-bold text-3xl text-center" 
                        :style="{color: item.sectionFields.titleColor}">
                        {{item.sectionFields.title}}
                    </h1>
                    <div v-if="item.sectionFields.link" class="flex justify-center mt-2">
                        <button type="button" 
                            @click="openExternalLink(item.sectionFields.link)"
                            class="text-white bg-blue-700 hover:bg-blue-800 
                            focus:outline-none focus:ring-0 focus:ring-blue-300 
                            font-medium rounded-full text-md px-5 py-2.5 
                            text-center mr-2 mb-2 dark:bg-blue-600 w-full
                            dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :style="{color: item.buttonTextColor,
                                'background-color': item.buttonBgColor
                            }">
                            {{item.buttonText}}
                        </button>
                    </div>
                </div>
                <!-- FB Group -->
                <div v-if="item.section.name=='Facebook Group'" class="mt-2 mb-4">
                    <img v-if="item.sectionFields.type=='image'" 
                        :src="item.sectionFields.typeContentImage.includes('biolink') 
                        ? helper.applink + item.sectionFields.typeContentImage 
                        : item.sectionFields.typeContentImage"
                        class="w-32 h-32 mx-auto rounded-full"/>
                    <div v-if="item.sectionFields.type=='video'">
                        <div v-if="item.sectionFields.typeContentVideo == 'youtube' && item.sectionFields.typeContentVideoUrl" class="mt-6 mx-auto">
                            <!-- <iframe :src="extractVideoId(item.sectionFields.typeContentVideoUrl)" frameborder="0" width="100%" height="232"></iframe> -->
                            <video-display :url="item.sectionFields.typeContentVideoUrl" fheight="232"/>
                        </div>
                        <div v-if="item.sectionFields.typeContentVideo == 'vimeo' && item.sectionFields.typeContentVideoUrl" class="mt-0 mx-auto">
                            <!-- <iframe title="vimeo-player" :src="extractVideoId(item.sectionFields.typeContentVideoUrl)" 
                                width="100%" height="232" frameborder="0" allowfullscreen></iframe> -->
                            <video-display :url="item.sectionFields.typeContentVideoUrl" fheight="232"/>
                        </div>
                    </div>
                    <h1 class="font-bold text-3xl text-center" 
                        :style="{color: item.sectionFields.titleColor}">
                        {{item.sectionFields.title}}
                    </h1>
                    <p class="mt-2 text-center font-semibold" 
                        :style="{color: item.sectionFields.titleColor}"
                        v-html="item.sectionFields.description"></p>
                    <div v-if="item.sectionFields.fbGroupLink" class="flex justify-center mt-2">
                        <button type="button"
                            @click="openExternalLink(item.sectionFields.fbGroupLink)"
                            class="text-white bg-blue-700 hover:bg-blue-800 
                            focus:outline-none focus:ring-0 focus:ring-blue-300 
                            font-medium rounded-full text-md px-5 py-2.5 
                            text-center mr-2 mb-2 dark:bg-blue-600 w-full
                            dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :style="{color: item.buttonTextColor,
                                'background-color': item.buttonBgColor
                            }">
                            {{item.buttonText}}
                        </button>
                    </div>
                </div>
                <!-- TikTok -->
                <div v-if="item.section.name=='TikTok'" class="mt-2 mb-4">
                    <!-- <iframe
                        class="embed-responsive-item min-h-[46em]"
                        scrolling="no"
                        frameborder="no"
                        width="100%"
                        allow="accelerometer;autoplay;encrypted-media;gyroscope;picture-in-picture"
                        :src="extractVideoId(item.sectionFields.tiktokUrl)"
                    ></iframe> -->
                    <video-display :url="item.sectionFields.tiktokUrl" fheight="" class="embed-responsive-item min-h-[46em]"/>
                </div>
                <!-- Mail signup -->
                <div v-if="item.section.name=='Mail signup'" class="mt-2 mb-4">
                    <div class="flex justify-center mt-2">
                        <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 
                            focus:outline-none focus:ring-0 focus:ring-blue-300 
                            font-medium rounded-full text-md px-5 py-2.5 
                            text-center mr-2 mb-2 dark:bg-blue-600 w-full
                            dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :style="{color: item.buttonTextColor,
                                'background-color': item.buttonBgColor
                            }">
                            <font-awesome-icon 
                                v-if="item.sectionFields.buttonIcon" 
                                :icon="item.sectionFields.buttonIcon" 
                                class="mt-0.5"/>
                            {{item.buttonText}}
                        </button>
                    </div>
                </div>
                <!-- WhatsApp -->
                <div v-if="item.section.name=='WhatsApp'" class="mt-2 mb-4">
                    <img v-if="item.sectionFields.type=='image'" 
                        :src="item.sectionFields.typeContentImage.includes('biolink') 
                        ? helper.applink + item.sectionFields.typeContentImage 
                        : item.sectionFields.typeContentImage"
                        class="w-32 h-32 mx-auto rounded-full"/>
                    <div v-if="item.sectionFields.type=='video'">
                        <div v-if="item.sectionFields.typeContentVideo == 'youtube' && item.sectionFields.typeContentVideoUrl" class="mt-6 mx-auto">
                            <!-- <iframe :src="extractVideoId(item.sectionFields.typeContentVideoUrl)" frameborder="0" width="100%" height="232"></iframe> -->
                            <video-display :url="item.sectionFields.typeContentVideoUrl" fheight="232"/>
                        </div>
                        <div v-if="item.sectionFields.typeContentVideo == 'vimeo' && item.sectionFields.typeContentVideoUrl" class="mt-0 mx-auto">
                            <!-- <iframe title="vimeo-player" :src="extractVideoId(item.sectionFields.typeContentVideoUrl)" 
                                width="100%" height="232" frameborder="0" allowfullscreen></iframe> -->
                            <video-display :url="item.sectionFields.typeContentVideoUrl" fheight="232"/>
                        </div>
                    </div>
                    <h1 class="font-bold text-3xl text-center" 
                        :style="{color: item.sectionFields.titleColor}">
                        {{item.sectionFields.title}}
                    </h1>
                    <p class="mt-2 text-center font-semibold" 
                        :style="{color: item.sectionFields.titleColor}"
                        v-html="item.sectionFields.description"></p>
                    <div v-if="item.sectionFields.whatsappNumber" class="flex justify-center mt-2">
                        <a :href="`https://wa.me/${item.sectionFields.whatsappNumber}`" 
                            target="_blank"
                            class="text-white bg-blue-700 hover:bg-blue-800 
                            focus:outline-none focus:ring-0 focus:ring-blue-300 
                            font-medium rounded-full text-md px-5 py-2.5 
                            text-center mr-2 mb-2 dark:bg-blue-600 w-full
                            dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :style="{color: item.buttonTextColor,
                                'background-color': item.buttonBgColor
                            }">
                            {{item.buttonText}}
                        </a>
                    </div>
                </div>
                <!-- Calendly -->
                <div v-if="item.section.name=='Calendly'" class="mt-2 mb-4">
                    <h1 class="font-bold text-3xl text-center" 
                        :style="{color: item.sectionFields.titleColor}">
                        {{item.sectionFields.title}}
                    </h1>
                    <p class="mt-2 text-center font-semibold" 
                        :style="{color: item.sectionFields.titleColor}"
                        v-html="item.sectionFields.description"></p>
                    <div v-if="item.sectionFields.calendlyLink" class="flex justify-center mt-2">
                        <button type="button" 
                            @click="openExternalLink(item.sectionFields.calendlyLink)"
                            class="text-white bg-blue-700 hover:bg-blue-800 
                            focus:outline-none focus:ring-0 focus:ring-blue-300 
                            font-medium rounded-full text-md px-5 py-2.5 
                            text-center mr-2 mb-2 dark:bg-blue-600 w-full
                            dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :style="{color: item.buttonTextColor,
                                'background-color': item.buttonBgColor
                            }">
                            {{item.buttonText}}
                        </button>
                    </div>
                </div>
                <!-- Lead Gen -->
                <div v-if="item.section.name=='Lead Generation'" class="mt-2 mb-4">
                    <div class="flex justify-center mt-2">
                        <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 
                            focus:outline-none focus:ring-0 focus:ring-blue-300 
                            font-medium rounded-full text-md px-5 py-2.5 
                            text-center mr-2 mb-2 dark:bg-blue-600 w-full
                            dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :style="{color: item.buttonTextColor,
                                'background-color': item.buttonBgColor
                            }">
                            {{item.buttonText}}
                        </button>
                    </div>
                </div>
                <!-- FAQ -->
                <div v-if="item.section.name=='FAQ'" class="mt-2 mb-4">
                    <h1 class="font-bold text-3xl text-center" 
                        :style="{color: item.sectionFields.titleColor}">
                        {{item.sectionFields.title}}
                    </h1>
                    <p class="mt-2 text-center font-semibold" 
                        :style="{color: item.sectionFields.textColor}"
                        v-html="item.sectionFields.text"></p>
                    <!-- Accordion -->
                    <div v-if="item.sectionFields.qestion">
                        <div :style="{'background-color': item.sectionFields.qstnBgColor}">
                            <list-accordion :title="item.sectionFields.qestion">
                                <div>
                                    {{item.sectionFields.answer}}
                                </div>
                            </list-accordion>
                        </div>
                        <div v-if="item.sectionFields.moreFaq.length">
                            <div v-for="(faq, i) in item.sectionFields.moreFaq" :key="i"
                                :style="{'background-color': item.sectionFields.qstnBgColor}">
                                <list-accordion :title="faq.question">
                                    <div>
                                        {{faq.answer}}
                                    </div>
                                </list-accordion>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- GoogleReview -->
                <div v-if="item.section.name=='GoogleReview'" class="mt-2 mb-4">

                </div>
                <!-- Link -->
                <div v-if="item.section.name=='Link'" class="mt-2 mb-4">
                    <div v-if="item.sectionFields.destinationURL" class="flex justify-center">
                        <a :href="item.sectionFields.destinationURL" 
                            target="_blank"
                            class="text-white bg-blue-700 hover:bg-blue-800 
                            focus:outline-none focus:ring-0 focus:ring-blue-300 
                            font-medium rounded-full text-md px-5 py-2.5 
                            text-center mr-2 mb-2 dark:bg-blue-600 w-full
                            dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :style="{color: item.buttonTextColor,
                                'background-color': item.buttonBgColor
                            }">
                            <font-awesome-icon 
                                v-if="item.sectionFields.buttonIcon" 
                                :icon="item.sectionFields.buttonIcon" 
                                class="mt-0.5"/>
                            {{item.buttonText}}
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Socials -->
        <div class="mt-6">
            <socials :settings="setting" />
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import helper from '../../../helpers';
import Socials from './Socials.vue';
import ListAccordion from '../../link/LinkAccordion.vue'
import VideoDisplay from './VideoDisplay.vue';

const props = defineProps({
    settings: Object,
    sections: Array,
    customs: Object
});
const videoURL = ref('')

let setting = ref(props.settings)
let section = ref(props.sections)
let custom = ref(props.customs)

watch(() => props.settings, (newVal, oldVal) => {
    setting.value = newVal
}, {deep: true});

watch(() => props.sections, (newVal, oldVal) => {
    section.value = newVal
}, {deep: true});

watch(() => props.customs, (newVal, oldVal) => {
    custom.value = newVal
}, {deep: true});

function openExternalLink(link) {
    window.open(link);
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
        videoURL.value = `https://youtube.com/embed/${video}`
    }else if(video.includes('vimeo')) {
        if(video.includes('https://vimeo.com/')){
            video = video.replace("https://vimeo.com/","");
        }else if(video.includes('https://www.vimeo.com/')){
            video = video.replace("https://www.vimeo.com/","");
        }
        videoURL.value = `https://player.vimeo.com/video/${video}?h=8ef4640006`
    }else if(video.includes('spotify')) {
        if(video.includes('track')) {
            video = video.replace("https://open.spotify.com/track/","");
            videoURL.value = `https://open.spotify.com/embed/track/${video}`
        }else if(video.includes('album')) {
            video = video.replace("https://open.spotify.com/album/","");
            videoURL.value = `https://open.spotify.com/embed/album/${video}`
        }else if(video.includes('show')) {
            video = video.replace("https://open.spotify.com/show/","");
            videoURL.value = `https://open.spotify.com/embed/show/${video}?theme=0`
        }else if(video.includes('episode')) {
            video = video.replace("https://open.spotify.com/episode/","");
            videoURL.value = `https://open.spotify.com/embed/episode/${video}?theme=0`
        }
    }else if(video.includes('twitch')) {
        video = video.replace("https://www.twitch.tv/","");
        videoURL.value = `https://player.twitch.tv/?channel=${video}&autoplay=false&parent=${window.location.host}`
    }else if(video.includes('tiktok')) {
        video = video.split('/')[5];
        videoURL.value = `https://www.tiktok.com/embed/${video}`
    }

    return videoURL.value;
}
</script>

<style>

</style>