<template>
    <div class="p-6 mt-12 max-w-full bg-white rounded-lg 
        border border-gray-200 shadow-md">
        <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900">
            Update Password
        </h5>
        <p class="mb-3 font-normal text-gray-500">
            Ensure your account is using a long, random password to stay secure. 
        </p>

        <form @submit.prevent="updatePass">
            <div class="relative w-full mb-3">
                <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="grid-password">
                    Current Password
                </label>
                <input
                    type="password"
                    v-model="model.old_password"
                    id="old_password"
                    class="block border-0 px-3 py-3 placeholder-gray-400 
                    text-gray-700 bg-white rounded text-sm shadow 
                    focus:outline-none focus:ring w-full"
                    placeholder="Current Password"
                    style="transition: all 0.15s ease 0s;"
                    required/>
                <showPassword v-if="model.old_password !=''" :elem="'old_password'"/>
            </div>
            <div class="relative w-full mb-3">
                <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="grid-password">
                    New Password
                </label>
                <input
                    type="password"
                    v-model="model.password"
                    id="password"
                    class="block border-0 px-3 py-3 placeholder-gray-400 
                    text-gray-700 bg-white rounded text-sm shadow 
                    focus:outline-none focus:ring w-full"
                    placeholder="New Password"
                    style="transition: all 0.15s ease 0s;"
                    required/>
                <showPassword v-if="model.password !=''" :elem="'password'"/>
            </div>
            <div class="relative w-full mb-3">
                <label
                    class="block uppercase text-gray-700 text-xs font-bold mb-2"
                    for="grid-password">
                    Confirm Password
                </label>
                <input
                    type="password"
                    v-model="model.password_confirmation"
                    id="confirm_password"
                    class="block border-0 px-3 py-3 placeholder-gray-400 
                    text-gray-700 bg-white rounded text-sm shadow 
                    focus:outline-none focus:ring w-full"
                    placeholder="Confirm Password"
                    style="transition: all 0.15s ease 0s;"
                    required/>
                <showPassword v-if="model.password_confirmation !=''" elem="confirm_password"/>
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
import ShowPassword from '../ShowPassword.vue';

const props = defineProps({
    data: Object,
    btnDisable: Boolean
})
const emit = defineEmits(['update'])

let model = ref(props.data)

function updatePass() {
    emit('update', model.value, 'userPass');
}
</script>

<style>

</style>