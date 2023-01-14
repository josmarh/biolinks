<template>
    <div>
        <h1 class="font-semibold text-xl">Add Digital Product Access</h1>
        <div class="block p-4 bg-slate-100 border border-gray-200  
        shadow-md dark:bg-gray-800 dark:border-gray-700 w-full
        dark:hover:bg-gray-700 mt-6">
            <p class="text-gray-600 text-sm font-semibold">
                Select the products or courses you'd like to attach to this post. 
                Anyone who has access to this post will have access to these products.
            </p>
            <div class="p-4 mb-4 text-sm text-yellow-700 
            bg-yellow-100 rounded-lg dark:bg-gray-800 
            dark:text-yellow-300 text-gray-700 mt-4 font-normal" role="alert">
                <span class="font-medium">Warning:</span> 
                Only digital products that are of the "simple" 
                type are allowed here (variant & multi-variant products will not work)
            </div>
            <div class="mt-6">
                <label for="featured_image_style" 
                    class="block mb-2 text-sm 
                    font-medium text-gray-900 
                    dark:text-white capitalize">
                    Products
                </label>
                <div class="mt-4">
                    <div v-for="item in products" :Key="item.id"
                        class="flex items-center mb-4">
                        <input :id="'product-checkbox-'+item.id" 
                        type="checkbox" :value="item.id" v-model="model.products"
                        class="w-4 h-4 text-blue-600 border-gray-300 
                        rounded focus:ring-blue-500 dark:focus:ring-blue-600 
                        dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 
                        dark:border-gray-600">
                        <label :for="'product-checkbox-'+item.id" 
                            class="ml-2 text-sm font-medium 
                            text-gray-900 dark:text-gray-300">
                            {{ item.title }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: Object,
    products: Array
})
const emit = defineEmits(['updateModel'])

let model = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep: true})

watch(model, (newVal, oldVal) => {
    emit('updateModel', model.value)
}, {deep: true})

</script>

<style>

</style>