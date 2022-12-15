<template>
     <div class="p-6 max-w-full bg-white 
        border border-gray-200 
        shadow-md dark:bg-gray-800">
        <h5 class="mb-2 text-xl font-semibold 
            tracking-tight text-gray-900">
            Profile Information
        </h5>
        <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
            Update your account's profile information and email address. 
        </p>
        <form @submit.prevent="updateInfo">
            <div class="relative w-full mb-3">
                <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="grid-password">
                    Full Name
                </label>
                <input
                    type="text"
                    v-model="model.name"
                    class="border-0 px-3 py-3 placeholder-gray-400 
                    text-gray-700 bg-white rounded text-sm shadow 
                    focus:outline-none focus:ring w-full"
                    placeholder="Full Name"
                    style="transition: all 0.15s ease 0s;"
                    required/>
            </div>
            <div class="relative w-full mb-3">
                <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="grid-password">
                    Email
                </label>
                <input
                    type="email"
                    v-model="model.email"
                    class="border-0 px-3 py-3 placeholder-gray-400 
                    text-gray-700 bg-white rounded text-sm shadow 
                    focus:outline-none focus:ring w-full"
                    placeholder="Email"
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
    emit('update', model.value, 'userInfo');
}
</script>

<style>

</style>