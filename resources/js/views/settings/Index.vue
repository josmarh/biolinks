<template>
    <div>
        <project-breadcrumbs
            v-if="projectInfo.data"
            currentPage="Project Settings" 
            :projectInfo="projectInfo.data" 
        />
        <div class="flex justify-between">
            <div class="mt-4">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Project Settings
                </h1>
            </div>
        </div>
        <div class="flex flex-wrap mt-6">
            <div class="w-full">
                <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                    <li class="-mb-px mr-2 last:mr-0 flex-auto cursor-pointer">
                        <a class="text-xs px-5 py-3 shadow-lg block leading-normal" 
                            @click="toggleTabs(1)" 
                            :class="{'text-blue-600 bg-white': openTab !== 1, 'text-white bg-blue-600': openTab === 1}">
                            <span class="uppercase font-bold ">
                                <font-awesome-icon icon="fa-solid fa-gear mr-1 mt-0.5" />
                                Payment Gateway & Integrations
                            </span>
                        </a>
                    </li>
                    <!-- <li class="-mb-px mr-2 last:mr-0 flex-auto cursor-pointer">
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
                    </li> -->
                </ul>
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 mt-4 ">
                    <div class="px-4 py-5 flex-auto">
                        <div class="tab-content tab-space">
                            <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                                <Integration 
                                :data="model" 
                                :mailData="modelMail" 
                                @updateModel="updatePayment"
                                @updateMailModel="updateMailProvider" />
                            </div>
                            <!-- <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                                <new-product-from-2 :data="productModel" @updateModel="updateModel" />
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { notify } from 'notiwind';
import ProjectBreadcrumbs from '../../components/ProjectBreadcrumbs.vue';
import Integration from '../../components/settings/Integration.vue'
import project from '../../store/project';
import integrationStore from '../../store/integration-store'

const route = useRoute();
const router = useRouter();
const projectInfo = computed(() => project.state.projects)
const payment = computed(() => integrationStore.state.payment)
const esp = computed(() => integrationStore.state.esp)

let openTab = ref(1)
let model = ref({
    stripeStatus: 'disabled',
    stripeSecret: '',
    paypalStatus: 'disabled',
    paypalSecret: '',
    paypalClient: '',
    projectId: route.params.id
});

let modelMail = ref({
    mailchimp: {
        apikey: '',
        listid: ''
    },
    getresponse: {
        apikey: '',
        campaignId: ''
    },
    emailoctopus: {
        apikey: '',
        listid: ''
    },
    converterkit: {
        apikey: '',
        formId: ''
    },
    mailerlite: {
        apiKey: '',
        groupId: ''
    }
})

watch(payment, (newVal, oldVal) => {
    if(JSON.stringify(newVal.data) != '{}')
        model.value = newVal.data
}, {deep: true});
watch(esp, (newVal, oldVal) => {
    if(JSON.stringify(newVal.data) != '{}')
        modelMail.value = newVal.data
}, {deep: true});

function toggleTabs(tabNumber) {
    openTab.value = tabNumber
}

function updatePayment(data) {
    model.value = data
    integrationStore
        .dispatch('upatePayment', model.value)
        .then((res) => {
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
            integrationStore.dispatch('getPayment', route.params.id)
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

function updateMailProvider(data) {
    modelMail.value = data
    integrationStore
        .dispatch('upateEsp', {
            projectId: route.params.id,
            mailchimp: JSON.stringify(modelMail.value.mailchimp),
            getresponse: JSON.stringify(modelMail.value.getresponse),
            emailoctopus: JSON.stringify(modelMail.value.emailoctopus),
            converterkit: JSON.stringify(modelMail.value.converterkit),
            mailerlite: JSON.stringify(modelMail.value.mailerlite),
        })
        .then((res) => {
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
            integrationStore.dispatch('getEsp', route.params.id)
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
    project.dispatch('getProjectInfo', route.params.id)
    integrationStore.dispatch('getPayment', route.params.id)
    integrationStore.dispatch('getEsp', route.params.id)
});
</script>

<style>

</style>