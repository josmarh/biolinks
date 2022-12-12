<template>
    <div class="mt-4">
        <label for="webhookURLs" 
            class="block mb-2 text-sm font-medium flex
            text-gray-900 dark:text-white capitalize gap-2">
            Webhook URL
        </label>
        <div class="flex">
            <input type="url" id="webhookURLs" 
            v-model="webhookURL"
            class="rounded-none bg-gray-50 
            border text-gray-900 focus:ring-blue-500 
            focus:border-blue-500 block flex-1 min-w-0 
            w-full text-sm border-gray-300 p-2.5 
            dark:bg-gray-700 dark:border-gray-600 
            dark:placeholder-gray-400 dark:text-white 
            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
            placeholder="">
        </div>
        <p class="text-sm text-gray-500">
            Where to send the caught email to. Leave empty to disable.
        </p>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: String
})
const emit = defineEmits(['update'])

let webhookURL = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    webhookURL.value = newVal
})

watch(webhookURL, (newVal, oldVal) => {
    emit('update', webhookURL.value)
})
</script>

<style>

</style>