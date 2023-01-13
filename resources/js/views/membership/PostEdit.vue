<template>
    <div>
        <Breadcrumbs 
            v-if="projectInfo.data"
            :currentPage="post.data.title" 
            :projectInfo="projectInfo.data" 
            :prevPage="{
                to: 'Posts',
                label: 'Posts'
            }"
        />
        <div class="md:grid grid-cols-12 gap-10 mt-10">
            <div class="col-span-9">
                <div class="block p-4 bg-white 
                    border border-gray-200  
                    shadow-md dark:bg-gray-800 
                    dark:border-gray-700 w-full
                    dark:hover:bg-gray-700">
                    <div class="flex gap-4 w-full">
                        <p v-if="projectInfo.data"
                            class="font-normal text-gray-700 dark:text-gray-400 mt-2">
                            {{ helper.applink + projectInfo.data.name }}/post/
                        </p>
                        <input type="text" id="slug" 
                        v-model="postModel.slug"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="">
                        <div class="flex gap-4 w-full">
                            <font-awesome-icon icon="fa-up-right-from-square" class="h-4 w-4 mt-3" />
                            <select id="underline_select" 
                            class="block py-2.5 px-0 w-full text-sm 
                            text-gray-500 bg-transparent border-0 
                            border-b-2 border-gray-200 appearance-none 
                            dark:text-gray-400 dark:border-gray-700 
                            focus:outline-none focus:ring-0 
                            focus:border-gray-200 peer">
                                <option selected disabled hidden>View Post</option>
                                <option value="subscriber">View as subscriber</option>
                                <option value="guest">View as guest</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap mt-8 block p-4 bg-white 
                    border border-gray-200 shadow-md dark:bg-gray-800 
                    dark:border-gray-700 w-full dark:hover:bg-gray-700">
                    <div class="w-full">
                        <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                            <li class="-mb-px mr-2 last:mr-0 flex-auto cursor-pointer">
                                <a class="text-xs px-5 py-3 shadow-lg text-center block leading-normal" 
                                    @click="toggleTabs(1)" 
                                    :class="{'text-blue-600 bg-white': openTab !== 1, 'text-white bg-blue-600': openTab === 1}">
                                    <span class="uppercase font-bold ">
                                        Content
                                    </span>
                                </a>
                            </li>
                            <li class="-mb-px mr-2 last:mr-0 flex-auto cursor-pointer">
                                <a class="text-xs px-5 py-3 shadow-lg text-center block leading-normal" 
                                    @click="toggleTabs(2)" 
                                    :class="{'text-blue-600 bg-white': openTab !== 2, 'text-white bg-blue-600': openTab === 2}">
                                    <span class="uppercase font-bold ">
                                        Media / Download
                                    </span>
                                </a>
                            </li>
                            <li class="-mb-px mr-2 last:mr-0 flex-auto cursor-pointer">
                                <a class="text-xs px-5 py-3 shadow-lg text-center block leading-normal" 
                                    @click="toggleTabs(3)" 
                                    :class="{'text-blue-600 bg-white': openTab !== 3, 'text-white bg-blue-600': openTab === 3}">
                                    <span class="uppercase font-bold ">
                                        Product Access
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 mt-4 rounded">
                            <div class="px-4 py-5 flex-auto">
                                <div class="tab-content tab-space">
                                    <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                                        <ContentFields :data="postModel" @updateModel="updateModel" />
                                    </div>
                                    <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                                        <media-download :data="postModel" @updateModel="updateModel" />
                                    </div>
                                    <div v-bind:class="{'hidden': openTab !== 3, 'block': openTab === 3}">
                                        <!-- <new-product-from-2 :data="postModel" @updateModel="updateModel" /> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-3">
                <button type="button" @click="updatePost"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-10 py-6 mr-2 mt-1 capitalize text-center
                    dark:bg-blue-600 dark:hover:bg-blue-700 w-full
                    focus:outline-none dark:focus:ring-blue-800"
                    :disabled="isDisabled">
                    Save Changes
                </button>
                <div class="mt-6">
                    <label for="excerpt" class="block mb-2 text-sm 
                    font-medium text-gray-900 dark:text-white">
                        Change publish date
                    </label>
                    <Datepicker 
                    v-model="postModel.publishedDate"
                    class="border border-gray-300 
                    text-gray-900 text-sm rounded-lg
                    focus:ring-0 focus:border-blue-500 
                    block max-w-xs" />
                    <p class="mt-2 text-sm">
                        <em>(If date is in the future, your post will get scheduled)</em>
                    </p>
                </div>
                <hr class="mt-6">
                <!-- Author -->
                <div class="mt-6">
                    <label for="excerpt" class="block mb-2 text-sm 
                    font-medium text-gray-900 dark:text-white">
                        Author
                    </label>
                    <select id="author"
                        v-model="postModel.author.id"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500">
                        <option :value="postModel.author.id">{{ postModel.author.name }}</option>
                        <option value="">------</option>
                    </select>
                </div>
                <!-- Category -->
                <hr class="mt-6">
                <div class="mt-6">
                    <h3 class="block mb-2 text-sm font-medium flex mt-4
                    text-gray-900 dark:text-white capitalize">
                        Category
                    </h3>
                    <div v-if="postModel.categories.length">
                        <div class="flex flex-wrap gap-1 mt-4">
                            <div v-for="(item, i) in postModel.categories" :key="i">
                                <div class="flex mb-0.5">
                                    <span class="flex bg-blue-100 text-blue-800 text-sm font-medium 
                                        mr-2 px-2.5 py-1.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                        {{item}} &nbsp;
                                        <span @click="rmCategory(item)"
                                            class="w-4 h-4 flex items-center justify-center 
                                            rounded-full transition-color cursor-pointer 
                                            hover:bg-[rgba(0,0,0,0.2)] mt-0.5">
                                            <font-awesome-icon icon="fa-solid fa-circle-xmark" />
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="text" id="category" 
                    @keyup.enter="addCategory"
                    v-model="catSearch.category"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm focus:ring-blue-500 mt-4
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                    dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    placeholder="Enter a category">
                    <p class="mt-1 text-sm text-gray-500">
                        Hit the enter button when you're done with the category
                    </p>
                </div>
                <!-- Payment -->
                <hr class="mt-6">
                <div class="mt-6">
                    <label for="payment_settings" class="block mb-2 text-sm 
                    font-medium text-gray-900 dark:text-white">
                        Post payment settings
                    </label>
                    <select id="payment_settings"
                        v-model="postModel.postPaymentSettings"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500">
                        <option value="free">Free</option>
                        <option value="subscription">Requires Subscription</option>
                        <option value="otp">One-time Payment</option>
                    </select>
                </div>
                <div class="mt-2" v-if="postModel.postPaymentSettings=='otp'">
                    <label for="otp" class="block mb-2 text-sm 
                    font-normal text-gray-900 dark:text-white">
                        Even on a paid subscription, your user will have 
                        to pay this additional fee to unlock this post.
                    </label>
                    <input type="number" id="otp" 
                    v-model="postModel.otp"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                    dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    placeholder="0.00">
                </div>
                <div class="mt-2" v-if="postModel.postPaymentSettings=='subscription'">
                    <label for="content-preview" class="block mb-2 text-sm 
                    font-normal text-gray-900 dark:text-white">
                        Show a preview of this content for non subscribers.
                    </label>
                    <select id="content-preview"
                        v-model="postModel.contentPreview"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500">
                        <option value="yes_preview">Yes, show a preview</option>
                        <option value="no_preview">No preview</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import Breadcrumbs from '../../components/4StageBreadcrumbs.vue';
