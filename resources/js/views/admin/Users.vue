<template>
    <div class="relative overflow-x-auto shadow-md mb-4">
        <div class="p-4">
            <div class="flex justify-between shadow-sm" role="group">
                <button
                    type="button" 
                    @click="addModal" 
                    class="group relative flex justify-center
                    py-2 px-3 border border-transparent
                    text-sm font-medium text-white
                    bg-blue-600 hover:bg-blue-700
                    focus:outline-none">
                    <font-awesome-icon 
                        icon="fa-solid fa-plus"
                        class="mr-2 mt-0.5" />
                    Create User
                </button>
                <div class="relative md:w-1/4 ">
                    <input
                        type="email"
                        v-model="emailSearch"
                        class="border-0 px-3 py-2 placeholder-gray-400 
                        text-gray-700 bg-white text-sm shadow 
                        focus:outline-none focus:ring w-full"
                        placeholder="Search Email"
                        style="transition: all 0.15s ease 0s;"
                        required/>
                </div>
            </div>
        </div>
        <div v-if="isContentSet == 2">
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
                    <tr v-for="item in contents.data" :key="item.id"
                        class="bg-white border-b hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{item.name}}
                        </th>
                        <td class="px-6 py-4">
                            {{item.email}}
                        </td>
                        <td class="px-6 py-4">
                            <!-- role -->
                            {{item.role}}
                        </td>
                        <td class="px-6 py-4">
                            {{item.createdAt}}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex">
                                <!-- edit -->
                                <div>
                                    <button v-if="item.role !='Admin'"
                                        type="button" 
                                        @click="updateModal(item)"
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
                                <div v-if="item.role !='Admin'">
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
    <NoProjectContent v-if="isContentSet == 3" notice="No User Found"/>
    <div v-if="isContentSet == 1" class="w-full py-10">
        <ListLoader/>
    </div>
    <UserCUForm
        :action="setup.action"
        :show="setup.show"
        :data="model"
        @save="saveUser"
        @update="updateUser"
        @cancel="closeModal"
    />
    <ConfirmDelete
        from="User"
        :show-delete="setup.showdel"
        :is-disabled="isDisabled"
        @confirm="deleteUser"
        @cancel="closeModal"
    />
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { notify } from 'notiwind'
import ListLoader from '../../components/ListLoader.vue'
import NoProjectContent from '../../components/NoProjectContent.vue'
import UserCUForm from '../../components/admin/UserCUForm.vue'
import ConfirmDelete from '../../components/ConfirmDelete.vue';
import adminStore from '../../store/admin-store'

const isContentSet = ref(0)
const isDisabled = ref(false)
const contents = computed(() => adminStore.state.users)
const theaders = ['name','email','membership','joined date','actions']

let model = ref({
    id: null,
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
    old_role: '',
})
let setup = ref({
    show: false,
    action: '',
    showdel: false
})
let emailSearch = ref('')

watch(emailSearch, (newVal, oldVal) => {
    setTimeout(() => {
        adminStore.dispatch('getUsers', {url: newVal})
    }, 1500)
})

function getUsers() {
    isContentSet.value = 1
    adminStore
        .dispatch('getUsers')
        .then((res) => {
            if(res.data.length)
                isContentSet.value = 2
            else
                isContentSet.value = 3
        })
        .catch((err) => {
            isContentSet.value = 3;
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

function saveUser(item, item2) {
    adminStore
        .dispatch('storeUser', {
            name: item2[0].value,
            email: item2[1].value,
            password: item2[2].value,
            password_confirmation: item2[3].value,
            role: item.role
        })
        .then((res) => {
            setup.value.show = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
            adminStore.dispatch('getUsers')
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

function updateUser(item, item2) {
    adminStore
        .dispatch('updateUser', {
                id: item.id,
                name: item2[0].value,
                email: item2[1].value,
                password: item2[2].value,
                password_confirmation: item2[3].value,
                new_role: item.role,
                old_role: model.value.old_role,
            })
            .then((res) => {
                setup.value.show = false
                notify({
                    group: "success",
                    title: "Success",
                    text: res.message
                }, 4000)
                adminStore.dispatch('getUsers')
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

function deleteUser() {
    adminStore
        .dispatch('deleteUser', model.value.id)
        .then((res) => {
            setup.value.showdel = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
            adminStore.dispatch('getUsers')
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

function addModal() {
    model.value.id = null
    model.value.name = ''
    model.value.email = ''
    model.value.role = ''
    model.value.old_role = ''
    model.value.password = ''
    model.value.password_confirmation = ''
    setup.value.action = 'create'
    setup.value.show = true
}

function updateModal(item) {
    model.value.id = item.id;
    model.value.name = item.name;
    model.value.email = item.email
    model.value.role = item.role_id
    model.value.old_role = item.role_id
    model.value.password = ''
    model.value.password_confirmation = ''
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
    adminStore.dispatch('getUsers', {url: link.url});
}

onMounted(() => {
    getUsers()
})
</script>

<style>

</style>