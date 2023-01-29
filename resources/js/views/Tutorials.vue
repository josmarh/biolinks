<template>
    <div>
        <div class="flex justify-between">
            <div class="mt-2">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Tutorials
                </h1>
            </div>
        </div>
        <!-- main content -->
        <div class="flex mt-4 gap-10 w-full">
            <div class="block p-6 w-full bg-white border border-gray-200 shadow-md">
                <div class="md:grid grid-cols-12 gap-4 w-full">
                    <div v-for="(item, i) in tutorials" :key="i" 
                    class="md:col-span-3 col-span-6 flex justify-center">
                        <div>
                            <a :href="item.url"
                                class="item-center cursor-pointer" data-fancybox>
                                <img :src="item.thumbnail" :alt="item.title" class="rounded-t-lg" style="height: ;">
                            </a>
                            <h1 class="text-sm font-medium text-gray-600 mt-2">{{ item.title }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Fancybox, Carousel, Panzoom } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox.css";

const tutorials = [
    {
        thumbnail: 'https://i.vimeocdn.com/video/1598304982-5e1ddae60a5539b00bc1957ae5d6dbfdeb1b83d722a3d98e87fd56b022d90fd6-d_236x133', 
        url: 'https://vimeo.com/793790113', 
        title: 'Create Your First Biolink Page'
    },
    {
        thumbnail: 'https://i.vimeocdn.com/video/1598304982-5e1ddae60a5539b00bc1957ae5d6dbfdeb1b83d722a3d98e87fd56b022d90fd6-d_236x133', 
        url: 'https://vimeo.com/793790228', 
        title: 'Shorten a Url'
    },
]
</script>

<style>

</style>