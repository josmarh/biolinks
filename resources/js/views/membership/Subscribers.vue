<template>
    <div>
        <project-breadcrumbs
            v-if="projectInfo.data"
            currentPage="Subscibers" 
            :projectInfo="projectInfo.data" 
        />
        <div class="flex justify-between">
            <div class="mt-4">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Subscibers
                </h1>
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

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
})
</script>

<style>

</style>