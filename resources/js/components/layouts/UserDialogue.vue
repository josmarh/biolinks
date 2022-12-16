<template>
    <Menu as="div" class="relative flex-shrink-0 z-10">
        <div>
            <MenuButton class="rounded-full flex items-right 
                focus:outline-none focus:ring-0 focus:ring-offset-2 focus:ring-blue">
                <span class="sr-only">Open user menu</span>
                <div class="items-center flex">
                    <span class="w-10 h-10 text-sm text-white
                        bg-blue-800 inline-flex items-center
                        justify-center rounded-full font-bold">
                        {{userSurffix}}
                    </span>
                </div>
            </MenuButton>
        </div>
        <transition
            enter-active-class="transition duration-100 ease-out transform"
            enter-from-class="opacity-0 scale-90"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-100 ease-in transform"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-90">
            <MenuItems class="overflow-hidden absolute right-0 
                mt-2 w-48 bg-white border shadow-lg 
                origin-top-right focus:outline-none text-gray-400">
                <MenuItem v-slot="{active, disabled}" disabled>
                    <a href="#" :class="{'bg-gray-100': active, 'opacity-40': disabled}" 
                        class="block py-2 px-4 text-sm text-gray-700">
                        Manage Account
                    </a>
                </MenuItem>
                <MenuItem v-slot="{active}">
                    <router-link :to="{name: 'Dashboard'}"
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon icon="fa-solid fa-house" class="h-4 w-4 mr-2 mt-0.5" />
                        Dashboard
                    </router-link>
                </MenuItem>
                <MenuItem v-slot="{active}">
                    <router-link :to="{name: 'Account'}"
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon icon="fa-solid fa-user" class="h-4 w-4 mr-2 mt-0.5" />
                        Account
                    </router-link>
                </MenuItem>
                <MenuItem v-slot="{active}">
                    <a @click="logout" 
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon icon="fa-solid fa-right-from-bracket" class="h-4 w-4 mr-2 mt-0.5" />
                        Log out
                    </a>
                </MenuItem>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { notify } from 'notiwind'
import { useRouter } from 'vue-router'
import store from '../../store'

let userSurffix = store.state.user.data.name.split('')[0];

function logout() {
    store.dispatch('logout')
        .then((res) => {
            router.push({name: 'Login'});
        })
        .catch((err) => {
            if(err.response) {
                if (err.response.data) {
                    let errMsg;
                    if (err.response.data.hasOwnProperty("message")) {
                        errMsg = err.response.data.message
                    } else {
                        errMsg = err.response.data.error
                    }
                    notify({
                        group: "error",
                        title: "Error",
                        text: errMsg
                    }, 4000)
                }
            }
        })
}
</script>

<style>

</style>