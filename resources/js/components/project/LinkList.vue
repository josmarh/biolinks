<template>
    <div class="md:mt-16 mb-10">
        <div class="md:flex justify-between">
            <h5 class="mb-2 text-2xl font-bold 
                tracking-tight text-gray-700 
                dark:text-white capitalize">
                project links
            </h5>
            <new-link-options />
        </div>
        <!-- Link list -->
        <div class="mt-6">
            <div v-if="isLinkSet==1">
                <round-loader />
            </div>
            <div v-if="isLinkSet==2">
                <div v-for="item in links.data" :key="item.id"
                    class="block w-full px-8 py-6 mb-2
                    border border-gray-200 shadow-md dark:bg-gray-800 
                    dark:border-gray-700 dark:hover:bg-gray-700 
                    text-center"
                    :class="[item.status == 'active' ? 'bg-white' : 'bg-gray-100']">
                    <div class="md:grid grid-cols-12">
                        <div class="text-white mt-2">
                            <span v-if="item.type=='biolink'" 
                                class="p-2 bg-blue-600 rounded-full">
                                <font-awesome-icon icon="fa-solid fa-hashtag" class="px-1 pt-1" />
                            </span>
                            <span v-else class="p-2 bg-green-600 rounded-full">
                                <font-awesome-icon icon="fa-solid fa-link" class="pt-1" />
                            </span>
                        </div>
                        <div class="col-span-4 text-start">
                            <router-link  :to="{name: 'Link', params: {id: item.id}}"
                                class="mb-2 text-lg font-bold 
                                tracking-tight text-gray-700 
                                dark:text-white">
                                {{item.linkId}}
                            </router-link>
                            <p v-if="item.type=='biolink'"
                                class="flex gap-2 text-gray-500 text-sm">
                                <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5" />
                                
                                <a :href="applink+'/w/'+item.linkId" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="underline">
                                    {{applink+'/w/'+item.linkId}}
                                </a>
                            </p>
                            <p v-else
                                class="flex gap-2 text-gray-500 text-sm">
                                <font-awesome-icon icon="fa-solid fa-earth-africa" class="mt-0.5" />
                                
                                <a :href="item.linkTypeUrl" 
                                    target="_blank" 
                                    rel="noopener noreferrer" 
                                    class="underline">
                                    {{item.linkTypeUrl}}
                                </a>
                            </p>
                        </div>
                        <div class="col-span-1">
                            <span class="bg-green-100 text-green-800 
                                text-xs font-semibold mr-2 px-2.5 
                                py-0.5 rounded dark:bg-green-200 
                                dark:text-green-900" data-tooltip-target="tooltip-unique-click">
                                <font-awesome-icon icon="fa-solid fa-chart-column" class="mt-0.5 mr-1" />
                                {{item.uniqueClicks}}
                            </span>
                            <div id="tooltip-unique-click" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                                Total unique clicks
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <span class="bg-green-100 text-blue-800 
                                text-xs font-semibold mr-2 px-2.5 
                                py-0.5 rounded dark:bg-green-200 
                                dark:text-blue-900" data-tooltip-target="tooltip-total-leads">
                                <font-awesome-icon icon="fa-solid fa-chart-column" class="mt-0.5 mr-1" />
                                {{item.leads}}
                            </span>
                            <div id="tooltip-total-leads" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                                Total leads
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <div class="col-span-3">
                            <p class="flex gap-2 text-gray-500 text-sm">
                                <font-awesome-icon icon="fa-solid fa-calendar" class="mt-0.5" />
                                {{item.createdAt}}
                            </p>
                        </div>
                        <div class="col-span-1">
                            <label :for="'default-status-' + item.id" 
                                class="inline-flex relative items-center cursor-pointer">
                                <input type="checkbox"
                                    :id="'default-status-' + item.id" 
                                    class="sr-only peer"
                                    @change="updateLinkStatus($event, item.id)"
                                    :checked="item.status == 'active' ? true : false">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                                    peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                                    peer peer-checked:after:translate-x-full 
                                    peer-checked:after:border-white 
                                    after:content-[''] after:absolute after:top-[2px] 
                                    after:left-[2px] after:bg-white after:border-gray-300 
                                    after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                                    peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    
                                </span>
                            </label>
                        </div>
                        <div class="col-span-1 flex justify-end">
                            <link-list-options :data="item" from="link-list" />
                        </div>
                    </div>
                </div>
                <!-- pagination -->
                
            </div>
            <div v-if="isLinkSet==3">
                <no-project-content notice="No links attached to this project..." />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router';
import { notify } from 'notiwind';
import NoProjectContent from '../NoProjectContent.vue';
import RoundLoader from '../RoundLoader.vue';
import NewLinkOptions from './NewLinkOptions.vue';
import LinkListOptions from './LinkListOptions.vue';
import projectlinks from '../../store/projectlinks';

const links = computed(() => projectlinks.state.links);
const route = useRoute();
const isLinkSet = ref(0);
let applink = `${window.location.protocol}//${window.location.host}`;


function getLinks() {
    isLinkSet.value = 1
    projectlinks
        .dispatch('getLinks', route.params.id)
        .then((res) => {
            if(res.data.length)
                isLinkSet.value = 2
            else
                isLinkSet.value = 3
        })
        .catch((err) => {
            isLinkSet.value = 3
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

function updateLinkStatus(ev, id) {
    let checked = ev.target.checked;
    if(checked) {
        projectlinks.dispatch('updateLinkStatus', {
            id: id,
            status: 'active'
        })
    }else {
        projectlinks.dispatch('updateLinkStatus', {
            id: id,
            status: 'inactive'
        })
    }
    projectlinks.dispatch('getLinks', route.params.id)
}

onMounted(() => {
    getLinks();
})
</script>

<style>

</style>