<template>
    <div class="mt-4">
        <label for="link" 
            class="block mb-2 text-sm font-medium flex
            text-gray-900 dark:text-white capitalize gap-2">
            <font-awesome-icon icon="fa-solid fa-link" />
            {{label}}
        </label>
        <input v-model="link"
            type="url" name="link" id="link" 
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm focus:ring-blue-500 
            focus:border-blue-500 block w-full p-2.5 
            dark:bg-gray-600 dark:border-gray-500
            dark:placeholder-gray-400 dark:text-white" 
            placeholder="">
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: String,
    label: String
})
const emit = defineEmits(['update'])

let link = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    link.value = newVal
})

watch(link, (newVal, oldVal) => {
    emit('update', link.value)
})
</script>

<style>

</style>