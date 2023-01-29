<template>
    <div>
        <project-breadcrumbs
            v-if="projectInfo.data"
            currentPage="Post" 
            :projectInfo="projectInfo.data" 
        />
        <div class="flex justify-between">
            <div class="mt-4">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Posts
                </h1>
            </div>
            <div class="mt-6">
                <button type="button" @click="newPost"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-5 py-2.5 mr-2 capitalize
                    dark:bg-blue-600 dark:hover:bg-blue-700 
                    focus:outline-none dark:focus:ring-blue-800"
                    :disabled="isDisabled">
                    <font-awesome-icon icon="fa-solid fa-plus" />
                    Add New Post
                </button>
            </div>
        </div>
        <!-- main content -->
        <div class="flex mt-10 gap-10">
            <div class="w-96">
                <label for="post_search" 
                    class="block mb-2 text-sm 
                    font-medium text-gray-900 
                    dark:text-white">
                    Search for post
                </label>
                <input type="text" id="post_search" 
                v-model="searchPost.title"
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Search by title">
            </div>
            <post-list :data="posts.data" :meta="posts.meta" />
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { notify } from 'notiwind';
import ProjectBreadcrumbs from '../../components/ProjectBreadcrumbs.vue';
import PostList from '../../components/membership/PostList.vue'
import postData from '../../includes/post-default-data'
import project from '../../store/project';
import memberStore from '../../store/membership-store';

const route = useRoute();
const router = useRouter();
const projectInfo = computed(() => project.state.projects)
const posts = computed(() => memberStore.state.posts)
let isDisabled = ref(false)
let searchPost = ref({
    title: '',
    projectId: route.params.id
})

watch(searchPost, (newVal, oldVal) => {
    setTimeout(() => {
        memberStore.dispatch('searchPosts', searchPost.value)
    }, 1200)
}, {deep: true})

function newPost() {
    isDisabled.value = true
    memberStore
        .dispatch('storePost', {
            projectId: route.params.id,
            slug: postData.slug,
            title: postData.title,
            excerpt: postData.excerpt,
            post: postData.post,
            images: JSON.stringify(postData.images),
            featuredImageStyle: postData.featuredImageStyle,
            media: JSON.stringify(postData.media),
            products: JSON.stringify(postData.products),
            courses: JSON.stringify(postData.courses),
            publishedDate: postData.publishedDate,
            author: postData.author,
            categories: JSON.stringify(postData.categories),
            plans: JSON.stringify(postData.plans),
            postPaymentSettings: postData.postPaymentSettings,
            publishedStatus: 'Draft'
        })
        .then((res) => {
            isDisabled.value = false
            router.push({
                name: 'PostUpdate',
                params: {id: route.params.id},
                query: {pid: res.postId}
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
    memberStore.dispatch('getPosts', route.params.id)
})
</script>

<style>

</style>