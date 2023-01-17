<template>
    <div>
        <project-breadcrumbs
            v-if="projectInfo.data"
            currentPage="Membership / Blog Design" 
            :projectInfo="projectInfo.data" 
        />
        <div class="flex justify-between">
            <div class="mt-4">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Membership / Blog Design
                </h1>
                <p class="text-gray-500 text-sm font-bold">
                    Design your own membership / blog here! 
                    Deliver a feed of content, and (optionally)
                    make customers subscribe for access!
                </p>
            </div>
            <!-- <div class="mt-6">
                <button type="button" @click="newProduct"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-5 py-2.5 mr-2 capitalize
                    dark:bg-blue-600 dark:hover:bg-blue-700 
                    focus:outline-none dark:focus:ring-blue-800">
                    <font-awesome-icon icon="fa-solid fa-plus" />
                    Create New Product
                </button>
            </div> -->
        </div>
        <!-- main content -->
        <div class="mt-6">
            <div class="flex justify-end">
                <button type="button" @click="showModal"
                    class="text-gray-900  
                    focus:outline-none focus:ring-0 
                    focus:ring-gray-100 font-medium rounded-lg text-sm 
                    px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white 
                    dark:border-gray-600 dark:hover:bg-gray-700 
                    dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    <font-awesome-icon icon="fa-solid fa-cog" class="mr-1" />
                    Advance Settings
                </button>
            </div>
            <div class="lg:grid grid-cols-12 gap-4 mt-4">
                <div class="col-span-3 mb-2">
                    <div class="block p-6 bg-white border border-gray-200 
                    shadow-md dark:bg-gray-800 dark:border-gray-700">
                        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                            <li class="mr-2">
                                <a href="#" aria-current="page" @click="switchTab($event, 1)"
                                class="inline-block p-4 active rounded-t-lg
                                dark:bg-gray-800 dark:text-blue-500"
                                :class="[currentTab==1 
                                ? 'text-blue-600 bg-gray-100 '
                                :'hover:bg-gray-50 hover:text-blue-600']">
                                    Home
                                </a>
                            </li>
                            <li class="mr-2">
                                <a href="#" @click="switchTab($event, 2)"
                                class="inline-block p-4 rounded-t-lg
                                dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                :class="[currentTab==2 
                                ? 'text-blue-600 bg-gray-100'
                                :'hover:bg-gray-50 hover:text-blue-600']">
                                    Post
                                </a>
                            </li>
                        </ul>
                        <!-- tab content -->
                        <div v-if="currentTab==1" class="mt-4">
                            <DesignSettingTab1 :data="model" @update="updateTab1Settings" />
                        </div>
                        <div v-else class="mt-4">
                            <DesignSettingTab2 :data="model" @update="updateTab2Settings" />
                        </div>
                        <button type="button" @click="updateSettings"
                        class="focus:outline-none text-white 
                        bg-green-500 hover:bg-green-600 focus:ring-0 
                        focus:ring-green-300 font-medium w-full mt-4
                        text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 
                        dark:hover:bg-green-700 dark:focus:ring-green-800"
                        :disabled="isDisabled">
                            Update Settings
                        </button>
                    </div>
                </div>
                <div class="col-span-9">
                    <div class="block p-6 bg-white border border-gray-200 
                        shadow-md dark:bg-gray-800 dark:border-gray-700"
                        :style="{'background-color': model.bgColor}">
                        <design-preview-page :data="model" :posts="posts.data" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <AdvanceSetting 
    :showModal="isshowModal" 
    :data="model" 
    @updateModal="closeModal"
    @updateModel="updateAdvanceSettings"/>
</template>

