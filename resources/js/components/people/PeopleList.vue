<template>
    <div class="relative overflow-x-auto shadow-md mb-4">
        <div class="p-4">
            <div class="flex justify-between shadow-sm" role="group">
                <h1 class="font-bold text-gray-800">Team Members</h1>
                <button type="button"
                    @click="sendInvitationForm"
                    class="group relative flex justify-center
                    py-2 px-3 border border-transparent
                    text-sm font-medium text-white
                    bg-blue-600 hover:bg-blue-700
                    focus:outline-none">
                    <font-awesome-icon 
                        icon="fa-solid fa-paper-plane"
                        class="h-4 w-4 mr-2 mt-0.5" />
                    Send Invitation
                </button>
            </div>
        </div>
        <div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-sm text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th v-for="theader in theaders" :key="theader" 
                            scope="col" class="px-6 py-3">
                            {{theader}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in model.data" :key="item.id"
                        class="bg-white border-b hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{item.email}}
                        </th>
                        <td class="px-6 py-4">
                            {{item.name}}
                        </td>
                        <td class="px-6 py-4 capitalize">
                            <!-- role -->
                            {{item.role}}
                        </td>
                        <td class="px-6 py-4 capitalize">
                            <div v-if="item.role != 'owner'">
                                <button 
                                    type="button" 
                                    @click="deleteModal(item)"
                                    class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                    focus:outline-none focus:ring-gray-100
                                    font-medium text-sm px-5 py-2.5 text-center 
                                    inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                    <font-awesome-icon 
                                        icon="fa-solid fa-trash"
                                        class="" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <invitation-form :data="model" :show-form="modal.showInvitation" @close-form="sendInvitationForm"/>
    <ConfirmDelete
        from="Member"
        :show-delete="setup.showdel"
        :is-disabled="isDisabled"
        @confirm="removeMember"
        @cancel="closeModal"
    />
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from 'notiwind'
import InvitationForm from '../dashboard/InvitationForm.vue';
import ConfirmDelete from '../ConfirmDelete.vue';
import project from '../../store/project';

const route = useRoute()
const props = defineProps({
    data: Array,
    theaders: Array,
    projectInfo: Object
})

let isDisabled = ref(false)
let model = ref({
    projectId: props.projectInfo.projectId,
    name: props.projectInfo.name,
    data: props.data,
    memberUserId: null,
});
let modal = ref({
    showInvitation: false
});
let setup = ref({
    showdel: false
});

watch(() => props.data, (newVal, oldVal) => {
    model.value.data = newVal
});

function sendInvitationForm() {
    modal.value.showInvitation = !modal.value.showInvitation
};

function deleteModal(item) {
    model.value.memberUserId = item.memberUserId;
    setup.value.showdel = true
}

function closeModal() {
    setup.value.showdel = false
}

function removeMember() {
    isDisabled.value = true
    project
        .dispatch('deleteProjectMember', {
            projectId: route.params.id,
            memberUserId: model.value.memberUserId
        })
        .then((res) => {
            setup.value.showdel = false
            isDisabled.value = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
            project.dispatch('getProjectTeam', route.params.id)
        })
        .catch((err) => {
            isDisabled.value = false
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