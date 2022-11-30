<template>
    <div class="p-4">
        <!-- Brand Consent -->
        <label for="schedule-temp-url" 
            class="inline-flex relative items-center cursor-pointer">
            <input type="checkbox"
                id="schedule-temp-url" 
                class="sr-only peer"
                @change="updateScheduleURL($event)"
                :checked="model.branding.display == 'yes' ? true : false">
            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                peer peer-checked:after:translate-x-full 
                peer-checked:after:border-white 
                after:content-[''] after:absolute after:top-[2px] 
                after:left-[2px] after:bg-white after:border-gray-300 
                after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                Display Branding
            </span>
        </label>
        <!-- Brand name -->
        <div class="mt-4">
            <label for="brand-name" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-shuffle" class="mt-0.5" />
                Branding Name
            </label>
            <input v-model="model.branding.name"
                type="text" name="brand-name" id="brand-name" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="">
            <p class="flex gap-2 text-gray-500 text-sm">
                Leave empty to have a default site branding.
            </p>
        </div>
        <!-- Brand URL -->
        <div class="mt-4">
            <label for="brand-url" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5" />
                Branding URL
            </label>
            <input v-model="model.branding.url"
                type="url" name="brand-url" id="brand-url" 
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