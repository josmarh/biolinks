<template>
    <div>
        <div>
            <project-breadcrumbs  
                v-if="projectInfo.data"
                currentPage="People" 
                :projectInfo="projectInfo.data"
            />
            <div class="mt-4">
                <h1 class="py-6 text-3xl font-bold text-gray-800">People</h1>
                <people-list :project-info="projectInfo.data" :data="projectTeams.data" :theaders="theaders" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import ProjectBreadcrumbs from '../components/ProjectBreadcrumbs.vue';
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