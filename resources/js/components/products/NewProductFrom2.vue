<template>
    <div class="flex justify-between mt-6">
        <div>
            <h1 class="py- text-3xl font-bold text-gray-800">
                Product Options
            </h1>
        </div>
        <div>
            <button type="button" @click="save"
                class="text-white bg-blue-700 hover:bg-blue-800 
                focus:ring-0 focus:ring-blue-300 font-medium 
                text-sm px-5 py-2.5 mr-2 capitalize
                dark:bg-blue-600 dark:hover:bg-blue-700 
                focus:outline-none dark:focus:ring-blue-800">
                Save Progress
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

let model = ref({
    title: ''
})

function save() {

}

</script>

<style>

</style>