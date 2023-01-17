<template>
    <div>
        <label for="email_box" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Show / Hide Email Box
        </label>
        <select id="email_box" 
        v-model="model.emailbox"
        class="bg-gray-50 border border-gray-300 
        text-gray-900 text-sm rounded-lg 
        focus:ring-blue-500 focus:border-blue-500 
        block w-full p-2.5 dark:bg-gray-700 
        dark:border-gray-600 dark:placeholder-gray-400 
        dark:text-white dark:focus:ring-blue-500 
        dark:focus:border-blue-500">
            <option value="show">Show email box</option>
            <option value="hide">Hide email box</option>
        </select>
        <p class="mt-1 text-xs">
            <font-awesome-icon icon="fa-solid fa-triangle-exclamation" class="mr-1 text-red-500" />
            This email capture form just captures emails for guest viewers. 
            It does NOT grant access to paid perks / plans.
        </p>
    </div>
</template>

<script setup>
import { ref, watch } from "vue"

const props = defineProps({
    data: Object
})
const emit = defineEmits(['update'])
let model = ref(props.data)

watch(model, (newVal, oldVal) => {
    emit('update', model.value)
}, {deep:true})
</script>

<style>

</style>