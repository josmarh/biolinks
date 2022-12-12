<template>
    <div class="mt-4">
        <label for="googlePlaceId" 
            class="block mb-2 text-sm font-medium flex
            text-gray-900 dark:text-white capitalize gap-2">
            Google Place Id
        </label>
        <div class="flex">
            <input type="text" id="googlePlaceId" 
            v-model="googlePlaceId"
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
            How to get your Places Key
            <a href="https://developers.google.com/places/web-service/place-id" 
                target="_blank" rel="noopener noreferrer" class="underline text-xs text-gray-600">
                https://developers.google.com/places/web-service/place-id
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

let googlePlaceId = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    googlePlaceId.value = newVal
})

watch(googlePlaceId, (newVal, oldVal) => {
    emit('update', googlePlaceId.value)
})
</script>

<style>

</style>