<template>
    <Menu as="div" class="relative flex-shrink-0 z-10">
        <div>
            <MenuButton class="rounded-full flex items-right 
                focus:outline-none focus:ring-0 focus:ring-offset-2 focus:ring-blue">
                <span class="sr-only">Open user menu</span>
                <div class="block py-2 pl-3 pr-4 md:p-0 dark:text-white">
                    <font-awesome-icon icon="fa-solid fa-ellipsis" class="ml-1" />
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
                <div v-for="(item, i) in productNav" :key="i">
                    <MenuItem v-slot="{active}">
                        <a href="#" @click="item.action($event)"
                            :class="{'bg-gray-100': active}" 
                            class="block py-2 px-4 text-sm text-gray-700 
                            cursor-pointer inline-flex w-full">
                            <font-awesome-icon :icon="item.icon" class="mr-2 mt-0.5" />
                            {{ item.label }}
                        </a>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { notify } from 'notiwind';
import productStore from '../../store/product-store'

const props = defineProps({
    data: Object
})
const route = useRoute();
const router = useRouter();
const productNav = [
    {
        label: 'Edit', 
        icon: 'fa-solid fa-pencil',
        action: edit
    },
    {
        label: 'Duplicate', 
        icon: 'fa-solid fa-copy',
        action: duplicate
    },
    {
        label: 'Delete', 
        icon: 'fa-solid fa-trash',
        action: destroy
    }
]

function edit(ev) {
    ev.preventDefault();
    router.push({
        name: 'NewProduct',
        params: {id: route.params.id},
        query: {pid: props.data.id}
    })
}

function duplicate(ev) {
    ev.preventDefault();
    productStore
        .dispatch('duplicateProduct', props.data.id)
        .then((res) => {
            productStore.dispatch('getProducts', route.params.id)
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
            }else{
                errMsg = err;
            }
            notify({
                group: "error",
                title: "Error",
                text: errMsg
            }, 4000);
        })
}

function destroy(ev) {
    ev.preventDefault();
    productStore
        .dispatch('deleteProduct', props.data.id)
        .then((res) => {
            productStore.dispatch('getProducts', route.params.id)
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
            }else{
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