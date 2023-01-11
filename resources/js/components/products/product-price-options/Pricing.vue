<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Pricing</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Set up pricing / payment plan for this variant.
                </p>
            </div>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <div class="shadow-xl sm:overflow-hidden sm:rounded-md">
                <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                    <div class="md:grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="price" 
                                class="block mb-2 text-sm font-medium 
                                text-gray-900 dark:text-white">
                                Price
                            </label>
                            <input type="number" id="price" 
                            v-model="pricing.pricing.price"
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm  
                            focus:ring-blue-500 focus:border-blue-500 
                            block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500" 
                            placeholder="49.9 (numbers only)">
                        </div>
                        <div>
                            <label for="compare_at_price" 
                                class="block mb-2 text-sm font-medium 
                                text-gray-900 dark:text-white">
                                Compare At Price
                            </label>
                            <input type="number" id="compare_at_price"
                            v-model="pricing.pricing.comparePrice"
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm focus:ring-blue-500 
                            focus:border-blue-500 block w-full p-2.5 
                            dark:bg-gray-700 dark:border-gray-600 
                            dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="99.9 (numbers only)">
                        </div>
                    </div>
                    <hr class="mb-6">
                    <select id="payment_type" 
                        v-model="pricing.pricing.paymentType"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm  
                        focus:ring-blue-500 focus:border-blue-500 
                        block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500">
                        <option value="one-time">One-time Payment</option>
                        <option value="monthly">Monthly Recurring</option>
                        <option value="annual">Annual Recurring</option>
                        <option value="free">Free</option>
                    </select>
                    <p class="mt-3 text-gray-600 text-sm" 
                        v-if="pricing.pricing.paymentType == 'monthly' || pricing.pricing.paymentType == 'annual'">
                        Warning: Shipping is not charged for future payments. 
                        If you must collect shipping, please increase the price 
                        of your subscription instead. American sales tax is 
                        collected if applicable to the order.
                    </p>
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

let pricing = ref({
    pricing: props.data,
    type: 'pricing'
})

watch(() => pricing.value.pricing.paymentType, (newVal, oldVal) => {
    if(newVal == 'free')
        pricing.value.pricing.price = 0
})

watch(pricing, (newVal, oldVal) => {
    emit('updateProduct', pricing.value)
})
</script>

<style>

</style>