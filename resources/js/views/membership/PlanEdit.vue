<template>
    <div>
        <Breadcrumbs 
            v-if="projectInfo.data"
            :currentPage="plan.data.title" 
            :projectInfo="projectInfo.data" 
            :prevPage="{
                to: 'Plans',
                label: 'Plans'
            }"
        />
        <div class="flex justify-between">
            <div class="mt-4">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Plan Settings
                </h1>
            </div>
        </div>
        <!-- Title & Description -->
        <div class="mt-6 block p-4 bg-white 
            border border-gray-200 shadow-md 
            dark:bg-gray-800 dark:border-gray-700 
            w-full dark:hover:bg-gray-700">
            <div class="md:grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Title & Description
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Set-up your title and description.
                        </p>
                    </div>
                </div>
                <div class="col-span-8">
                    <div>
                        <label for="title" 
                            class="block mb-2 text-sm font-medium 
                            text-gray-900 dark:text-white">
                            Title
                        </label>
                        <input type="text" id="title" 
                        v-model="model.title"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm  
                        focus:ring-blue-500 focus:border-blue-500 
                        block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500" 
                        placeholder="">
                    </div>
                    <div class="mt-4">
                        <label for="description" 
                            class="block mb-2 text-sm font-medium 
                            text-gray-900 dark:text-white">
                            Description
                        </label>
                        <textarea id="description" rows="3" 
                        v-model="model.description"
                        maxlength="255"
                        class="block p-2.5 w-full text-sm text-gray-900 
                        bg-gray-50 rounded-lg border border-gray-300 
                        focus:ring-blue-500 focus:border-blue-500 
                        dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder=""></textarea>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pricing & Member Terms -->
        <div class="mt-6 block p-4 bg-white 
            border border-gray-200 shadow-md 
            dark:bg-gray-800 dark:border-gray-700 
            w-full dark:hover:bg-gray-700">
            <div class="md:grid grid-cols-12 gap-4 mt-6">
                <div class="col-span-4">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Pricing & Member Terms
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Set-up pricing for this plan on a monthly or annual basis.
                        </p>
                    </div>
                </div>
                <div class="col-span-8">
                    <div>
                        <label for="title" 
                            class="block mb-2 text-sm font-medium 
                            text-gray-900 dark:text-white">
                            Unlock Type
                        </label>
                        <select id="payment_type" 
                            v-model="model.unlockType"
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm  
                            focus:ring-blue-500 focus:border-blue-500 
                            block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500">
                            <option value="all_content">Unlock all content</option>
                            <option value="new_content">Unlock only new content and last 30 days of content</option>
                        </select>
                    </div>
                    <div class="mt-6">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" 
                            @change="toogleCheckbox($event, 'monthly')"
                            :checked="model.monthlyPricing=='yes' ? true : false">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none 
                            peer-focus:ring-4 peer-focus:ring-blue-300 
                            dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 
                            peer-checked:after:translate-x-full peer-checked:after:border-white 
                            after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                            after:bg-white after:border-gray-300 after:border after:rounded-full 
                            after:h-5 after:w-5 after:transition-all dark:border-gray-600 
                            peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Enable monthly pricing
                            </span>
                        </label>
                        <div class="mt-6"  v-if="model.monthlyPricing=='yes'">
                            <label for="monthly" 
                            class="block mb-2 text-sm font-medium 
                            text-gray-900 dark:text-white">
                                Monthly Price
                            </label>
                            <input type="number" id="monthly" 
                            v-model="model.monthlyPrice"
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm  
                            focus:ring-blue-500 focus:border-blue-500 
                            block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500" 
                            placeholder="">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" 
                            @change="toogleCheckbox($event, 'annual')"
                            :checked="model.annualPricing=='yes' ? true : false">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                            peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer 
                            dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white 
                            after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white 
                            after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 
                            after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Enable annual pricing
                            </span>
                        </label>
                        <div class="mt-6" v-if="model.annualPricing=='yes'">
                            <label for="annual" 
                            class="block mb-2 text-sm font-medium 
                            text-gray-900 dark:text-white">
                                Annual Price
                            </label>
                            <input type="number" id="annual" 
                            v-model="model.annualPrice"
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm  
                            focus:ring-blue-500 focus:border-blue-500 
                            block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500" 
                            placeholder="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Actions -->
        <div class="mt-6 block p-4 bg-white 
            border border-gray-200 shadow-md 
            dark:bg-gray-800 dark:border-gray-700 
            w-full dark:hover:bg-gray-700">
            <div class="md:grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Actions
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Set-up actions (like tags) for purchasing this plan.
                        </p>
                    </div>
                </div>
                <div class="col-span-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Set-up actions for this membership plan
                    </h3>
                    <button @click="showModal" type="button" 
                        class="mt-5 text-white bg-blue-700 
                        hover:bg-blue-800 focus:ring-0 focus:outline-none 
                        focus:ring-blue-300 font-medium text-sm px-5 py-2.5 
                        text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                        dark:focus:ring-blue-800">
                        Add New Action
                    </button>
                    <hr class="mt-6">
                    <div class="mt-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            List of actions
                        </h3>
                        <p class="mt-2 text-sm text-gray-600"
                        v-if="!model.action.actionList.length">
                            You currently have no actions.
                        </p>
                        <div v-else class="mt-4">
                            <ul class="text-sm font-medium text-gray-900 bg-white 
                            border border-gray-200 dark:bg-gray-700 
                            dark:border-gray-600 dark:text-white">
                                <li v-for="(item, i) in model.action.actionList" :key="i"
                                    class="w-full px-4 py-2 border-b border-gray-200 
                                    dark:border-gray-600 mb-2">
                                    <div class="flex justify-between">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                                            <font-awesome-icon icon="fa-solid fa-bolt" class="mr-2 text-yellow-500" />
                                            When person purchases
                                        </h3>
                                        <div>
                                            <font-awesome-icon 
                                            icon="fa-solid fa-pen-to-square" 
                                            class="cursor-pointer mr-2"
                                            @click="editAction(item, i)" />
                                            <font-awesome-icon 
                                            icon="fa-solid fa-trash" 
                                            class="cursor-pointer"
                                            @click="deleteAction(i)" />
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600 pl-8">
                                        <font-awesome-icon icon="fa-solid fa-angles-right" class="mr-2 text-green-600" />
                                        <span v-if="model.action.action=='add_profile_tag'">
                                            then apply a tag:
                                        </span>
                                        <span v-else>
                                            then remove tag:
                                        </span>
                                         {{ item.tag }}
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button @click="updatePlan" type="button" 
            class="mt-5 text-white bg-blue-700 
            hover:bg-blue-800 focus:ring-0 focus:outline-none 
            focus:ring-blue-300 font-medium text-sm px-5 py-2.5 
            text-center dark:bg-blue-600 dark:hover:bg-blue-700 
            dark:focus:ring-blue-800"
            :disabled="isDisabled">
            Update Plan
        </button>
    </div>
    <plan-action-modal 
    :show="isShowModal" 
    :data="model.action" 
    :task="task"
    @closeModal="closeModal" />
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import Breadcrumbs from '../../components/4StageBreadcrumbs.vue';
import PlanActionModal from '../../components/membership/PlanActionModal.vue'
import project from '../../store/project';
import memberStore from '../../store/membership-store'
import planData from '../../includes/plan-default-data';

