<template>
    <div>
        <project-breadcrumbs
            v-if="projectInfo.data"
            currentPage="Product Category" 
            :projectInfo="projectInfo.data" 
        />
        <div class="flex justify-between">
            <div class="mt-4">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Product Categories
                </h1>
            </div>
        </div>
        <div class="mt-10">
            <category-list :data="categories.data" :meta="categories.meta" />
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { notify } from 'notiwind';
import ProjectBreadcrumbs from '../../components/ProjectBreadcrumbs.vue';
import CategoryList from '../../components/products/CategoryList.vue';
import project from '../../store/project';
import productStore from '../../store/product-store';

const route = useRoute();
const router = useRouter();
const projectInfo = computed(() => project.state.projects)
const categories = computed(() => productStore.state.categories)

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
    productStore.dispatch('getCatgories', route.params.id)
})
</script>

<style>

</style>