<template>
    <div class="md:mt-16 mb-10">
        <div class="md:flex justify-between">
            <h5 class="text-2xl font-bold 
                tracking-tight text-gray-700 
                dark:text-white capitalize w-full">
                Leads
            </h5>
            <!-- Calendar filter -->
            <Datepicker 
                v-model="datePicker"
                class="border border-gray-300 
                text-gray-900 text-sm rounded-lg
                focus:ring-0 focus:border-blue-500 
                block w-full" range />
        </div>
        <div class="mt-4">
            <router-link :to="{name: 'Dashboard'}"
                class="text-white bg-gray-700 hover:bg-gray-800 
                focus:ring-0 focus:ring-gray-300 font-medium 
                text-sm px-5 py-2.5 mr-2 mb-2 capitalize
                dark:bg-gray-600 dark:hover:bg-gray-700
                focus:outline-none dark:focus:ring-gray-800">
                <font-awesome-icon icon="fa-solid fa-list" />
                Last activity
            </router-link>
            <button type="button"
                class="text-white bg-gray-700 hover:bg-gray-800 
                focus:ring-0 focus:ring-gray-300 font-medium 
                text-sm px-5 py-2.5 mr-2 mb-2 capitalize
                dark:bg-gray-600 dark:hover:bg-gray-700
                focus:outline-none dark:focus:ring-gray-800">
                <font-awesome-icon icon="fa-solid fa-file-csv" />
                Export CSV
            </button>
        </div>
        <div class="relative overflow-x-auto shadow-md mt-6">
            <div v-if="leads.data.length">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <td class="p-4">
                                <input 
                                id="checkbox-all-keyword" 
                                type="checkbox"
                                v-model="checkboxAllKeyword"
                                class="w-4 h-4 text-blue-600 bg-white
                                border-gray-300 rounded dark:bg-gray-700 
                                dark:border-gray-600">
                            </td>
                            <th v-for="theader in theaders" :key="theader" 
                                scope="col" class="px-6 py-3">
                                {{theader}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in leads.data" :key="item.id"
                            class="bg-white border-b hover:bg-gray-50 text-sm">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" :value="word" v-model="checkedKeywordToAdd" 
                                    :id="'id-'+item.id"
                                    class="w-4 h-4 text-blue-600 bg-gray-100
                                    border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{item.email}}
                            </td>
                            <td class="px-6 py-4">
                                {{item.name}}
                            </td>
                            <td class="px-6 py-4">
                                {{item.phone}}
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
                        <a v-for="(link, i) of leads.meta.links" 
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
                                i === leads.meta.links.length - 1 ? 'rounded-r-md' : '',
                            ]"
                            v-html="link.label">
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import reportStore from '../../store/report-store';

const route = useRoute()
const leads = computed(() => reportStore.state.leads)
const theaders = ['email','name','phone','date created']
const today = new Date()
const priorDate = new Date(new Date().setDate(today.getDate() - 30))

let datePicker = ref([dformat(priorDate), dformat(today)])
let checkboxAllKeyword = ref(false);
let checkedKeywordToAdd = ref([]);
let tmpKeywordList = ref({data: []});

watch(datePicker, (newVal, oldVal) => {
    reportStore.dispatch('getLeadsReport', {
        id: route.params.id, 
        from: dformat(newVal[0]),
        to: dformat(newVal[1])
    })
}, {deep:true})

function dformat(date) {
    let d = new Date(date);
    const day = d.getDate() <= 9 == 1 ? `0${d.getDate()}` : d.getDate();
    const month = d.getMonth()+1  <= 9 == 1 ? `0${d.getMonth()+1}` : d.getMonth()+1;
    const year = d.getFullYear();
    const time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    return `${year}-${month}-${day}`;
}

const getForPage = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    reportStore.dispatch('getLeadsReportPag', {url: link.url});
}

onMounted(() => {
    reportStore.dispatch('getLeadsReport', {
        id: route.params.id, 
        from: datePicker.value[0],
        to: datePicker.value[1]
    })
})
</script>

<style>

</style>