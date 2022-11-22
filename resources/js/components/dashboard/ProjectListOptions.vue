<template>
    <Menu as="div" class="relative flex-shrink-0 z-10">
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
                mt-2 w-48 bg-white border shadow-lg 
                origin-top-right focus:outline-none text-gray-400">
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

    <invitation-form :show-form="modal.showInvitation" @close-form="sendInvitationForm"/>
    <edit-form :data="model" :show-form="modal.showEdit" @close-form="editProjectForm" />
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { notify } from 'notiwind'
import { useRouter } from 'vue-router'
import InvitationForm from './InvitationForm.vue';
import EditForm from './EditForm.vue';
import project from '../../store/project'

const props = defineProps({
    data: Object
});

let modal = ref({
    showInvitation: false,
    showEdit: false,
    showDelete: false
})

let model = ref({
    projectId: props.data.projectId,
    name: props.data.name
})

function sendInvitationForm() {
    modal.value.showInvitation = !modal.value.showInvitation
}

function editProjectForm() {
    modal.value.showEdit = !modal.value.showEdit
}

function deleteProjectForm() {

}

const listOptions = [
    {label: 'Send Invitation', icon: 'fa-solid fa-paper-plane', action: sendInvitationForm },
    {label: 'Edit', icon: 'fa-solid fa-pencil', action: editProjectForm},
    {label: 'Delete', icon: 'fa-solid fa-trash', action: deleteProjectForm},
]
</script>

<style>

</style>