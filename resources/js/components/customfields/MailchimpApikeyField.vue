<template>
    <div class="mt-4">
        <label for="mailchimpAPIKeys" 
            class="block mb-2 text-sm font-medium flex
            text-gray-900 dark:text-white capitalize gap-2">
            Mailchimp API Key
        </label>
        <div class="flex">
            <input type="text" id="mailchimpAPIKeys" 
            v-model="mailchimpAPIKey"
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
            Leave empty to disable mailchimp integration. 
            How to get these details: 
            <a href="https://mailchimp.com/developer/guides/manage-subscribers-with-the-mailchimp-api/#Before_you_start" 
                target="_blank" class="underline">
                MailChimp Documentation
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

let mailchimpAPIKey = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    mailchimpAPIKey.value = newVal
})

watch(mailchimpAPIKey, (newVal, oldVal) => {
    emit('update', mailchimpAPIKey.value)
})
</script>

<style>

</style>