<template>
    <div class="w-full max-w-sm p-4 bg-white border 
        border-gray-200 shadow-md sm:p-6 
        md:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div v-if="resMsg.errorMsg" 
            class="relative flex items-center 
            justify-between py-3 px-5 bg-red-500 
            text-white text-sm rounded-lg mb-2">
            {{resMsg.errorMsg}}
            <span @click="resMsg.errorMsg = ''" 
                class="w-8 h-8 flex items-center justify-center 
                rounded-full transition-color cursor-pointer 
                hover:bg-[rgba(0,0,0,0.2)]">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="h-6 w-6" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor" 
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </span>
        </div>
        <div v-if="resMsg.successMsg" 
            class="relative flex items-center 
            justify-between py-3 px-5 bg-green-500 
            text-white text-sm rounded-lg mb-2">
            {{resMsg.successMsg}}
            <span @click="resMsg.successMsg = ''" 
                class="w-8 h-8 flex items-center justify-center 
                rounded-full transition-color cursor-pointer 
                hover:bg-[rgba(0,0,0,0.2)]">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="h-6 w-6" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor" 
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </span>
        </div>
        <form class="space-y-6" @submit.prevent="resetPassword">
            <AppLogo />
            <div>
                <label for="email" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                    Email
                </label>
                <input v-model="email"
                type="email" name="email" id="email" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500 
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="name@company.com" required>
            </div>
            <button type="submit" 
                class="w-full text-white bg-blue-700 
                hover:bg-blue-800 focus:ring-4 focus:outline-none 
                focus:ring-blue-300 font-medium text-sm 
                px-5 py-2.5 text-center dark:bg-blue-600 
                dark:hover:bg-blue-700 dark:focus:ring-blue-800 relative"
                style="transition: all 0.15s ease 0s;"
                :disabled="isDisabled">
                Login
                <span class="absolute right-0 inset-y-0 flex items-center pr-3">
                    <ButtonSpinner v-if="isDisabled"/>
                </span>
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import store from '../../store';
import ButtonSpinner from '../../components/ButtonSpinner.vue'
import AppLogo from '../../components/AppLogo.vue'

const router = useRouter();
let email = ref('');
let isDisabled = ref(false);

const resMsg = ref({
    errorMsg: '',
    successMsg: '',
})

function resetPassword() {
    isDisabled.value = true;
    store
        .dispatch('forgotPassword', {email: email['_rawValue']})
        .then((res) => {
            resMsg.value.successMsg = res.message;
            isDisabled.value = false;
            setTimeout(() => {
                router.push({name: 'ResetPassword', params: {email: email.value}});
            }, 3000);
        })
        .catch((err) => {
            isDisabled.value = false;
            if(err.response){
                if (err.response.data.hasOwnProperty('message')){
                    resMsg.value.errorMsg = err.response.data.message
                }else {
                    resMsg.value.errorMsg = err.response.data.error
                }
            }
        })
}
</script>

<style>

</style>