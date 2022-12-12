<template>
    <div class="mt-4">
        <label for="googleKey" 
            class="block mb-2 text-sm font-medium flex
            text-gray-900 dark:text-white capitalize gap-2">
            Google Key
        </label>
        <div class="flex">
            <input type="text" id="googleKey" 
            v-model="googleKey"
            class="rounded-none bg-gray-50 
            border text-gray-900 focus:ring-blue-500 
            focus:border-blue-500 block flex-1 min-w-0 
            w-full text-sm border-gray-300 p-2.5 
            dark:bg-gray-700 dark:border-gray-600 
            dark:placeholder-gray-400 dark:text-white 
            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
            placeholder="" required>
        </div>
        <p class="text-sm text-gray-500 mt-1">
            How to get your Google API Key
            <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" 
                target="_blank" rel="noopener noreferrer" class="underline text-xs text-gray-600">
                https://developers.google.com/maps/documentation/javascript/get-api-key
            </a>
        </p>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: String
})
const emit = defineEmits(['update'])

let googleKey = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    googleKey.value = newVal
})

watch(googleKey, (newVal, oldVal) => {
    emit('update', googleKey.value)
})
</script>

<style>

</style>