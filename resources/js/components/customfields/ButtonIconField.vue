<template>
    <div class="mt-4">
        <label for="buttonIcon" 
            class="block mb-2 text-sm font-medium flex
            text-gray-900 dark:text-white capitalize gap-2">
            <font-awesome-icon icon="fa-solid fa-earth-africa" class="mt-0.5" />
            Icon
        </label>
        <div class="flex">
            <input type="text" id="buttonIcon" 
            v-model="buttonIcon"
            class="rounded-none bg-gray-50 
            border text-gray-900 focus:ring-blue-500 
            focus:border-blue-500 block flex-1 min-w-0 
            w-full text-sm border-gray-300 p-2.5 
            dark:bg-gray-700 dark:border-gray-600 
            dark:placeholder-gray-400 dark:text-white 
            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
            placeholder="fa-solid fa-house" >
        </div>
        <p class="text-sm text-gray-500 mt-1">
            <a href="https://fontawesome.com/search?o=r&m=free&s=thin%2Csolid%2Cregular%2Cduotone" 
                target="_blank" rel="noopener noreferrer" class="underline">
                FontAwesome
            </a>
            icon class. Leave empty for no icon.
        </p>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: String
})
const emit = defineEmits(['update'])

let buttonIcon = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    buttonIcon.value = newVal
})

watch(buttonIcon, (newVal, oldVal) => {
    emit('update', buttonIcon.value)
})
</script>

<style>

</style>