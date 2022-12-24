<template>
    <div class="md:mt-16">
        <div class="md:flex justify-between">
            <h5 class="mb-2 text-2xl font-bold 
                tracking-tight text-gray-700 
                dark:text-white capitalize">
                your projects
            </h5>
            <button type="button" @click="showFormModal"
                class="text-white bg-blue-700 hover:bg-blue-800 
                focus:ring-0 focus:ring-blue-300 font-medium 
                text-sm px-5 py-2.5 mr-2 mb-2 capitalize
                dark:bg-blue-600 dark:hover:bg-blue-700 
                focus:outline-none dark:focus:ring-blue-800">
                <font-awesome-icon icon="fa-solid fa-plus" />
                new project
            </button>
        </div>
        <p class="font-normal text-gray-700 dark:text-gray-400">
            A project can contain multiple Biolink Pages or Shortened links.
        </p>
        <!-- Project list -->
        <div class="mt-6">
            <div v-if="isProjectSet==1">
                <round-loader />
            </div>
            <div v-if="isProjectSet==2">
                <div v-for="item in projects.data" :key="item.projectId"
                    class="block w-full px-12 py-6 bg-white mb-2
                    border border-gray-200 shadow-md dark:bg-gray-800 
                    dark:border-gray-700 dark:hover:bg-gray-700 
                    text-center">
                    <div class="md:grid grid-cols-12">
                        <div class="col-span-6 text-start">
                            <router-link :to="{name: 'Project', params: {id: item.projectId}}"
                                class="mb-2 text-lg font-bold 
                                tracking-tight text-gray-700 
                                dark:text-white">
                                {{item.name}}
                            </router-link>
                            <p class="flex gap-2 text-gray-500 text-sm">
                                <font-awesome-icon icon="fa-solid fa-calendar" class="mt-0.5" />
                                {{item.createdAt}}
                            </p>
                        </div>
                        <div class="col-span-2">
                            <span class="bg-green-100 text-green-800 
                                text-xs font-semibold mr-2 px-2.5 
                                py-0.5 rounded dark:bg-green-200 
                                dark:text-green-900" data-tooltip-target="tooltip-total-links">
                                <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5 mr-1" />
                                {{item.totalLinks}}
                            </span>
                            <div id="tooltip-total-links" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                                Total links
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <span class="bg-green-100 text-blue-800 
                                text-xs font-semibold mr-2 px-2.5 
                                py-0.5 rounded dark:bg-green-200 
                                dark:text-blue-900" data-tooltip-target="tooltip-unique-click">
                                <font-awesome-icon icon="fa-solid fa-chart-column" class="mt-0.5 mr-1" />
                                {{item.uniqueClicks}}
                            </span>
                            <div id="tooltip-unique-click" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                                Total unique clicks
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                        <div class="col-span-2 flex justify-end">
                            <project-list-options :data="item" />
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="isProjectSet==3">
                <no-project-content notice="No Project Available" />
            </div>
        </div>
    </div>
    <project-form :show-form="showForm" @close-form="showFormModal" />
</template>

<script setup>
import { onMounted, computed, ref } from 'vue'
import { notify } from 'notiwind';
import RoundLoader from '../RoundLoader.vue';
import NoProjectContent from '../NoProjectContent.vue';
import ProjectForm from './ProjectForm.vue';
import ProjectListOptions from './ProjectListOptions.vue';
import project from '../../store/project'

const projects = computed(() => project.state.projects);
const isProjectSet = ref(0)
const showForm = ref(false)

function showFormModal() {
    showForm.value = !showForm.value
}

function getProjects() {
    isProjectSet.value = 1
    project
        .dispatch('getProjects')
        .then((res) => {
            if(res.data.length)
                isProjectSet.value = 2
            else
                isProjectSet.value = 3
        })
        .catch((err) => {
            isProjectSet.value = 3
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

onMounted(() => {
    getProjects();
})
</script>

<style>

</style>