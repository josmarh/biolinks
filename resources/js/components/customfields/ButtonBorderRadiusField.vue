<template>
    <!-- Border Radius -->
    <div class="mt-4">
        <label for="btnborderRadius" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Border radius
        </label>
        <select id="btnborderRadius" 
            v-model="borderRadius"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm focus:ring-blue-500 
            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
            dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="straight">Straight</option>
            <option value="round">Round</option>
            <option value="rounded">Rounded</option>
        </select>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: String
})
const emit = defineEmits(['update'])

let borderRadius = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    borderRadius.value = newVal
})

watch(borderRadius, (newVal, oldVal) => {
    emit('update', borderRadius.value)
})
</script>

<style>

</style>