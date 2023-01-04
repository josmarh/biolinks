<template>
    <div class="w-full">
        <div class="flex justify-between w-full p-4 
            text-center bg-white border shadow-md 
            sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex gap-6">
                <font-awesome-icon icon="fa-solid fa-image" class="w-8 h-8" />
                <h5 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    Your awesome product!
                </h5>
            </div>
            <div class="flex">
                <span class="bg-yellow-100 text-yellow-800 
                    text-sm font-medium mr-2 px-2.5 py-1.5 
                    rounded dark:bg-yellow-900 dark:text-yellow-300">
                    Unpublished
                </span>
                <product-list-options />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import ProductListOptions from './ProductListOptions.vue';

const props = defineProps({
    data: Array
});


</script>

<style>

</style>