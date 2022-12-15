<template>
    <div>
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
                <tr v-for="item in data.data" :key="item.id"
                class="bg-white border-b hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{item.ip}}
                    </th>
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
                        {{item.date}}
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Pagination -->
        <div v-if="data.data.length >= 12" class="flex justify-center mt-5 mb-5">
            <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm"
                aria-label="Pagination">
                <a v-for="(link, i) of data.meta.links" 
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
                        i === data.meta.links.length - 1 ? 'rounded-r-md' : '',
                    ]"
                    v-html="link.label">
                </a>
            </nav>
        </div>
    </div>
</template>

<script setup>
import store from '../../store'

const props = defineProps({
    data: Object
})
const theaders = ['IP','status','date'];

const getForPage = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    store.dispatch('getLoginHistoryPage',{url: link.url});
}
</script>

<style>

</style>