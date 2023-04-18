<template>
    <div class="w-full max-w-sm p-4 bg-white border 
        border-gray-200 shadow-md sm:p-6 
        md:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div v-if="config.errorMsg" 
            class="relative flex items-center 
            justify-between py-3 px-5 bg-red-500 
            text-white text-sm rounded-lg mb-2">
            {{config.errorMsg}}
            <span @click="config.errorMsg = ''" 
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
        <div v-if="config.successMsg" 
            class="relative flex items-center 
            justify-between py-3 px-5 bg-green-500 
            text-white text-sm rounded-lg mb-2">
            {{config.successMsg}}
            <span @click="config.successMsg = ''" 
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
        <form class="space-y-6" @submit.prevent="register">
            <AppLogo />
            <div>
                <label for="name" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                    Name
                </label>
                <input v-model="model.name"
                type="text" name="name" id="name" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500 
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="john doe" required>
            </div>
            <div>
                <label for="email" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                    Email
                </label>
                <input v-model="model.email"
                type="email" name="email" id="email" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500 
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="name@company.com" required>
            </div>
            <div class="relative">
                <label for="password" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                    Password
                </label>
                <input v-model="model.password" 
                type="password" name="password" id="password" 
                class="bg-gray-50 border border-gray-300 text-gray-900 
                text-sm focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="••••••••" required>
                <showPassword v-if="model.password !=''" :elem="'password'"/>
            </div>
            <div class="relative">
                <label for="password_confirmation" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                    Confirm Password
                </label>
                <input v-model="model.password_confirmation" 
                type="password" name="password" id="password_confirmation" 
                class="bg-gray-50 border border-gray-300 text-gray-900 
                text-sm focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="••••••••" required>
                <showPassword v-if="model.password_confirmation !=''" :elem="'password_confirmation'"/>
            </div>
            <button type="submit" 
                class="w-full text-white bg-blue-700 
                hover:bg-blue-800 focus:ring-4 focus:outline-none 
                focus:ring-blue-300 font-medium text-sm 
                px-5 py-2.5 text-center dark:bg-blue-600 
                dark:hover:bg-blue-700 dark:focus:ring-blue-800 relative"
                style="transition: all 0.15s ease 0s;"
                :disabled="config.isDisabled">
                Register
                <span class="absolute right-0 inset-y-0 flex items-center pr-3">
                    <ButtonSpinner v-if="config.isDisabled"/>
                </span>
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import showPassword from '../../components/ShowPassword.vue'
import ButtonSpinner from '../../components/ButtonSpinner.vue'
import AppLogo from '../../components/AppLogo.vue'
import resellerStore from '../../store/reseller-store';

const router = useRouter()
const config = ref({
    errorMsg: '',
    successMsg: '',
    isDisabled: false
})
const model = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const register = () => {
    config.value.isDisabled = true
    
    resellerStore
        .dispatch('register',model.value)
        .then(res => {
            config.value.isDisabled = false
            config.value.successMsg = res.message

            model.value.name = '',
            model.value.email = '',
            model.value.password = '',
            model.value.password_confirmation = ''
            
            setTimeout(() => {
                router.push({
                    name: 'Login'
                })
            },1500)
        })
        .catch(err => {
            config.value.isDisabled = false
            
            if (err.response.data.hasOwnProperty('message')) {
                config.value.errorMsg = err.response.data.message
            }else {
                config.value.errorMsg = err.response.data.error
            }
        })
}
</script>

<style>

</style>