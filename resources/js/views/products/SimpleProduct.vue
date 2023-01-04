<template>
    <div>
        <project-breadcrumbs
            v-if="projectInfo.data"
            currentPage="Products" 
            :projectInfo="projectInfo.data" 
        />
        <div class="flex justify-between">
            <div class="mt-4">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Simple Products
                </h1>
                <p class="text-gray-500 text-sm font-bold">
                    This area is for creating simple digital (digital download) or physical products.
                </p>
            </div>
            <div class="mt-6">
                <router-link :to="{name: 'NewProduct'}" 
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-5 py-2.5 mr-2 capitalize
                    dark:bg-blue-600 dark:hover:bg-blue-700 
                    focus:outline-none dark:focus:ring-blue-800">
                    <font-awesome-icon icon="fa-solid fa-plus" />
                    Create New Product
                </router-link>
            </div>
        </div>
        <div class="flex mt-10 gap-10">
            <div class="w-96">
                <label for="product_search" 
                    class="block mb-2 text-sm 
                    font-medium text-gray-900 
                    dark:text-white">
                    Search for product
                </label>
                <input type="text" id="product_search" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Search by title">
            </div>
            <product-list />
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import ProjectBreadcrumbs from '../../components/ProjectBreadcrumbs.vue';
import ProductList from '../../components/products/ProductList.vue';
import project from '../../store/project';

const route = useRoute();
const projectInfo = computed(() => project.state.projects)

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
})
</script>

<style>

</style>