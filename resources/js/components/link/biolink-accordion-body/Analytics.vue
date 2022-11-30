<template>
    <div class="p-4">
        <!-- Google ID -->
        <div>
            <label for="googleid" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <svg role="img" viewBox="0 0 24 24" class="mt-0.5  w-4 h-4" xmlns="http://www.w3.org/2000/svg"><title>Google</title><path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/></svg>
                Google Analytics ID
            </label>
            <input v-model="model.analytics.googleId"
                type="text" name="googleid" id="googleid" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="">
            <p class="flex gap-2 text-gray-500 text-sm">
                Enable tracking with Google Analytics by 
                adding your analytics ID (ex: UA2222222-33).
            </p>
        </div>
        <!-- Facebook pixel -->
        <div class="mt-4">
            <label for="fbpixel" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <svg role="img" viewBox="0 0 24 24" class="mt-0.5 w-4 h-4" xmlns="http://www.w3.org/2000/svg"><title>Facebook</title><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Facebook Pixel
            </label>
            <input v-model="model.analytics.fbPixel"
                type="text" name="fbpixel" id="fbpixel" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="">
            <p class="flex gap-2 text-gray-500 text-sm">
                Enable the Facebook Pixel by adding 
                your only Facebook Pixel ID
            </p>
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
</script>

<style>

</style>