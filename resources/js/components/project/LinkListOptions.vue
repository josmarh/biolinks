<template>
    <Menu as="div" class="relative flex-shrink-0 ">
        <div>
            <MenuButton class="rounded-full flex items-right 
                focus:outline-none focus:ring-0 focus:ring-offset-2 focus:ring-blue">
                <span class="sr-only">Open user menu</span>
                <div class="items-center flex">
                    <font-awesome-icon icon="fa-solid fa-ellipsis-vertical" />
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
                <MenuItem v-if="from === 'link-list'"
                    v-slot="{active}">
                    <a @click="duplicateLink" 
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon icon="fa-solid fa-copy" class="h-4 w-4 mr-2 mt-0.5" />
                        Duplicate
                    </a>
                </MenuItem>
                <MenuItem v-for="(item, i) in listOptions" :key="i"
                    v-slot="{active}">
                    <a @click="item.action" 
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon :icon="item.icon" class="h-4 w-4 mr-2 mt-0.5" />
                        {{item.label}}
                    </a>
                </MenuItem>
            </MenuItems>
        </transition>
    </Menu>

    <confirm-delete 
        from="Link"
        :is-disabled="modal.isDisabled" 
        :show-delete="modal.showDelete"
        @confirm="deleteLink" 
        @cancel="closeDeleteModal" />
</template>

<script setup>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import ConfirmDelete from '../ConfirmDelete.vue';
import projectlinks from '../../store/projectlinks';

const route = useRoute();
const router = useRouter();
const props = defineProps({
    data: Object,
    from: String
});

let modal = ref({
    showDelete: false,
    isDisabled: false
})

function editLinkPage() {
    router.push({name: 'Link', params: {id: props.data.id}})
}

function duplicateLink() {
    projectlinks.dispatch('duplicateLink', props.data.id);
    setTimeout(() => {
        projectlinks.dispatch('getLinks', route.params.id);
    }, 1200);
}

function getLinkStatistics() {

}

function getLinkQrcode() {
    let applink = `${window.location.protocol}//${window.location.host}`;

    window.open(`${applink}/${props.data.linkId}/qr`);
}

function deleteLink() {
    modal.value.isDisabled = true;
    projectlinks
        .dispatch('deleteLink', props.data.id)
        .then((res) => {
            modal.value.isDisabled = false;
            modal.value.showDelete = false;

            if(props.from == 'link-list')
                projectlinks.dispatch('getLinks', route.params.id)
            else
                router.push({name: 'Project', params: {id: props.data.projectId}})
        })
        .catch((err) => {
            modal.value.isDisabled = false;
            modal.value.showDelete = false;

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

function deleteLinkModal() {
    modal.value.showDelete = !modal.value.showDelete;
}

function closeDeleteModal() {
    modal.value.showDelete = false;
}

const listOptions = [
    {label: 'Edit', icon: 'fa-solid fa-pencil', action: editLinkPage},
    // {label: 'Duplicate', icon: 'fa-solid fa-copy', action: duplicateLink },
    {label: 'Statistics', icon: 'fa-solid fa-chart-column', action: getLinkStatistics },
    {label: 'QR Code', icon: 'fa-solid fa-qrcode', action: getLinkQrcode },
    {label: 'Delete', icon: 'fa-solid fa-trash', action: deleteLinkModal},
]
</script>

<style>

</style>