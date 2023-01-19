<template>
    <div class="md:mt-16 mb-10">
        <div class="md:flex justify-between">
            <h5 class="text-2xl font-bold 
                tracking-tight text-gray-700 
                dark:text-white capitalize w-full">
                Statistics
            </h5>
            <!-- Calendar filter -->
            <Datepicker 
                v-model="datePicker"
                class="border border-gray-300 
                text-gray-900 text-sm rounded-lg
                focus:ring-0 focus:border-blue-500 
                block w-full" range />
        </div>
        <!-- Chart Report -->
        <div class="mt-8">
            <div class="border-t border-gray-200">
                <div class="py-6 px-4" v-if="projectlinkChartOptions.labels.length">
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
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import reportStore from '../../store/report-store';
import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

const route = useRoute()
const projectLinkClicks = computed(() => reportStore.state.projectLinkClicks)
const today = new Date()
const priorDate = new Date(new Date().setDate(today.getDate() - 30))

let datePicker = ref([dformat(priorDate), dformat(today)])
let projectlinkChartOptions = ref({
    labels: [],
    datasets: [
        {
            label: 'Impression',
            data: [],
            parsing: {
                yAxisKey: 'impression'
            },
            backgroundColor: 'rgba(41, 64, 214, 0.48)',
            tension: 0.5,
            fill: true,
            opacity: 1
        },
        {
            label: 'Unique',
            data: [],
            parsing: {
                yAxisKey: 'unique'
            },
            backgroundColor: 'rgba(37, 193, 76, 0.67)',
            tension: 0.5,
            fill: true,
            opacity: 1
        }
    ]
})

watch(datePicker, (newVal, oldVal) => {
    reportStore.dispatch('getPageViewReport', {
        id: route.params.linkId, 
        from: dformat(newVal[0]),
        to: dformat(newVal[1])
    })
}, {deep:true})

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

function dformat(date) {
    let d = new Date(date);
    const day = d.getDate() <= 9 == 1 ? `0${d.getDate()}` : d.getDate();
    const month = d.getMonth()+1  <= 9 == 1 ? `0${d.getMonth()+1}` : d.getMonth()+1;
    const year = d.getFullYear();
    const time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    return `${year}-${month}-${day}`;
}

onMounted(() => {
    reportStore.dispatch('getPageViewReport', {
        id: route.params.linkId, 
        from: datePicker.value[0],
        to: datePicker.value[1]
    })
})
</script>

<style>

</style>