<template>
    <div class="w-full" v-if="data.length">
        <div v-for="item in data" :key="item.id" 
            class="flex justify-between w-full p-4 
            text-center bg-white border shadow-md mb-4
            sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex gap-6">
                <img v-if="item.images.length"
                :src="helper.applink + item.images[0]" 
                class="w-14 h-14 object-cover rounded-md"/>

                <font-awesome-icon v-else 
                icon="fa-solid fa-image" class="w-10 h-10"  />
                
                <router-link :to="{name: 'PostUpdate', query: {pid: item.id}}"
                    class="text-2xl font-semibold text-gray-900 dark:text-white hover:underline pt-2">
                    {{ item.title }}
                </router-link>
            </div>
            <div class="flex">
                <span class="text-sm font-medium mr-2 px-2.5 py-1.5 
                    rounded dark:bg-yellow-900 dark:text-yellow-300"
                    :class="[item.publishedStatus!=='Published'
                    ? 'bg-yellow-100 text-yellow-800'
                    : 'bg-green-100 text-green-800'
                    ]">
                    {{ item.publishedStatus }}
                </span>
                <post-list-options :data="item" />
            </div>
        </div>
        <!-- Pagination -->
        <div class="flex justify-center mt-5 mb-5">
            <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm"
                aria-label="Pagination">
                <a v-for="(link, i) of meta.links" 
                    :key="i"
                    :disabled="!link.url"
                    href="#"
                    @click="getForPage($event,link)"
                    aria-current="page"
                    class="relative inline-flex items-center px-4 py-2 border text-sm
                    font-medium whitespace-nowrap"
                    :class="[
                        link.active 
                        ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' 
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                        i === 0 ? 'rounded-l-md' : '',
                        i === meta.links.length - 1 ? 'rounded-r-md' : '',
                    ]"
                    v-html="link.label">
                </a>
            </nav>
        </div>
    </div>
</template>

<script setup>
import PostListOptions from './PostListOptions.vue';
import memberStore from '../../store/membership-store';
import helper from '../../helpers'

const props = defineProps({
    data: Array,
    meta: Object
});

const getForPage = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    memberStore.dispatch('paginatePosts', link.url);
}
</script>

<style>

</style>