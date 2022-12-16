<template>
    <div>
        <div class="p-4">
            <div class="flex justify-end shadow-sm" role="group">
                <div class="relative md:w-1/4 ">
                    <input
                    type="email"
                    v-model="emailSearch"
                    class="border-0 px-3 py-2 placeholder-gray-400 
                    text-gray-700 bg-white text-sm shadow 
                    focus:outline-none focus:ring w-full"
                    placeholder="Search Email"
                    style="transition: all 0.15s ease 0s;"
                    />
                </div>
            </div>
        </div>
        <div v-if="isContentSet == 2">
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
                    <tr v-for="item in logs.data" :key="item.id"
                    class="bg-white border-b hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{item.email}}
                        </th>
                        <td class="px-6 py-4">
                            <!-- role -->
                            {{item.ip}}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"
                                :class="[item.status == 'success' 
                                ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900'
                                : 'bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900']">
                                {{item.status}}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <!-- role -->
                            {{item.description}}
                        </td>
                        <td class="px-6 py-4">
                            <!-- role -->
                            {{item.date}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="flex justify-center mt-5 mb-5">
                <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm"
                    aria-label="Pagination">
                    <a v-for="(link, i) of logs.meta.links" 
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
                            i === logs.meta.links.length - 1 ? 'rounded-r-md' : '',
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

const logs = computed(() => adminStore.state.logs)
const theaders = ['email','IP','status','description','date'];
const emailSearch = ref('')
const isContentSet = ref(0)

watch(emailSearch, (newVal, oldVal) => {
    setTimeout(() => {
        adminStore.dispatch('getLoginHistory', {url: newVal})
    }, 1500)
})

function getLoginHistory() {
    isContentSet.value = 1
    adminStore
        .dispatch('getLoginHistory')
        .then((res) => {
            if(res.data.length)
                isContentSet.value = 2
            else
                isContentSet.value = 3
        })
        .catch((err) => {
            isContentSet.value = 3
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
    adminStore.dispatch('getLoginHistory',{url: link.url});
}

onMounted(() => {
    getLoginHistory();
})
</script>

<style>

</style>