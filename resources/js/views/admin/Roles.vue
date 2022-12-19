<template>
    <div class="md:px-12 pt-10">
        <div class="relative overflow-x-auto shadow-md">
            <div class="p-4">
                <div class="inline-flex shadow-sm mb-3" role="group">
                    <button type="button" @click="addModal" 
                        class="group relative flex justify-center
                        py-2 px-3 border border-transparent
                        text-sm font-medium text-white 
                        bg-blue-600 hover:bg-blue-700
                        focus:outline-none gap-1">
                        <font-awesome-icon 
                        icon="fa-solid fa-plus"
                        class="mt-0.5" />
                        Create Role
                    </button>
                </div>
            </div>
            <div v-if="contents.data.length">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th v-for="theader in theaders" :key="theader" 
                                scope="col" class="px-6 py-3">
                                {{theader}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in contents.data" :key="item.id" class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{item.name}}
                            </th>
                            <td class="px-6 py-4">
                                <div class="flex" >
                                    <!-- Assign permissions -->
                                    <div >
                                        <button type="button" @click="assignPermissionsModal(item)"
                                            class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                            focus:outline-none focus:ring-gray-100
                                            font-medium text-sm px-5 py-2 text-center 
                                            inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                            Assign Permissions
                                        </button>
                                    </div>
                                    <!-- edit -->
                                    <div >
                                        <button type="button" @click="updateModal(item)"
                                            class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                            focus:outline-none focus:ring-gray-100 
                                            font-medium text-sm px-5 py-2.5 text-center 
                                            inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                            <font-awesome-icon 
                                                icon="fa-solid fa-pen-to-square"
                                                class="" />
                                        </button>
                                    </div>
                                    <!-- delete -->
                                    <div >
                                        <button type="button" @click="deleteModal(item)"
                                            class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                                            focus:outline-none focus:ring-gray-100 
                                            font-medium text-sm px-5 py-2.5 text-center 
                                            inline-flex items-center dark:focus:ring-gray-500 mr-2">
                                            <font-awesome-icon 
                                                icon="fa-solid fa-trash"
                                                class="" />
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="flex justify-center mt-5 mb-5">
                    <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm"
                        aria-label="Pagination">
                        <a v-for="(link, i) of contents.meta.links" 
                            :key="i"
                            :disabled="!link.url"
                            href="#"
                            @click="getForPage($event,link)"
                            aria-current="page"
                            class="relative inline-flex items-center px-4 py-2 border text-sm
                            font-medium whitespace-nowrap"
                            :class="[
                                link.active 
                                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' 
                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                i === 0 ? 'rounded-l-md' : '',
                                i === contents.meta.links.length - 1 ? 'rounded-r-md' : '',
                            ]"
                            v-html="link.label">
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div v-if="!contents.data.length">
        <NoProjectContent/>
    </div>
    <div v-if="isContentSet == 1" class="flex justify-center py-20">
        <ListLoader/>
    </div>
    <PermitOrRoleCU
        type="Role"
        :action="setup.action"
        :show="setup.show"
        :data="model"
        @save="saveSub"
        @update="updateSub"
        @cancel="closeModal"
    />
    <ConfirmDelete
        from="Role"
        :show-delete="setup.showdel"
        :is-disabled="isDisabled"
        @confirm="deleteSub"
        @cancel="closeModal"
    />
    <TransitionRoot as="template" :show="openPermitRole">
        <Dialog as="div" class="relative z-20" @close="openPermitRole = false">
            <TransitionChild as="template" 
                enter="ease-out duration-300" 
                enter-from="opacity-0" 
                enter-to="opacity-100" 
                leave="ease-in duration-200" 
                leave-from="opacity-100" 
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <TransitionChild as="template" 
                        enter="ease-out duration-300" 
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                        enter-to="opacity-100 translate-y-0 sm:scale-100" 
                        leave="ease-in duration-200" 
                        leave-from="opacity-100 translate-y-0 sm:scale-100" 
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl 
                            transform transition-all sm:my-8 sm:max-w-2xl w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-0 sm:text-left">
                                        <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> 
                                            Permissions for {{model.name}} 
                                        </DialogTitle>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div v-if="permissionsCheck == 1" class="flex justify-center py-20">
                                        <!-- spinner state -->
                                        <RoundLoader />
                                    </div>
                                    <!-- no data view -->
                                    <div v-if="permissionsCheck == 3">
                                        <NoProjectContent/>
                                    </div>
                                    <div v-if="permissionsCheck == 2">
                                        <!-- Menu -->
                                        <h3 class="mb-3 mt-4 text-sm text-gray-500 
                                            uppercase tracking-widest">
                                            menus
                                        </h3>
                                        <div class="grid md:grid-cols-3 md:gap-3 mt-6">
                                            <div v-for="permit in rolePermissions.menu" :key="permit.id">
                                                <div class="flex items-center mb-2">
                                                    <input :id="permit.name" type="checkbox" 
                                                        :value="permit.id"
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 rounded 
                                                        border-gray-300 focus:ring-blue-500 
                                                        dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                                        focus:ring-2 dark:bg-gray-700 dark:border-gray-600 permit-name"
                                                        :checked="permit.role_id !== null ? true : false">
                                                    <label :for="permit.name" 
                                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{permit.name}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- User -->
                                        <!-- <div>
                                            <h3 class="mb-3 mt-4 text-sm text-gray-500 
                                                uppercase tracking-widest">
                                                user
                                            </h3>
                                            <div class="grid md:grid-cols-4 md:gap-3 mt-6">
                                                <div v-for="permit in rolePermissions.user" :key="permit.id">
                                                    <div class="flex items-center mb-2">
                                                        <input :id="permit.name" type="checkbox" 
                                                            :value="permit.id"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded 
                                                            border-gray-300 focus:ring-blue-500 
                                                            dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                                            focus:ring-2 dark:bg-gray-700 dark:border-gray-600 permit-name"
                                                            :checked="permit.role_id !== null ? true : false">
                                                        <label :for="permit.name" 
                                                            class="ml-2 text-sm font-medium text-gray-900">
                                                            {{permit.name}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- Role -->
                                        <!-- <div>
                                            <h3 class="mb-3 mt-4 text-sm text-gray-500 
                                                uppercase tracking-widest">
                                                role
                                            </h3>
                                            <div class="grid md:grid-cols-4 md:gap-3 mt-6">
                                                <div v-for="permit in rolePermissions.role" :key="permit.id">
                                                    <div class="flex items-center mb-2">
                                                        <input :id="permit.name" type="checkbox" 
                                                            :value="permit.id"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded 
                                                            border-gray-300 focus:ring-blue-500 
                                                            dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                                            focus:ring-2 dark:bg-gray-700 dark:border-gray-600 permit-name"
                                                            :checked="permit.role_id !== null ? true : false">
                                                        <label :for="permit.name" 
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{permit.name}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" 
                                    class="group relative w-full inline-flex justify-center border 
                                    border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base 
                                    font-medium text-white hover:bg-indigo-700 sm:ml-3 
                                    sm:w-auto sm:text-sm"
                                    :class="[
                                        isDisabled == true
                                        ? 'pr-10' : ''
                                    ]"
                                    @click="assignPermissions"
                                    :disabled="isDisabled">
                                    Assign
                                    <span class="absolute right-0 inset-y-0 flex items-center ">
                                        <ButtonSpinner v-if="isDisabled == true" />
                                    </span>
                                </button>
                                <button type="button"
                                    class="mt-3 w-full inline-flex justify-center 
                                    border border-gray-300 shadow-sm px-4 py-2 bg-white text-base 
                                    font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 
                                    sm:ml-3 sm:w-auto sm:text-sm" 
                                    @click="openPermitRole = false" ref="cancelButtonRef">Cancel
                                </button>
                                <span class="mr-3">{{modelPermits.message}}</span>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router';
