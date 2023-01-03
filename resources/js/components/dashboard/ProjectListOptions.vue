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
                <MenuItem v-if="from != 'inner-project'"
                    v-slot="{active}">
                    <a @click="sendInvitationForm" 
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon icon="fa-solid fa-paper-plane" class="h-4 w-4 mr-2 mt-0.5" />
                        Send Invitation
                    </a>
                </MenuItem>
                <MenuItem v-slot="{active}">
                    <router-link :to="{name: 'People', params: {id: data.projectId}}"
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon icon="fa-solid fa-users" class="h-4 w-4 mr-2 mt-0.5" />
                        People
                    </router-link>
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

    <invitation-form :data="model" :show-form="modal.showInvitation" @close-form="sendInvitationForm"/>
    <edit-form :data="model" :show-form="modal.showEdit" @close-form="editProjectForm" />
    <confirm-delete 
        from="project" 
        :is-disabled="modal.isDisabled" 
        :show-delete="modal.showDelete" 
        @confirm="deleteProject" 
        @cancel="closeDeleteModal" />
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { notify } from 'notiwind'
import InvitationForm from './InvitationForm.vue';
import EditForm from './EditForm.vue';
import ConfirmDelete from '../ConfirmDelete.vue';
import project from '../../store/project'

const router = useRouter();
const props = defineProps({
    data: Object,
    from: String
});

let modal = ref({
    showInvitation: false,
    showEdit: false,
    showDelete: false,
    isDisabled: false
})

let model = ref({
    projectId: props.data.projectId,
    name: props.data.name
})

watch(() => props.data, (newVal, oldVal) => {
    if(props.from == 'inner-project') {
        model.value.projectId = newVal.projectId
        model.value.name = newVal.name
    }
}, {deep: true})

function sendInvitationForm() {
    modal.value.showInvitation = !modal.value.showInvitation
}

function editProjectForm() {
    modal.value.showEdit = !modal.value.showEdit
}

function deleteProjectModal() {
    modal.value.showDelete = !modal.value.showDelete;
}

function closeDeleteModal() {
    modal.value.showDelete = false;
}

function deleteProject() {
    modal.value.isDisabled = true;
    project
        .dispatch('deleteProject', model.value.projectId)
        .then((res) => {
            modal.value.isDisabled = false;
            modal.value.showDelete = false;
            if(props.from == 'inner-project')
                router.push({name: 'Dashboard'});
            else
                project.dispatch('getProjects');

            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
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

const listOptions = [
    // {label: 'Send Invitation', icon: 'fa-solid fa-paper-plane', action: sendInvitationForm },
    {label: 'Edit', icon: 'fa-solid fa-pencil', action: editProjectForm},
    {label: 'Delete', icon: 'fa-solid fa-trash', action: deleteProjectModal},
]
</script>

<style>

</style>