<template>
    <div class="md:grid md:grid-cols-3 md:gap-6 mt-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Deliver an external link (Zoom, hangouts, etc)
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    Link to an external URL. Great if you're selling a Zoom link, 
                    Google Hangout, or other file located outside of Hyax.
                </p>
            </div>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <div class="shadow-xl sm:overflow-hidden sm:rounded-md">
                <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                    <div class="mt-4">
                        <input type="url" id="extLink" 
                        v-model="extLink.link"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5  
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500 dark:bg-gray-700" 
                        placeholder="https://">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: String
})
const emit = defineEmits(['updateProduct'])

let extLink = ref({
    link: props.data,
    type: 'extLink'
})

watch(extLink, (newVal, oldVal) => {
    emit('updateProduct', extLink.value)
})
</script>

<style>

</style>