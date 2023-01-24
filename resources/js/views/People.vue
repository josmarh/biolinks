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
                <hr class="mt-6">
                <customer-lead-list :data="customerLeads.data" :meta="customerLeads.meta" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import ProjectBreadcrumbs from '../components/ProjectBreadcrumbs.vue';
import PeopleList from '../components/people/PeopleList.vue';
import CustomerLeadList from '../components/people/CustomerLeadList.vue';
import project from '../store/project';

const route = useRoute();
const projectInfo = computed(() => project.state.projects)
const projectTeams = computed(() => project.state.projectTeams)
const customerLeads = computed(() => project.state.customerLeads)
const theaders = ['email','name','role','action']

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
    project.dispatch('getProjectTeam', route.params.id)
    project.dispatch('getCustomerLeads', route.params.id)
})
</script>

<style>

</style>