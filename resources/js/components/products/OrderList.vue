<template>
    <div class="w-full" v-if="data.length">
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
                <tr v-for="item in data" :key="item.id"
                    class="bg-white border-b hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{item.email}}
                    </th>
                    <td class="px-6 py-4 truncate">
                        {{ item.description }}
                    </td>
                    <td class="px-6 py-4">
                        {{ item.orderType }}
                    </td>
                    <td class="px-6 py-4">
                        {{ item.createdAt }}
                    </td>
                    <td class="px-6 py-4">
                        ${{ item.total }}
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
</template>

<script setup>
import { watch } from 'vue';
import productStore from '../../store/product-store'

const theaders = ['email','product','order type','date','total']
const props = defineProps({
    data: Array,
    meta: Object
})

const getForPage = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    productStore.dispatch('paginateOrders', link.url);
}
</script>

<style>

</style>