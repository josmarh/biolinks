<template>
    <div class="p-4">
        <!-- Page Title -->
        <div class="">
            <label for="page-title" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-heading" class="mt-0.5" />
                Page Title
            </label>
            <input v-model="model.seo.title"
                type="text" name="page-title" id="page-title" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="">
            <p class="flex gap-2 text-gray-500 text-sm">
                Completely change the page title to a custom one that you are setting here.
            </p>
        </div>
        <!-- Meta Description -->
        <div class="mt-4">
            <label for="meta" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-paragraph" class="mt-0.5" />
                Meta Description
            </label>
            <input v-model="model.seo.metaDesc"
                type="text" name="meta" id="meta" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="">
            <p class="flex gap-2 text-gray-500 text-sm">
                Set a custom meta description for your biolink page to rank better in search engines.
            </p>
        </div>
        <!-- Favicon -->
        <div class="mt-4">
            <label class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Upload Favicon
            </label>
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" 
                    class="flex flex-col items-center justify-center 
                    w-full border-2 border-gray-300 border-dashed 
                    rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 
                    dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 
                    dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <font-awesome-icon icon="fa-solid fa-camera" class="w-10 h-10 mb-3 text-gray-400" />
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-semibold">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" @change="uploadFile($event)" />
                </label>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: Object
});
const emit = defineEmits(['updateSettings'])

let model = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep:true})

watch(model, (newVal, oldVal) => {
    emit('updateSettings', model.value)
}, {deep:true})

function uploadFile(ev) {
    const file = ev.target.files[0];
    const reader = new FileReader();

    reader.onload = () => {
        model.value.seo.favicon = reader.result;
    }
    reader.readAsDataURL(file);
}
</script>

<style>

</style>