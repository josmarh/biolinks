<template>
    <Menu as="div" class="relative flex-shrink-0 ">
        <div>
            <MenuButton class="rounded-full flex items-right 
                focus:outline-none focus:ring-0 focus:ring-offset-2 focus:ring-blue">
                <span class="sr-only">Open user menu</span>
                <div class="items-center flex">
                    <button type="button" 
                        class="text-white bg-blue-700 hover:bg-blue-800 
                        focus:ring-0 focus:ring-blue-300 font-medium 
                        text-sm px-5 py-2.5 mr-2 capitalize
                        dark:bg-blue-600 dark:hover:bg-blue-700 
                        focus:outline-none dark:focus:ring-blue-800">
                        <font-awesome-icon icon="fa-solid fa-plus" />
                        Create
                    </button>
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
                mt-2 w-48 bg-white border shadow-lg z-10
                origin-top-right focus:outline-none text-gray-400">
                <MenuItem v-for="(item, i) in listOptions" :key="i"
                    v-slot="{active}">
                    <a @click="item.action" 
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon :icon="item.icon" class="h-4 w-4 mr-2 mt-0.5"
                        :class="[item.label == 'Biolink' ? 'text-blue-600' : 'text-green-600']" />
                        {{item.label}}
                    </a>
                </MenuItem>
            </MenuItems>
        </transition>
    </Menu>

    <BiolinkForm :show-form="modal.showBiolinkForm" @close-form="biolinkForm" />
    <LinkForm :show-form="modal.showLinkForm" @close-form="linkForm" />
</template>

<script setup>
import { ref } from 'vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import BiolinkForm from './BiolinkForm.vue';
import LinkForm from './LinkForm.vue';

let modal = ref({
    showBiolinkForm: false,
    showLinkForm: false,
    isDisabled: false
})

function biolinkForm() {
    modal.value.showBiolinkForm = !modal.value.showBiolinkForm
}

function linkForm() {
    modal.value.showLinkForm = !modal.value.showLinkForm
}

const listOptions = [
    {label: 'Biolink', icon: 'fa-solid fa-circle-dot', action: biolinkForm},
    {label: 'Link', icon: 'fa-solid fa-circle-dot', action: linkForm},
]
</script>

<style>

</style>