<script setup>
import { onMounted, computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { notify } from 'notiwind';
import ProjectBreadcrumbs from '../../components/ProjectBreadcrumbs.vue';
import DesignSettingTab1 from '../../components/membership/DesignSettingTab1.vue'
import DesignSettingTab2 from '../../components/membership/DesignSettingTab2.vue'
import DesignPreviewPage from '../../components/membership/DesignPreviewPage.vue';
import AdvanceSetting from '../../components/membership/AdvanceSetting.vue';
import project from '../../store/project';
import memberStore from '../../store/membership-store';

const route = useRoute();
const router = useRouter();
const projectInfo = computed(() => project.state.projects)
const posts = computed(() => memberStore.state.posts)
const currentTab = ref(1)
let isDisabled = ref(false)
let model = ref({
    headlineColor: '#000000',
    textColor: '#888888',
    bgColor: '#FFFFFF',
    btnColor: '#07bbf1',
    linkColor: '#001828',
    postBgColor: '#FFFFFF',
    title: 'My blog / membership',
    subHeading: 'My blog / membership',
    disclaimer: '',
    headerFontFamily: 'BlinkMacSystemFont',
    textFontFamily: 'Avenir',
    posts: 'single post',
    subsscriberAlert: 'show',
    subsscriberAlertColor: '#FFFFFF',
    emailbox: 'hide',
    postGatedContent: 'Want to unlock more content from us? Subscribe and get exclusive content.',
    mainSetting: {
        urlPath: 'members',
        imgUrl: '',
        imgUpload: null,
        showSubLoginBar: 'yes',
        showTotalSubscribers: 'yes',
        memberNickName: '',
        memberNickNamePlural: '',
    },
    smedia: {
        facebook: '',
        twitter: '',
        instgram: '',
        pinterest: '',
        youtube: '',
        linkedin: '',
        tiktok: ''
    }
})
let isshowModal = ref(false)

function showModal() {
    isshowModal.value = true
}
function closeModal() {
    isshowModal.value = false
}

function switchTab(ev, tab) {
    ev.preventDefault();

    if(tab==1)
        currentTab.value=1
    else
        currentTab.value=2
}

function updateModel(data) {
    model.value = data
}
function updateTab1Settings(data) {
    model.value.headlineColor = data.headlineColor
    model.value.textColor = data.textColor
    model.value.bgColor = data.bgColor
    model.value.btnColor = data.btnColor
    model.value.linkColor = data.linkColor
    model.value.postBgColor = data.postBgColor
    model.value.title = data.title
    model.value.subHeading = data.subHeading
    model.value.disclaimer = data.disclaimer
    model.value.headerFontFamily = data.headerFontFamily
    model.value.textFontFamily = data.textFontFamily
    model.value.posts = data.posts
    model.value.subsscriberAlert = data.subsscriberAlert
    model.value.subsscriberAlertColor = data.subsscriberAlertColor
    model.value.emailbox = data.emailbox
}
function updateTab2Settings(data) {
    model.value.postGatedContent = data.postGatedContent
}
function updateAdvanceSettings(data) {
    model.value = data
    updateSettings();
}
function updateSettings() {
    isDisabled.value = true
    memberStore
        .dispatch('storeBlog', {
            projectId: route.params.id,
            headlineColor: model.value.headlineColor,
            textColor: model.value.textColor,
            bgColor: model.value.bgColor,
            btnColor: model.value.btnColor,
            linkColor: model.value.linkColor,
            postBgColor: model.value.postBgColor,
            title: model.value.title,
            subHeading: model.value.subHeading,
            disclaimer: model.value.disclaimer,
            headerFontFamily: model.value.headerFontFamily,
            textFontFamily: model.value.textFontFamily,
            posts: model.value.posts,
            subsscriberAlert: model.value.subsscriberAlert,
            subsscriberAlertColor: model.value.subsscriberAlertColor,
            emailbox: model.value.emailbox,
            postGatedContent: model.value.postGatedContent,
            mainSetting: JSON.stringify(model.value.mainSetting),
            smedia: JSON.stringify(model.value.smedia)
        })
        .then((res) => {
            isDisabled.value = false
            isshowModal.value = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
            getSettings();
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

function getSettings() {
    memberStore
        .dispatch('getBlog', route.params.id)
        .then((res) => {
            if(Object.keys(res.data).length > 0) {
                model.value = res.data
            }
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
    getSettings();
    memberStore.dispatch('getPosts', route.params.id)
})
</script>

<style>

</style>