<template>
    <!-- Agreement URL -->
    <div class="mt-4">
        <label for="agreementURLs" 
            class="block mb-2 text-sm font-medium flex
            text-gray-900 dark:text-white capitalize gap-2">
            Agreement URL
        </label>
        <div class="flex">
            <input type="url" id="agreementURLs" 
            v-model="agreementURL"
            class="rounded-none bg-gray-50 
            border text-gray-900 focus:ring-blue-500 
            focus:border-blue-500 block flex-1 min-w-0 
            w-full text-sm border-gray-300 p-2.5 
            dark:bg-gray-700 dark:border-gray-600 
            dark:placeholder-gray-400 dark:text-white 
            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
            placeholder="https://website.com">
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: String
})
const emit = defineEmits(['update'])

let agreementURL = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    agreementURL.value = newVal
})

watch(agreementURL, (newVal, oldVal) => {
    emit('update', agreementURL.value)
})
</script>

<style>

</style>