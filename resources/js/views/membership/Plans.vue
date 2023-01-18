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
                    focus:outline-none dark:focus:ring-blue-800"
                    :disabled="isDisabled">
                    <font-awesome-icon icon="fa-solid fa-plus" />
                    Add New Plan
                </button>
            </div>
        </div>
        <!-- main content -->
        <div class="flex mt-10 gap-10">
            <div class="w-96">
                <label for="plan_search" 
                    class="block mb-2 text-sm 
                    font-medium text-gray-900 
                    dark:text-white">
                    Search for plan
                </label>
                <input type="text" id="plan_search" 
                v-model="searchPlan.title"
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Search by title">
            </div>
            <plan-list :data="plans.data" :meta="plans.meta" />
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { notify } from 'notiwind';
import ProjectBreadcrumbs from '../../components/ProjectBreadcrumbs.vue';
import PlanList from '../../components/membership/PlanList.vue';
import planData from '../../includes/plan-default-data'
import project from '../../store/project';
import memberStore from '../../store/membership-store';

const route = useRoute();
const router = useRouter();
const projectInfo = computed(() => project.state.projects)
const plans = computed(() => memberStore.state.plans)
let isDisabled = ref(false)
let searchPlan = ref({
    title: '',
    projectId: route.params.id
})

function newPlan() {
    isDisabled.value = true
    memberStore
        .dispatch('storePlan', {
            projectId: route.params.id,
            title: planData.title,
            description: planData.description,
            unlockType: planData.unlockType,
            monthlyPricing: planData.monthlyPricing,
            monthlyPrice: planData.monthlyPrice,
            annualPricing: planData.annualPricing,
            annualPrice: planData.annualPrice,
            action: JSON.stringify(planData.action)
        })
        .then((res) => {
            isDisabled.value = false
            router.push({
                name: 'PlanUpdate',
                params: {id: route.params.id},
                query: {pid: res.planId}
            })
        })
        .catch((err) => {
            isDisabled.value = false
            let errMsg;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message"))
                        errMsg = err.response.data.message;
                    else
                        errMsg = err.response.data.error;
                }
            }else {
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
    project.dispatch('getProjectInfo', route.params.id)
    memberStore.dispatch('getPlans', route.params.id)
})
</script>

<style>

</style>