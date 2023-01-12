<template>
    <div>
        <project-breadcrumbs
            v-if="projectInfo.data"
            currentPage="Plans" 
            :projectInfo="projectInfo.data" 
        />
        <div class="flex justify-between">
            <div class="mt-4">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Plans
                </h1>
            </div>
            <div class="mt-6">
                <button type="button" @click="newPlan"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-5 py-2.5 mr-2 capitalize
                    dark:bg-blue-600 dark:hover:bg-blue-700 
                    focus:outline-none dark:focus:ring-blue-800">
                    <font-awesome-icon icon="fa-solid fa-plus" />
                    Add New Plan
                </button>
            </div>
        </div>
        <!-- main content -->
    </div>
</template>

<script setup>
import { onMounted, computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { notify } from 'notiwind';
import ProjectBreadcrumbs from '../../components/ProjectBreadcrumbs.vue';
import project from '../../store/project';

const route = useRoute();
const router = useRouter();
const projectInfo = computed(() => project.state.projects)

function newPlan() {

}

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
})
</script>

<style>

</style>