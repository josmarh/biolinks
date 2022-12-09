<template>
    <!-- Video link -->
    <div class="mt-8">
        <div class="inline-flex gap-3">
            <div class="flex items-center">
                <input id="youtube" type="radio" value="youtube" name="video" 
                    v-model="model.type"
                    class="w-4 h-4 text-blue-600 bg-gray-100 
                    border-gray-300 focus:ring-blue-500 
                    dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="ytube" 
                    class="ml-2 text-sm font-medium 
                    text-gray-900 dark:text-gray-300">
                    YouTube Video
                </label>
            </div>
            <div class="flex items-center">
                <input id="vimeoe" type="radio" value="vimeo" name="video" 
                    v-model="model.type"
                    class="w-4 h-4 text-blue-600 bg-gray-100 
                    border-gray-300 focus:ring-blue-500 
                    dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="vimeo" 
                    class="ml-2 text-sm font-medium 
                    text-gray-900 dark:text-gray-300">
                    Vimeo Video
                </label>
            </div>
        </div>
        <div class="mt-3">
            <label for="video-url" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5" />
                {{model.type === 'youtube' ? 'Add Welcome Video' : 'Add Vimeo Video'}}
            </label>
            <div class="flex">
                <input type="url" id="video-url" v-model="model.url"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                :placeholder="model.type === 'youtube' ? 'https://youtu.be/GgeTnpTkzI0' : 'https://vimeo.com/44437887'">
                <!-- <button v-if="modelSettings.video.type === 'youtube'"
                    class="inline-flex items-center px-3 
                    text-sm text-white bg-[#38B2AC] border 
                    border-r-0 border-[#38B2AC] 
                    dark:bg-[#38B2AC] dark:text-white 
                    dark:border-[#38B2AC]">
                    <font-awesome-icon icon="fa-solid fa-eye" class="mr-2" />
                    Preview
                </button> -->
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    videoType: String,
    videoURL: String
})

const emit = defineEmits(['update'])

let model = ref({
    type: props.videoType,
    url: props.videoURL
})

watch(props, (newVal, oldVal) => {
    model.value.type = newVal.videoType,
    model.value.url = newVal.videoURL
}, {deep: true})

watch(model, (newVal, oldVal) => {
    emit('update', model.value)
}, {deep: true})

</script>

<style>

</style>