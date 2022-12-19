<template>
    <iframe 
        :src="modelURL" 
        width="100%" 
        :height="frameH" 
        frameborder="0" 
        allowfullscreen></iframe>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    url: String,
    fheight: String
});
let videoURL = ref('')
let modelURL = extractVideoId(props.url)
let frameH = ref(props.fheight)

watch(() => props.url, (newVal, oldVal) => {
    modelURL = extractVideoId(newVal);
})

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
    }else {
        video = videoURL.value;
    }
    return videoURL.value;
}
</script>

<style>

</style>