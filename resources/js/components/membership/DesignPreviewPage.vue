<template>
    <div :style="{'background-color': data.bgColor}">
        <!-- Auth buttons section -->
        <div class="flex gap-2 justify-end mb-4" 
        v-if="data.mainSetting.showSubLoginBar =='yes'">
            <button type="button" 
            class="text-white bg-blue-500 hover:bg-blue-800 
            focus:ring-0 focus:ring-blue-300 font-medium 
            text-sm px-5 py-3 mb-2 dark:bg-blue-600 
            dark:hover:bg-blue-700 focus:outline-none 
            dark:focus:ring-blue-800"
            :style="{'background-color': data.btnColor}">
                Subscribe
            </button>
            <button type="button" 
            class="text-gray-900 bg-white border border-gray-300 
            focus:outline-none focus:ring-0 
            focus:ring-gray-200 font-medium text-sm 
            px-5 py-2.5 mb-2 dark:bg-gray-800 dark:text-white 
            dark:border-gray-600 dark:hover:bg-gray-700 
            dark:hover:border-gray-600 dark:focus:ring-gray-700">
                Login
            </button>
        </div>  
        <!-- Title section -->
        <div>
            <h5 class="mb-2 text-2xl font-bold tracking-tight 
            text-gray-900 dark:text-white text-center"
            :style="{color: data.headlineColor}">
                {{ data.title }}
            </h5>
            <p class="font-normal text-gray-700 dark:text-gray-400 text-center"
            :style="{color: data.textColor}">
                {{ data.subHeading }}
            </p>
        </div>
        <!-- socials -->
        <div class="flex justify-center gap-3 mt-6">
            <a href="javascript:void(0)" v-if="data.smedia.facebook">
                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" :fill="data.btnColor" class="h-5 w-5">
                    <title>Facebook</title>
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>
            <a href="javascript:void(0)" v-if="data.smedia.instagram">
                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" :fill="data.btnColor" class="h-5 w-5">
                    <title>Instagram</title>
                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                </svg>
            </a>
            <a href="javascript:void(0)" v-if="data.smedia.twitter">
                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" :fill="data.btnColor" class="h-5 w-5">
                    <title>Twitter</title>
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
            </a>
            <a href="javascript:void(0)" v-if="data.smedia.pinterest">
                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" :fill="data.btnColor" class="h-5 w-5">
                    <title>Pinterest</title>
                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/>
                </svg>
            </a>
            <a href="javascript:void(0)" v-if="data.smedia.youtube">
                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" :fill="data.btnColor" class="h-5 w-5">
                    <title>YouTube</title>
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
            </a>
            <a href="javascript:void(0)" v-if="data.smedia.linkedin">
                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" :fill="data.btnColor" class="h-5 w-5">
                    <title>LinkedIn</title>
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
            </a>
            <a href="javascript:void(0)" v-if="data.smedia.tiktok">
                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" :fill="data.btnColor" class="h-5 w-5">
                    <title>TikTok</title>
                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                </svg>
            </a>
        </div>
        <!-- Email Collection -->
        <div class="flex justify-center mt-6" 
        v-if="data.emailbox == 'show'">
            <div class="relative w-1/2">
                <input type="text" id="post_bg_color" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm rounded-r-lg 
                focus:ring-blue-500 focus:border-blue-500 
                block w-full p-2.5 dark:bg-gray-700 
                dark:border-gray-600 dark:placeholder-gray-400 
                dark:text-white dark:focus:ring-blue-500 
                dark:focus:border-blue-500" 
                placeholder="Enter your email">
                <button type="button" 
                class="absolute top-0 right-0 p-2.5 text-sm 
                font-medium text-white bg-blue-500 rounded-r-lg 
                hover:bg-blue-800 focus:ring-0 
                focus:outline-none focus:ring-blue-300 dark:bg-blue-600 
                dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                :style="{'background-color': data.btnColor}">
                    <font-awesome-icon icon="fa-solid fa-arrow-right"/>
                </button>
            </div>
        </div>
        <!-- Disclaimer -->
        <div class="mt-6 text-center" :style="{color: data.textColor}">
            {{ data.disclaimer }}
        </div>
        <!-- Posts -->
        <div class="mt-16">
            <div v-if="data.posts=='single post'">
                <div v-for="item in posts" :key="item.id" class="mt-4">
                    <div class="bg-white border border-gray-200
                        rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
                        :style="{'background-color': data.postBgColor}">
                        <a href="javascript:void(0)">
                            <img v-if="item.images.length" 
                            class="rounded-t-lg h-40 w-full" 
                            :src="helper.applink+'/'+item.images[0]" 
                            alt="" />
                            <div v-else class="rounded-t-lg h-40 w-full"></div>
                        </a>
                        <div class="p-5">
                            <a href="javascript:void(0)">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                                :style="{color: data.headlineColor}">
                                    {{ item.title }}
                                </h5>
                            </a>
                            <div class="mb-3 font-normal text-gray-700 dark:text-gray-400 truncate"
                            :style="{color: data.textColor}" v-html="item.post"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="bg-white border border-gray-200
                        rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
                        :style="{'background-color': data.postBgColor}">
                        <a href="javascript:void(0)">
                            <img class="rounded-t-lg h-40 w-full" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
                        </a>
                        <div class="p-5">
                            <a href="javascript:void(0)">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                                :style="{color: data.headlineColor}">
                                    Your post title
                                </h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"
                            :style="{color: data.textColor}">
                                Sample excerpt. Your post excerpt will appear here.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="data.posts=='3 posts per row'"
            class="grid grid-cols-12 gap-2">
                <div v-for="item in posts" :key="item.id" class="col-span-4">
                    <div class="max-w-sm bg-white border border-gray-200 h-80
                        rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
                        :style="{'background-color': data.postBgColor}">
                        <a href="javascript:void(0)">
                            <img v-if="item.images.length" 
                            class="rounded-t-lg h-40 w-64" 
                            :src="helper.applink+'/'+item.images[0]" 
                            alt="" />
                            <div v-else class="rounded-t-lg h-40 w-full"></div>
                        </a>
                        <div class="p-5">
                            <a href="javascript:void(0)">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                                :style="{color: data.headlineColor}">
                                    {{ item.title }}
                                </h5>
                            </a>
                            <div class="mb-3 font-normal text-gray-700 dark:text-gray-400 truncate"
                            :style="{color: data.textColor}" v-html="item.post"></div>
                        </div>
                    </div>
                </div>
                <div class="col-span-4">
                    <div class="max-w-sm bg-white border border-gray-200 h-80
                        rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
                        :style="{'background-color': data.postBgColor}">
                        <a href="javascript:void(0)">
                            <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
                        </a>
                        <div class="p-5">
                            <a href="javascript:void(0)">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                                :style="{color: data.headlineColor}">
                                    Your post title
                                </h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"
                            :style="{color: data.textColor}">
                                Sample excerpt. Your post excerpt will appear here.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Subscribe - footer -->
        <div class="mt-10">
            <div class="w-full p-4 text-center bg-white 
                border rounded-lg shadow-md sm:p-8 
                dark:bg-gray-800 dark:border-gray-700">
                <p class="flex justify-end">
                    <font-awesome-icon icon="fa-solid fa-x" class="cursor-pointer"/>
                </p>
                <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <button type="button" 
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-0 
                        focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 
                        font-medium text-sm px-5 py-4 inline-flex 
                        justify-center max-w-lg text-center"
                        :style="{'background-color': data.btnColor}">
                        Subscribe for as low as $9.99 / month
                    </button>
                </div>
                <div class="mt-8 items-center justify-center">
                    <p class="text-sm" :style="{color: data.textColor}"> 
                        Or login if you've already purchased 
                    </p>
                    <div class="sm:flex items-center justify-center gap-3 mt-4">
                        <div>
                            <input type="email" id="email" 
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm focus:ring-blue-500 
                            focus:border-blue-500 block w-full p-2.5 
                            dark:bg-gray-700 dark:border-gray-600 
                            dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="email@example.com" required>
                        </div>
                        <div>
                            <input type="password" id="password" 
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm focus:ring-blue-500  
                            block w-full p-2.5 dark:bg-gray-700 focus:border-blue-500
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500" 
                            placeholder="password" required>
                        </div>
                        <button type="button" 
                            class="text-white bg-black hover:bg-black 
                            focus:ring-0 focus:outline-none focus:ring-blue-300 
                            font-medium text-sm w-full sm:w-auto px-5 
                            py-2.5 text-center
                            dark:focus:ring-blue-800">
                            Login
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import helper from '../../helpers';

const props = defineProps({
    data: Object,
    posts: Array
})
let data = ref(props.data)
let posts = ref(props.posts)

watch(() => props.data, (newval, oldVal) => {
    data.value = newval
}, {deep: true})

watch(() => props.posts, (newval, oldVal) => {
    posts.value = newval
}, {deep: true})
</script>

<style>

</style>