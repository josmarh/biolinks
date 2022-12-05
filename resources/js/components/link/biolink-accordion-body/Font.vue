<template>
    <div class="p-4">
        <label for="target-type" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            <font-awesome-icon icon="fa-solid fa-pen-nib"/>
            Fonts
        </label>
        <select id="target-type" v-model="model.fonts"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm focus:ring-blue-500 
            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
            dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="Lato">Lato</option>
            <option value="open-sans">Open Sans</option>
            <option value="Montserrat">Montserrat</option>
            <option value="Karla">Karla</option>
            <option value="Inconsolata">Inconsolata</option>
        </select>
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