const route = useRoute();
const projectInfo = computed(() => project.state.projects)
const plan = computed(() => memberStore.state.plan)
const isShowModal = ref(false)
const task = ref('new')
let isDisabled = ref(false)
let model = ref(planData)

watch(plan, (newVal, oldVal) => {
    model.value = newVal.data
})

function closeModal() {
  isShowModal.value = false
}
function showModal() {
    task.value = 'new'
    model.value.action.tag = ''
    isShowModal.value = true
}

function toogleCheckbox(ev, type) {
    let checked = ev.target.checked;

    if(checked && type=='monthly')
        model.value.monthlyPricing = 'yes'
    else if(!checked && type=='monthly')
        model.value.monthlyPricing = 'no'
    else if(checked && type=='annual')
        model.value.annualPricing = 'yes'
    else if(!checked && type=='annual')
        model.value.annualPricing = 'no'
}

function editAction(item, index) {
    task.value = 'update'
    model.value.action.action = item.action
    model.value.action.tag = item.tag
    model.value.action['index'] = index
    isShowModal.value = true
}

function deleteAction(index) {
    let filtered = model['_rawValue'].action.actionList.filter((data, i) => i != index)
    model.value.action.actionList = filtered;
}

function updatePlan() {
    isDisabled.value = true
    memberStore
        .dispatch('updatePlan', {
            id: model.value.id,
            title: model.value.title,
            description: model.value.description,
            unlockType: model.value.unlockType,
            monthlyPricing: model.value.monthlyPricing,
            monthlyPrice: model.value.monthlyPrice,
            annualPricing: model.value.annualPricing,
            annualPrice: model.value.annualPrice,
            action: JSON.stringify(model.value.action)
        })
        .then((res) => {
            isDisabled.value = false
            model.value = res.data
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
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
    memberStore.dispatch('getPlan', route.query.pid)
})
</script>

<style>

</style>