import { notify } from 'notiwind'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import ListLoader from '../../components/ListLoader.vue'
import RoundLoader from '../../components/RoundLoader.vue'
import ButtonSpinner from '../../components/ButtonSpinner.vue'
import NoProjectContent from '../../components/NoProjectContent.vue'
import ConfirmDelete from '../../components/ConfirmDelete.vue';
import PermitOrRoleCU from '../../components/admin/PermitOrRoleCU.vue';
import adminStore from '../../store/admin-store'
import store from '../../store'
import helpers from '../../helpers'

const contents = computed(() => adminStore.state.authGuard)
const permissions = computed(() => store.state.user.permissions)
const router = useRouter()
const theaders = ['name', 'action']
const isContentSet = ref(0)
const openPermitRole = ref(false)
const isDisabled = ref(false)
const rolePermissions = ref({
    menu: [],
    user: [],
    role: []
})

let model = ref({
    id: null,
    name: '',
});
let setup = ref({
    show: false,
    action: '',
    showdel: false
});
let modelPermits = ref({
    assignedPermits: [],
    unAssignedPermits: [],
    message: ''
});
let permissionsCheck = ref(0);

function saveSub(item) {
    adminStore
        .dispatch('storeRole', {
            name: item.name
        })
        .then((res) => {
            setup.value.show = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
            adminStore.dispatch('getRoles')
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

function updateSub(item) {
    adminStore
        .dispatch('updateRole', {
            id: item.id,
            name: item.name,
        })
        .then((res) => {
            setup.value.show = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
            adminStore.dispatch('getRoles')
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

function deleteSub() {
    adminStore
        .dispatch('deleteRole', model.value.id)
        .then((res) => {
            setup.value.showdel = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
            adminStore.dispatch('getRoles')
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

async function getRolePermissions() {
    permissionsCheck.value = 1;
    await adminStore
        .dispatch('getRolePermissions', model.value.id)
        .then((res) => {
            permissionsCheck.value = 2;
            rolePermissions.value.menu = res.data.menus;
            rolePermissions.value.user = res.data.user;
            rolePermissions.value.role = res.data.role;
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

function assignPermissions() {
    modelPermits.value.assignedPermits = []; 
    modelPermits.value.unAssignedPermits = [];
    let permits = document.getElementsByClassName('permit-name');

    for(let p of permits) {
        if(p.checked) {
            modelPermits.value.assignedPermits.push(p.value)
        }else{
            modelPermits.value.unAssignedPermits.push(p.value)
        }
    }
    
    if(modelPermits.value.assignedPermits.length > 0) {
        isDisabled.value = true
        adminStore
            .dispatch('assignPermissionsToRole', {
                permissions: modelPermits.value.assignedPermits,
                unpermit: modelPermits.value.unAssignedPermits,
                roleId: model.value.id
            })
            .then((res) => {
                isDisabled.value = false
                openPermitRole.value = false;
                notify({
                    group: "success",
                    title: "Success",
                    text: res.message
                }, 4000)
                modelPermits.value.message = res.message;
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
    }else {
        modelPermits.value.message = 'Please select atleast one permission.';
    }
}

function assignPermissionsModal(item) {
    model.value.id = item.id;
    model.value.name = item.name;
    modelPermits.value.message = ''
    openPermitRole.value = true;
    getRolePermissions()
}
function addModal() {
    model.value.id = null;
    model.value.name = '';
    setup.value.action = 'create'
    setup.value.show = true
}
function updateModal(item) {
    model.value.id = item.id;
    model.value.name = item.name;
    setup.value.action = 'update'
    setup.value.show = true
}
function deleteModal(item) {
    model.value.id = item.id;
    model.value.name = item.name;
    setup.value.showdel = true
}
function closeModal() {
    setup.value.show = false
    setup.value.showdel = false
}

const getForPage = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    adminStore.dispatch('getRoles', {url: link.url});
}

onMounted(() => {
    helpers.getRoles()
})
</script>

<style>

</style>