<template>
    <div>
        <project-breadcrumbs
            v-if="projectInfo.data"
            currentPage="New Product" 
            :projectInfo="projectInfo.data" 
        />
        <div class="flex flex-wrap mt-8">
            <div class="w-full">
                <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                    <li class="-mb-px mr-2 last:mr-0 flex-auto cursor-pointer">
                        <a class="text-xs px-5 py-3 shadow-lg block leading-normal" 
                            @click="toggleTabs(1)" 
                            :class="{'text-blue-600 bg-white': openTab !== 1, 'text-white bg-blue-600': openTab === 1}">
                            <span class="uppercase font-bold ">
                                <font-awesome-icon icon="fa-solid fa-gear mr-1 mt-0.5" />
                                Main Settings
                            </span>
                            <p class="mt-2 text-sm">
                                Set your product title, categories, and brief description here.
                            </p>
                        </a>
                    </li>
                    <li class="-mb-px mr-2 last:mr-0 flex-auto cursor-pointer">
                        <a class="text-xs px-5 py-3 shadow-lg block leading-normal" 
                            @click="toggleTabs(2)" 
                            :class="{'text-blue-600 bg-white': openTab !== 2, 'text-white bg-blue-600': openTab === 2}">
                            <span class="uppercase font-bold ">
                                <font-awesome-icon icon="fa-solid fa-sliders mr-1 mt-0.5" />
                                price/product options
                            </span>
                            <p class="mt-2 text-sm">
                                Set pricing, variants, stock, shipping, and download files.
                            </p>
                        </a>
                    </li>
                </ul>
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 mt-4 shadow-lg rounded">
                    <div class="px-4 py-5 flex-auto">
                        <div class="tab-content tab-space">
                            <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                                <new-product-from-1 />
                            </div>
                            <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                                <new-product-from-2 />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import ProjectBreadcrumbs from '../../components/ProjectBreadcrumbs.vue';
import NewProductFrom1 from '../../components/products/NewProductFrom1.vue';
import NewProductFrom2 from '../../components/products/NewProductFrom2.vue';
import project from '../../store/project';

const route = useRoute();
const projectInfo = computed(() => project.state.projects)

let openTab = ref(1)

function toggleTabs(tabNumber) {
    openTab.value = tabNumber
}

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
})
</script>

<style>

</style>