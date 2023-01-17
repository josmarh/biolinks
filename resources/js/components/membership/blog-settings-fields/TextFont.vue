<template>
    <div>
        <div class="">
            <label for="title" 
                class="block mb-2 text-sm font-medium 
                text-gray-900 dark:text-white">
                Title
            </label>
            <input type="text" id="title" 
            v-model="model.title"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm rounded-lg 
            focus:ring-blue-500 focus:border-blue-500 
            block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 
            dark:text-white dark:focus:ring-blue-500 
            dark:focus:border-blue-500" 
            placeholder="" required>
        </div>
        <div class="mt-2">
            <label for="subHeading" 
                class="block mb-2 text-sm font-medium 
                text-gray-900 dark:text-white">
                Subheading
            </label>
            <input type="text" id="subHeading" 
            v-model="model.subHeading"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm rounded-lg 
            focus:ring-blue-500 focus:border-blue-500 
            block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 
            dark:text-white dark:focus:ring-blue-500 
            dark:focus:border-blue-500" 
            placeholder="" required>
        </div>
        <div class="mt-2">
            <label for="disclaimer" 
                class="block mb-2 text-sm font-medium 
                text-gray-900 dark:text-white">
                Spam Disclaimer
            </label>
            <input type="text" id="disclaimer" 
            v-model="model.disclaimer"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm rounded-lg 
            focus:ring-blue-500 focus:border-blue-500 
            block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 
            dark:text-white dark:focus:ring-blue-500 
            dark:focus:border-blue-500" 
            placeholder="" required>
        </div>
        <div class="mt-2">
            <label for="headerFontFamily" 
                class="block mb-2 text-sm font-medium 
                text-gray-900 dark:text-white">
                Heading Font Family
            </label>
            <select id="headerFontFamily" 
            v-model="model.headerFontFamily"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm rounded-lg 
            focus:ring-blue-500 focus:border-blue-500 
            block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 
            dark:text-white dark:focus:ring-blue-500 
            dark:focus:border-blue-500">
                <option value="BlinkMacSystemFont">BlinkMacSystemFont</option>
                <option value="Droid Sans">Droid Sans</option>
                <option value="Droid Serif">Droid Serif</option>
                <option value="Lato">Lato</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Open Sans">Open Sans</option>
                <option value="Open Sans Condensed">Open Sans Condensed</option>
                <option value="Oswald">Oswald</option>
                <option value="PT Sans">PT Sans</option>
                <option value="PT Serif">PT Serif</option>
                <option value="Roboto">Roboto</option>
                <option value="Roboto Condensed">Roboto Condensed</option>
                <option value="Roboto Slab">Roboto Slab</option>
                <option value="Source Sans Pro">Source Sans Pro</option>
                <option value="Ubuntu">Ubuntu</option>
                <option value="Varela">Varela</option>
                <option value="Varela Round">Varela Round</option>
                <option value="Vollkorn">Vollkorn</option>
            </select>
        </div>
        <div class="mt-2">
            <label for="TextFontFamily" 
                class="block mb-2 text-sm font-medium 
                text-gray-900 dark:text-white">
                Text Font Family
            </label>
            <select id="TextFontFamily" 
            v-model="model.textFontFamily"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm rounded-lg 
            focus:ring-blue-500 focus:border-blue-500 
            block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 
            dark:text-white dark:focus:ring-blue-500 
            dark:focus:border-blue-500">
                <option value="Avenir">Avenir</option>
                <option value="Droid Sans">Droid Sans</option>
                <option value="Droid Serif">Droid Serif</option>
                <option value="Lato">Lato</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Open Sans">Open Sans</option>
                <option value="Open Sans Condensed">Open Sans Condensed</option>
                <option value="Oswald">Oswald</option>
                <option value="PT Sans">PT Sans</option>
                <option value="PT Serif">PT Serif</option>
                <option value="Roboto">Roboto</option>
                <option value="Roboto Condensed">Roboto Condensed</option>
                <option value="Roboto Slab">Roboto Slab</option>
                <option value="Source Sans Pro">Source Sans Pro</option>
                <option value="Ubuntu">Ubuntu</option>
                <option value="Varela">Varela</option>
                <option value="Varela Round">Varela Round</option>
                <option value="Vollkorn">Vollkorn</option>
            </select>
        </div>
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