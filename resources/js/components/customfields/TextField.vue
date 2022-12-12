<template>
    <!-- Title -->
    <div class="mt-4">
        <label for="text" 
            class="block mb-2 text-sm font-medium flex
            text-gray-900 dark:text-white capitalize gap-2">
            <font-awesome-icon icon="fa-solid fa-paragraph" class="mt-0.5" />
            Text
        </label>
        <div class="flex">
            <input type="text" id="text" v-model="text"
            class="rounded-none bg-gray-50 
            border text-gray-900 focus:ring-blue-500 
            focus:border-blue-500 block flex-1 min-w-0 
            w-full text-sm border-gray-300 p-2.5 
            dark:bg-gray-700 dark:border-gray-600 
            dark:placeholder-gray-400 dark:text-white 
            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
            placeholder="">
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: String
})
const emit = defineEmits(['update'])

let text = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    text.value = newVal
})

watch(text, (newVal, oldVal) => {
    emit('update', text.value)
})
</script>

<style>

</style>