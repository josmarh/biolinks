<template>
    <div class="relative overflow-x-auto shadow-md mb-4 mt-6">
        <div class="p-4">
            <div class="flex justify-between shadow-sm" role="group">
                <h1 class="font-bold text-gray-800">Customers & Leads</h1>
                <button type="button"
                    @click="exportLeads"
                    class="group relative flex justify-center
                    py-2 px-3 border border-transparent
                    text-sm font-medium text-white
                    bg-blue-600 hover:bg-blue-700
                    focus:outline-none gap-2">
                    <font-awesome-icon icon="fa-solid fa-file-csv" class="mt-1" />
                    Export CSV
                </button>
            </div>
        </div>
        <!-- Search -->
        
        <div v-if="model.length">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-sm text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <td class="p-3">
                            <input
                            id="checkbox-all-leads"
                            type="checkbox"
                            @change="checkAllLeads($event, model)"
                            class="w-4 h-4 text-blue-600 bg-white
                            border-gray-300 rounded dark:bg-gray-700 
                            dark:border-gray-600">
                        </td>
                        <th v-for="theader in headers" :key="theader" 
                            scope="col" class="px-6 py-3">
                            {{theader}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in model" :key="item.id" class="bg-white border-b hover:bg-gray-50">
                        <td class="p-3">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                :value="item.id" 
                                :id="'id-'+item.id"
                                v-model="leadsToExport" 
                                @change="checkSingle($event, item.id, model)"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 
                                rounded dark:bg-gray-700 dark:border-gray-600">
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{item.email}}
                        </th>
                        <td class="px-6 py-4">
                            {{item.name}}
                        </td>
                        <td class="px-6 py-4">
                            {{item.status}}
                        </td>
                        <td class="px-6 py-4">
                            {{item.orders}}
                        </td>
                        <td class="px-6 py-4">
                            ${{item.lifetimeValue}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="flex justify-center mt-5 mb-5">
                <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm"
                    aria-label="Pagination">
                    <a v-for="(link, i) of meta.links" 
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
                            i === meta.links.length - 1 ? 'rounded-r-md' : '',
                        ]"
                        v-html="link.label">
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from 'notiwind'
import project from '../../store/project';

const route = useRoute()
const props = defineProps({
    data: Array,
    meta: Object
})
const headers = ['email','name','status','#Orders','lifetime value'];

let model = ref(props.data);
let leadsToExport = ref([])

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
});

function checkAllLeads(ev, data) {
    let checked = ev.target.checked;
    if(checked) {
        for(let l of data) {
            leadsToExport.value.push(l.id)
        }
    }else {
        leadsToExport.value = []
    }
}

function checkSingle(ev, data, allLeads) {
    let checked = ev.target.checked;
    let checkedAll = document.getElementById("checkbox-all-leads")

    if(!checked) {
        checkedAll.checked = false
        // remove id from leadsToExport
        let i = leadsToExport.value.indexOf(data);
        if (indexedDB > -1)
            leadsToExport.value.splice(i, 1)
    }else {
        if(leadsToExport.value.length == allLeads.length) {
            checkedAll.checked = true
            leadsToExport.value = []
            for(let l of allLeads) {
                leadsToExport.value.push(l.id)
            }
        }
    }
}

function exportLeads() {
    if(!leadsToExport.value.length) return;

    project
        .dispatch('exportCustomerLeads', {
            dataExport: leadsToExport.value,
            projectId: route.params.id
        })
        .then((res) => {
            let blob = new Blob([res]);
            let link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);            
            link.download = `customer_leads_${route.params.id}.csv`;
            link.click();
        })
        .catch((err) => {
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

const getForPage = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    project.dispatch('getCustomerLeadsPag', link.url);
}
</script>

<style>

</style>