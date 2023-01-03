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
                            <router-link :to="{name: 'Project', params: {id: $route.params.id}}"
                                class="ml-1 text-sm font-medium text-gray-500 
                                hover:text-gray-900 md:ml-2 dark:text-gray-400 
                                dark:hover:text-white">
                                {{ projectInfo.data.name }} Project
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
                                People
                            </div>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="mt-4">
                <h1 class="py-10 text-2xl font-bold text-gray-800">People</h1>
                <people-list :project-info="projectInfo.data" :data="projectTeams.data" :theaders="theaders" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import PeopleList from '../components/people/PeopleList.vue';
import project from '../store/project';

const route = useRoute();
const projectInfo = computed(() => project.state.projects)
const projectTeams = computed(() => project.state.projectTeams)
const theaders = ['email','name','role','action']

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
    project.dispatch('getProjectTeam', route.params.id)
})
</script>

<style>

</style>