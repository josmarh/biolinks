<template>
    <Menu as="div" class="relative flex-shrink-0 z-10">
        <div>
            <MenuButton class="rounded-full flex items-right 
                focus:outline-none focus:ring-0 focus:ring-offset-2 focus:ring-blue">
                <span class="sr-only">Open user menu</span>
                <div class="block py-2 pl-3 pr-4 md:p-0 dark:text-white">
                    Products
                    <font-awesome-icon icon="fa-solid fa-chevron-down" class="ml-1" />
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
                <div v-for="(item, i) in productNav" :key="i">
                    <MenuItem v-slot="{active}">
                        <router-link :to="{name: item.to.name}"
                            :class="{'bg-gray-100': active}" 
                            class="block py-2 px-4 text-sm text-gray-700 
                            cursor-pointer inline-flex w-full">
                            {{ item.label }}
                        </router-link>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';

const route = useRoute();
const productNav = [
    {label: 'Simple Products', to: {name: 'ProductSimple', params: {project_id: route.params.id}}},
    {label: 'Coupon Codes', to: {name: 'ProductCouponCode', params: {project_id: route.params.id}}},
    {label: 'Categories', to: {name: 'ProductCategory', params: {project_id: route.params.id}}},
]
</script>

<style>

</style>