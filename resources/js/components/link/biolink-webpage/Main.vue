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
            :style="{'color': setting.textColor}">
            {{setting.title}}
        </h5>

        <!-- Description -->
        <p v-if="settings.description"
            class="text-lg font-normal text-center mt-4 tracking-tight"
            :style="{'color': setting.textColor, 'font-family': setting.fonts}" 
            v-html="settings.description"></p>

        <!-- Video Display -->
        <div v-if="setting.video.type == 'youtube' && setting.video.link" class="mt-6 mx-auto">
            <iframe :src="extractVideoId(setting.video.link)" frameborder="0" width="340" height="300"></iframe>
        </div>
        <div v-if="setting.video.type == 'vimeo' && setting.video.link" class="mt-0 mx-auto">
            <iframe title="vimeo-player" :src="extractVideoId(setting.video.link)" 
                width="340" height="300" frameborder="0" allowfullscreen></iframe>
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
import Socials from './Socials.vue'

const props = defineProps({
    settings: Object,
    sections: Object,
    customs: Object
});
const videoURL = ref('')

let setting = ref(props.settings)
let section = ref(props.sectionSettings)
let custom = ref(props.customSettings)

watch(() => props.settings, (newVal, oldVal) => {
    setting.value = newVal
});

watch(() => props.sections, (newVal, oldVal) => {
    section.value = newVal
});

watch(() => props.customs, (newVal, oldVal) => {
    custom.value = newVal
});

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
    }

    return videoURL.value;
}
</script>

<style>

</style>