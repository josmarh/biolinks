<template>
    <div class="p-6 max-w-full bg-white 
        border border-gray-200 mt-10
        shadow-md dark:bg-gray-800">
        <h5 class="mb-2 text-xl font-semibold 
            tracking-tight text-gray-900">
            Google Api Key
        </h5>
        <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
            Update your google api key for Biolink Agency lead generation. 
            <a href="https://softapi.adaleadz.com//googleapi.pdf" target="_blank"
            class="underline text-sm text-indigo-600">
                To get your key follow this guide.
            </a>
        </p>
        <form @submit.prevent="updateInfo">
            <div class="relative w-full mb-3">
                <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="grid-password">
                    Api Key
                </label>
                <input
                type="text"
                v-model="model.apiKey"
                class="border-0 px-3 py-3 placeholder-gray-400 
                text-gray-700 bg-white rounded text-sm shadow 
                focus:outline-none focus:ring w-full"
                placeholder="API KEY"
                style="transition: all 0.15s ease 0s;"
                required/>
            </div>
            <div class="text-center mt-6">
                <button
                    class="bg-blue-600 text-white active:bg-blue-700 
                    text-sm font-bold uppercase px-6 py-3 rounded 
                    shadow hover:shadow-lg outline-none focus:outline-none 
                    mr-1 mb-1 w-full relative flex justify-center"
                    type="submit"
                    style="transition: all 0.15s ease 0s;"
                    :disabled="btnDisable">
                    Save
                    <span class="absolute right-0 inset-y-0 flex items-center pr-3">
                        <ButtonSpinner v-if="btnDisable==true"/>
                    </span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import ButtonSpinner from '../ButtonSpinner.vue';

const props = defineProps({
    data: Object,
    btnDisable: Boolean
})
const emit = defineEmits(['update'])

let model = ref(props.data)

function updateInfo() {
    emit('update', model.value, 'apikey');
}
</script>

<style>

</style>