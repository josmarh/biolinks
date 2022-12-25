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
                            <div class="ml-1 text-sm font-medium text-gray-900 
                                md:ml-2 dark:text-gray-400 
                                dark:hover:text-white">
                                Project
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
                    {{content.data.name}} Project
                </h5>
                <div class="mt-3">
                    <project-list-options :data="content.data" from="inner-project" />
                </div>
            </div>
            <p class="font-normal text-gray-700 dark:text-gray-400">
                All the links created in this project.
            </p>
        </div>
        <!-- Chart Report -->
        <div class="mt-4">
            <div class="border-t border-gray-200">
                <div class="py-6 px-4" v-if="projectlinkChartOptions.labels">
                    <LineChart :chartData="projectlinkChartOptions" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import ProjectListOptions from '../dashboard/ProjectListOptions.vue';
import project from '../../store/project';
import reportStore from '../../store/report-store';
import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

const route = useRoute();
const content = computed(() => project.state.projects)
const projectLinkClicks = computed(() => reportStore.state.projectLinkClicks)

let isProjectLinkSet = ref(0)
let projectlinkChartOptions = ref({
    labels: [],
    datasets: [
        {
            label: 'Impression',
            data: [],
            parsing: {
                yAxisKey: 'impression'
            },
            backgroundColor: '#77CEFF',
            tension: 0.5,
            fill: false,
        },
        {
            label: 'Unique',
            data: [],
            parsing: {
                yAxisKey: 'unique'
            },
            backgroundColor: '#13AA7C',
            tension: 0.5,
            fill: false,
        }
    ]
})

watch(projectLinkClicks, (newVal, oldVal) => {
    projectlinkChartOptions.value.labels = []
    projectlinkChartOptions.value.datasets[0].data = []
    projectlinkChartOptions.value.datasets[1].data = []

    for(let d of newVal.linkClicks.reverse()) {
        projectlinkChartOptions.value.labels.push(d.created)

        projectlinkChartOptions.value.datasets[0].data.push({
            x: d.created, 
            impression: d.impression, 
            unique: d.unique
        })
        projectlinkChartOptions.value.datasets[1].data.push({
            x: d.created, 
            impression: d.impression, 
            unique: d.unique
        })
    }
})

function getProjectInfo() {
    project
        .dispatch('getProjectInfo', route.params.id)
        .then((res) => {

        })
        .catch((err) => {
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
    getProjectInfo();
    reportStore.dispatch('getProjectLinkClicksReport', route.params.id)
})
</script>

<style>

</style>