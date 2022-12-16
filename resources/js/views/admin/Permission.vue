<template>
    <div class="relative overflow-x-auto shadow-md">
        <div class="p-4">
            <div class="inline-flex rounded-md shadow-sm mb-3" role="group">
                <button type="button" @click="addModal" 
                    class="group relative flex justify-center
                    py-2 px-3 border border-transparent
                    text-sm font-medium text-white
                    bg-indigo-600 hover:bg-indigo-700
                    focus:outline-none gap-1">
                    <font-awesome-icon 
                        icon="fa-solid fa-plus"
                        class="mt-0.5" />
                    Create Permission
                </button>
            </div>
        </div>
        <div v-if="isContentSet == 2">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 
                    dark:bg-gray-700 dark:text-gray-400">
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
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 
                            dark:text-white whitespace-nowrap">
                            {{item.name}}
                        </th>
                        <td class="px-6 py-4">
                            <div class="flex">
                                <!-- edit -->
                                <div class="">
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
                                <div class="">
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
    <div v-if="isContentSet == 3">
        <NoProjectContent />
    </div>
    <div v-if="isContentSet == 1" class="flex justify-center py-20">
        <ListLoader />
    </div>
    <PermitOrRoleCU
        type="Permission"
        :action="setup.action"
        :show="setup.show"
        :data="model"
        @save="savePermission"
        @update="updatePermission"
        @cancel="closeModal"
    />
    <ConfirmDelete
        from="Permission"
        :show-delete="setup.showdel"
        @confirm="deletePermission"
        @cancel="closeModal"
    />
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router';
import { notify } from 'notiwind'
import ListLoader from '../../components/ListLoader.vue'
import NoProjectContent from '../../components/NoProjectContent.vue'
import ConfirmDelete from '../../components/ConfirmDelete.vue';
import PermitOrRoleCU from '../../components/admin/PermitOrRoleCU.vue';
import adminStore from '../../store/admin-store'

const contents = computed(() => adminStore.state.authGuard)
const router = useRouter()
const theaders = ['name', 'actions']
const isContentSet = ref(0)

let model = ref({
    id: null,
    name: '',
    type: 'menu'
});
let setup = ref({
    show: false,
    action: '',
    showdel: false
})

function getPermissions() {
    isContentSet.value = 1
    adminStore
        .dispatch('getPermissions')
        .then((res) => {
            if(res.data.length)
                isContentSet.value = 2;
            else
                isContentSet.value = 3;
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

function savePermission(item) {
    adminStore
        .dispatch('storePermission', {
            name: item.name,
            type: item.type
        })
        .then((res) => {
            setup.value.show = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
            adminStore.dispatch('getPermissions')
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

function updatePermission(item) {
    adminStore
        .dispatch('updatePermission', {
            id: item.id,
            name: item.name,
            type: item.type
        })
        .then((res) => {
            setup.value.show = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
            adminStore.dispatch('getPermissions')
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

function deletePermission() {
    adminStore
        .dispatch('deletePermission', model.value.id)
        .then((res) => {
            setup.value.showdel = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
            adminStore.dispatch('getPermissions')
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

function addModal() {
    model.value.id = null;
    model.value.name = '';
    model.value.type = 'menu'
    setup.value.action = 'create'
    setup.value.show = true
}

function updateModal(item) {
    model.value.id = item.id;
    model.value.name = item.name;
    model.value.type = item.type
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
    adminStore.dispatch('getPermissions', {url: link.url});
}

onMounted(() => {
    getPermissions();
})
</script>

<style>

</style>