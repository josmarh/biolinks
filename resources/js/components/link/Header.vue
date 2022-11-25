<template>
    
    <div>
        <div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <router-link :to="{name: 'Dashboard'}" 
                            class="inline-flex items-center text-sm 
                            font-medium text-gray-500 hover:text-gray-900 
                            dark:text-gray-400 dark:hover:text-white">
                            <font-awesome-icon icon="fa-solid fa-gauge" class="w-4 h-4 mr-2" />
                            Dashbaord
                        </router-link>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" 
                                fill="currentColor" 
                                viewBox="0 0 20 20" 
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <router-link :to="{name: 'Project', params: {id: model.projectId}}"
                                class="ml-1 text-sm font-medium text-gray-500 
                                hover:text-gray-900 md:ml-2 dark:text-gray-400 
                                dark:hover:text-white">
                                Project
                            </router-link>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" 
                                fill="currentColor" 
                                viewBox="0 0 20 20" 
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <router-link :to="{name: 'Link', params: {id: $route.params.id}}"
                                class="ml-1 text-sm font-medium text-gray-500 
                                hover:text-gray-900 md:ml-2 dark:text-gray-400 
                                dark:hover:text-white capitalize">
                                {{model.type}}
                            </router-link>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" 
                                fill="currentColor" 
                                viewBox="0 0 20 20" 
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-1 text-sm font-medium text-gray-900 
                                md:ml-2 dark:text-gray-400 
                                dark:hover:text-white capitalize">
                                Settings
                            </div>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="mt-2">
            <div class="inline-flex gap-4">
                <h5 class="mb-2 text-2xl font-bold 
                    tracking-tight text-gray-700 
                    dark:text-white">
                    {{model.linkId}}
                </h5>
                <div class="mt-2">
                    <label :for="'default-status-' + model.id" 
                        class="inline-flex relative items-center cursor-pointer">
                        <input type="checkbox"
                            :id="'default-status-' + model.id" 
                            class="sr-only peer"
                            @change="updateLinkStatus($event)"
                            :checked="model.status == 'active' ? true : false">
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
                <div class="mt-3">
                    <link-list-options :data="model" from="link-main" />
                </div>
            </div>
            <div class="font-normal text-sm text-gray-700 dark:text-gray-400">
                <font-awesome-icon icon="fa-solid fa-circle-dot" class="h-4 w-4 mr-2 mt-0.5"
                    :class="[model.type == 'biolink' ? 'text-blue-600' : 'text-green-600']" />

                <span class="text-gray-500">Your link </span>

                <a :href="`${applink}/${model.linkId}`" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="underline">
                    {{applink}}/{{model.linkId}}
                </a>

                <!-- Copy to clipboard -->
                <button class="pl-4" @click="ccopy(model.linkId)">
                    <font-awesome-icon :icon="copy" class="w-4 h-4 hover:text-blue-600"/>
                </button>
            </div>
        </div>
        <!-- Page settings view -->
        <div v-if="model.type == 'biolink'">
            <biolink-settings />
        </div>
        <div v-if="model.type == 'link'">
            <link-settings />
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import LinkListOptions from '../project/LinkListOptions.vue';
import projectlinks from '../../store/projectlinks';
import BiolinkSettings from './BiolinkSettings.vue';
import LinkSettings from './LinkSettings.vue';

const props = defineProps({
    data: Object
})

let model = ref({
    id: null,
    projectId: 0,
    type: '',
    linkId: '',
    status: '',
});
let copy = ref('fa-solid fa-clipboard');
let applink = `${window.location.protocol}//${window.location.host}`

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function updateLinkStatus(ev) {
    let checked = ev.target.checked;
    if(checked) {
        projectlinks.dispatch('updateLinkStatus', {
            id: model.value.id,
            status: 'active'
        })
    }else {
        projectlinks.dispatch('updateLinkStatus', {
            id: model.value.id,
            status: 'inactive'
        })
    }
}

function ccopy(data) {
    copy.value = 'fa-solid fa-clipboard-check';

    navigator.clipboard.writeText(applink+'/'+data);

    setTimeout(() => {
        copy.value = 'fa-solid fa-clipboard';
    }, 1200)
}
</script>

<style>

</style>