import ContentFields from '../../components/membership/post-fields/ContentFields.vue'
import MediaDownload from '../../components/membership/post-fields/MediaDownload.vue'
import ProductAccess from '../../components/membership/post-fields/ProductAccess.vue'
import project from '../../store/project';
import memberStore from '../../store/membership-store'
import helper from '../../helpers'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const route = useRoute();
const projectInfo = computed(() => project.state.projects)
const post = computed(() => memberStore.state.post)

let isDisabled = ref(false)
let openTab = ref(1)
let postModel = ref({
    slug: '',
    title: 'A New Member Post',
    excerpt: '',
    post: '',
    images: [],
    featuredImageStyle: 'rounded',
    media: [],
    products: [],
    courses: [],
    publishedDate: '',
    author: {id: null, name: ''},
    categories: [],
    postPaymentSettings: 'free',
    otp: '',
    contentPreview: 'no_preview',
    plans: '',
    publishedStatus: 'Draft',
    catCheck: [],
});
let catSearch = ref({
    projId: route.params.id,
    category: ''
})

watch(post, (newVal, oldVal) => {
    postModel.value = newVal.data
    postModel.value.catCheck = []
})

watch(() => postModel.value.publishedDate, (newVal, oldVal) => {
    if(newVal)
        postModel.value.publishedDate = dformat(newVal)
})

function toggleTabs(tabNumber) {
    openTab.value = tabNumber
}

function updateModel(data) {
    productModel.value = data
}

function updatePost() {
    isDisabled.value = true
    memberStore
        .dispatch('updatePost', {
            id: route.query.pid,
            slug: postModel.value.slug,
            title: postModel.value.title,
            excerpt: postModel.value.excerpt,
            post: postModel.value.post,
            images: JSON.stringify(postModel.value.images),
            featuredImageStyle: postModel.value.featuredImageStyle,
            media: JSON.stringify(postModel.value.media),
            products: JSON.stringify(postModel.value.products),
            courses: JSON.stringify(postModel.value.courses),
            publishedDate: postModel.value.publishedDate,
            author: postModel.value.author.id,
            categories: JSON.stringify(postModel.value.categories),
            postPaymentSettings: postModel.value.postPaymentSettings,
            otp: postModel.value.otp,
            contentPreview: postModel.value.contentPreview,
            plans: postModel.value.plans,
            publishedStatus: postModel.value.publishedStatus
        })
        .then((res) => {
            isDisabled.value = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
            memberStore.dispatch('getPost', route.query.pid)
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

function addCategory() {
    let cat = document.getElementById('category');
    postModel.value.categories.push(cat.value);
    postModel.value.catCheck.push(cat.value);
    cat.value = '';
    catSearch.value.category = '';

    postModel.value.categories = []
    postModel['_rawValue'].catCheck.forEach((c) => {
        if (!postModel.value.categories.includes(c)) {
            postModel.value.categories.push(c);
        }
    });
}

function rmCategory(item) {
    let filtered = postModel['_rawValue'].categories.filter(data => data != item)

    postModel.value.categories = [];
    postModel.value.catCheck = [];

    for (let f of filtered) {
        postModel.value.categories.push(f)
        postModel.value.catCheck.push(f)
    }
}

function dformat(date) {
    let d = new Date(date);
    const day = d.getDate() <= 9 == 1 ? `0${d.getDate()}` : d.getDate();
    const month = d.getMonth()+1  <= 9 == 1 ? `0${d.getMonth()+1}` : d.getMonth()+1;
    const year = d.getFullYear();
    const time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    return `${year}-${month}-${day}`;
}

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
    memberStore.dispatch('getPost', route.query.pid)
})
</script>

<style>

</style>