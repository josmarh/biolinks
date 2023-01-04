<template>
    <div class="md:grid md:grid-cols-3 md:gap-6 mt-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Shipping & Weight</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Does this this product require a shipping address or a special weight?
                </p>
            </div>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <div class="shadow-xl sm:overflow-hidden sm:rounded-md">
                <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                    <label for="shipping" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        Does This Product Require Shipping Address
                    </label>
                    <select id="shipping" 
                        v-model="shipping.shipping.isRequired"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm  
                        focus:ring-blue-500 focus:border-blue-500 
                        block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500">
                        <option value="no">No, no shipping required (ex - digital product)</option>
                        <option value="yes">Yes, required shipping (physical product)</option>
                    </select>
                    <div class="pl-10 mt-6" v-if="shipping.shipping.isRequired=='yes'">
                        <h3 class="block mb-2 text-sm font-medium 
                            text-gray-900 dark:text-white capitalize">
                            <font-awesome-icon icon="fa-solid fa-turn-down" class="mr-2"/>
                            set your shipping setting
                        </h3>
                        <div class="mt-4">
                            <label for="weight" 
                                class="block mb-2 text-sm font-medium 
                                text-gray-900 dark:text-white">
                                Weight
                            </label>
                            <input type="number" id="weight" 
                            v-model="shipping.shipping.weight"
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm  
                            focus:ring-blue-500 focus:border-blue-500 
                            block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500" 
                            placeholder="49.9 (numbers only)">
                            <p class="mt-3 text-gray-600 text-sm">
                                Only applies if you're using weight-based shipping.
                            </p>
                        </div>
                        <div class="mt-4">
                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 
                                focus:ring-0 focus:ring-blue-300 font-medium 
                                text-sm px-5 py-2.5 mr-2 capitalize
                                dark:bg-blue-600 dark:hover:bg-blue-700 
                                focus:outline-none dark:focus:ring-blue-800">
                                Set shipping rates here.
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateProduct'])

let shipping = ref({
    shipping: props.data,
    type: 'shipping'
})

watch(shipping, (newVal, oldVal) => {
    emit('updateProduct', shipping.value)
})
</script>

<style>

</style>