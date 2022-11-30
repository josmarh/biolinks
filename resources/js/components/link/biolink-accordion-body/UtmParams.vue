<template>
    <div class="p-4">
        <p class="flex gap-2 text-gray-500 text-sm">
            The campaign will be automatically set for 
            each link in particular based on the name of the link.
        </p>
        <div class="mt-4">
            <label for="medium" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Medium
            </label>
            <input v-model="model.utmParams.medium"
                type="text" name="medium" id="medium" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="">
        </div>
        <div class="mt-4">
            <label for="source" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Source
            </label>
            <input v-model="model.utmParams.source"
                type="text" name="source" id="source" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="">
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