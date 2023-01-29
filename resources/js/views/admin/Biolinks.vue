<template>
    <div>
        <div class="p-4">
            <div class="flex gap-4 justify-end shadow-sm" role="group">
                <div class="relative md:w-1/4 ">
                    <input
                    type="text"
                    v-model="filter.linkId"
                    class="border-0 px-3 py-2.5 placeholder-gray-400 
                    text-gray-700 bg-white text-sm shadow 
                    focus:outline-none focus:ring w-full"
                    placeholder="Search Link ID"
                    style="transition: all 0.15s ease 0s;"
                    />
                </div>
                <div>
                    <select id="type" 
                        v-model="filter.type"
                        class="bg-gray-50 border 
                        border-gray-300 text-gray-900 
                        text-sm focus:ring-blue-700 
                        focus:border-blue-500 block 
                        xl:w-48 w-full py-2.5 px-6">
                        <option value="">All</option>
                        <option value="biolink">Biolink</option>
                        <option value="link">Link</option>
                    </select>
                </div>
            </div>
        </div>
        <div v-if="isContentSet == 2">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th v-for="theader in theaders" :key="theader" 
                            scope="col" class="px-6 py-3 text-center">
                            {{theader}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in projectlinks.data" :key="item.id"
                    class="bg-white border-b hover:bg-gray-50 text-center">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{item.linkId}}
                        </th>
                        <td class="px-6 py-4">
                            {{item.type}}
                        </td>
                        <td class="px-6 py-4">
                            {{item.status}}
                        </td>
                        <td class="px-6 py-4">
                            {{item.associateProject ? item.associateProject.name : ''}}
                        </td>
                        <td class="px-6 py-4">
                            {{item.createdAt}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="flex justify-center mt-5 mb-5">
                <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm"
                    aria-label="Pagination">
                    <a v-for="(link, i) of projectlinks.meta.links" 
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
                            i === projectlinks.meta.links.length - 1 ? 'rounded-r-md' : '',
                        ]"
                        v-html="link.label">
                    </a>
                </nav>
            </div>
        </div>
    </div>
    <NoProjectContent v-if="isContentSet == 3" notice="No Content Found"/>
    <div v-if="isContentSet == 1" class="w-full py-10">
        <ListLoader/>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { notify } from 'notiwind';
import ListLoader from '../../components/ListLoader.vue'
import NoProjectContent from '../../components/NoProjectContent.vue'
import adminStore from '../../store/admin-store';

const projectlinks = computed(() => adminStore.state.projects)
const theaders = ['link ID','type','status','associate project','created date'];
const isContentSet = ref(0)

let filter = ref({
    type: '',
    linkId: ''
})

watch(filter, (newVal, oldVal) => {
    setTimeout(() => {
        adminStore.dispatch('getProjectLinks', {type: filter.value.type, linkId: filter.value.linkId})
    }, 1500)
}, {deep: true})

function getProjectLinks() {
    isContentSet.value = 1
    adminStore
        .dispatch('getProjectLinks')
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
                    let errMasg;
                    if (err.response.data.hasOwnProperty("message")) {
                        errMasg = err.response.data.message
                    } else {
                        errMasg = err.response.data.error
                    }
                    notify({
                        group: "error",
                        title: "Error",
                        text: errMasg
                    }, 4000)
                }
            }
        })
}

const getForPage = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    adminStore.dispatch('getProjectLinks', link.url);
}

onMounted(() => {
    getProjectLinks();
})
</script>

<style>

</style>