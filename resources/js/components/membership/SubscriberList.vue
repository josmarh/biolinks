<template>
    <div class="w-full" v-if="data.length">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <tbody>
                <tr v-for="item in data" :key="item.id"
                    class="bg-white border-b hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{item.email}}
                    </th>
                    <td class="px-6 py-4">
                        <button 
                            type="button" 
                            @click="removeAccess(item.email)"
                            class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                            focus:outline-none focus:ring-gray-100
                            font-medium text-sm px-5 py-2.5 text-center 
                            inline-flex items-center dark:focus:ring-gray-500 mr-2"
                            :disabled="isDisabled">
                            Remove Access
                        </button>
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
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import memberStore from '../../store/membership-store';

const route = useRoute();
const props = defineProps({
    data: Array,
    meta: Object
});
let isDisabled = ref(false)

function removeAccess(email) {
    isDisabled.value = true
    memberStore
        .dispatch('removeSubscriber', {
            subscriber: email,
            projectId: route.params.id
        })
        .then((res) => {
            isDisabled.value = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
            memberStore.dispatch('getSubscribers', route.params.id)
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

const getForPage = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    memberStore.dispatch('paginateSubscribers', link.url);
}
</script>

<style>

</style>