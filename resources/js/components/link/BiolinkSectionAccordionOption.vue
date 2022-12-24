<template>
    <Menu as="div" class="relative flex-shrink-0 ">
        <div>
            <MenuButton class="rounded-full flex items-right 
                focus:outline-none focus:ring-0 focus:ring-offset-2 focus:ring-blue">
                <span class="sr-only">Open user menu</span>
                <div class="items-center flex">
                    <button type="button"
                        class="text-gray-900 font-medium
                        focus:ring-0 focus:ring-blue-300 
                        text-sm px-0 py-2.5 mr-2 capitalize
                        dark:bg-gray-600 dark:hover:bg-gray-700 
                        focus:outline-none dark:focus:ring-gray-800">
                        <font-awesome-icon icon="fa-solid fa-ellipsis-vertical" class="mt-1.5 text-gray-600"/>
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
                mt-2 w-48 bg-white border shadow-lg z-20
                origin-top-right focus:outline-none text-gray-400">
                <!-- <MenuItem v-slot="{active}">
                    <a :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon icon="fa-solid fa-chart-column" class="h-4 w-4 mr-2 mt-0.5" />
                        Statistics
                    </a>
                </MenuItem> -->
                <MenuItem v-slot="{active}">
                    <a @click="updateSectionStatus"
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon icon="fa-solid fa-bell" class="h-4 w-4 mr-2 mt-0.5" />
                        Switch Status
                    </a>
                </MenuItem>
                <MenuItem v-slot="{active}">
                    <a @click="confirmDel"
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon icon="fa-solid fa-trash" class="h-4 w-4 mr-2 mt-0.5" />
                        Delete
                    </a>
                </MenuItem>
            </MenuItems>
        </transition>
    </Menu>
    <ConfirmDelete from="section" :show-delete="showDel" @confirm="deleteSection" @cancel="confirmDel"/>
</template>

<script setup>
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import ConfirmDelete from '../ConfirmDelete.vue';
import biolinksection from '../../store/biolink-section'

const route = useRoute()
const props = defineProps({
    data: Object
})

let showDel = ref(false)

function confirmDel() {
    showDel.value = !showDel.value
}

function updateSectionStatus() {
    biolinksection
        .dispatch('updateSectionStatus', {
            id: props.data.section.id,
            status: props.data.section.status == 1 ? 2 : 1
        })
        .then((res) => {
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
        })
        .catch((err) => {
            let errMsg;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message"))
                        errMsg = err.response.data.message;
                    else
                        errMsg = err.response.data.error;
                }
                errMsg = err;
            }else {
                errMsg = err;
            }
            notify({
                group: "error",
                title: "Error",
                text: errMsg
            }, 4000);
        })
}

function deleteSection() {
    biolinksection
        .dispatch('deleteSection', props.data.id)
        .then((res) => {
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
            showDel.value = false
            biolinksection.dispatch('getSections', route.params.id);
        })
        .catch((err) => {
            let errMsg;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message"))
                        errMsg = err.response.data.message;
                    else
                        errMsg = err.response.data.error;
                }
                errMsg = err;
            }else {
                errMsg = err;
            }
            notify({
                group: "error",
                title: "Error",
                text: errMsg
            }, 4000);
        })
}
</script>

<style>

</style>