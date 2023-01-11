<template>
    <div>
        <label for="discount-type" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Limit the total amount of times this coupon can be used?
        </label>
        <select id="discount-type" 
            v-model="model.couponLimitType"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm focus:ring-blue-500 
            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 
            dark:text-white dark:focus:ring-blue-500 
            dark:focus:border-blue-500">
            <option value="unlimited">Unlimited uses</option>
            <option value="limited">Limited uses</option>
        </select>
    </div>
    <div class="mt-4 ml-6"  v-if="model.couponLimitType=='limited'">
        <label for="couponLimitedCount" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Can be used how many times?
        </label>
        <input type="number" id="couponLimitedCount" 
        v-model="model.couponLimitedCount"
        class="bg-gray-50 border border-gray-300 
        text-gray-900 text-sm  
        focus:ring-blue-500 focus:border-blue-500 
        block w-full p-2.5 dark:bg-gray-700 
        dark:border-gray-600 dark:placeholder-gray-400 
        dark:text-white dark:focus:ring-blue-500 
        dark:focus:border-blue-500" 
        placeholder="">
        <p class="mt-3 text-gray-600 text-sm"> 
            Keep blank for unlimited uses.
        </p>
    </div>

</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateForm'])

let model = ref(props.data)

watch(model, (newVal, oldVal) => {
    emit('updateForm', model.value)
})
</script>

<style>

</style>