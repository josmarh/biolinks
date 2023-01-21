<template>
    <div>
        <label for="discount-type" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            What kind of discount?
        </label>
        <select id="discount-type" 
            v-model="model.discount.type"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm focus:ring-blue-500 
            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 
            dark:text-white dark:focus:ring-blue-500 
            dark:focus:border-blue-500">
            <option value="percentage_off">Percentage Off</option>
            <option value="dollars_off">Dollars Off</option>
            <!-- <option value="free_shipping">Free Shipping</option> -->
        </select>
    </div>
    <div class="mt-4" v-if="model.discount.type=='percentage_off'">
        <label for="percentage_off" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Percentage Off
        </label>
        <input type="number" id="percentage_off" 
        v-model="model.discount.percentage"
        class="bg-gray-50 border border-gray-300 
        text-gray-900 text-sm  
        focus:ring-blue-500 focus:border-blue-500 
        block w-full p-2.5 dark:bg-gray-700 
        dark:border-gray-600 dark:placeholder-gray-400 
        dark:text-white dark:focus:ring-blue-500 
        dark:focus:border-blue-500" 
        placeholder="25">
        <div class="mt-4 ml-6">
            <label for="pacentageRecurringPurchase" 
                class="block mb-2 text-sm font-medium 
                text-gray-900 dark:text-white">
                Allow discount to be applied for recurring purchases?
            </label>
            <select id="pacentageRecurringPurchase" 
                v-model="model.discount.pacentageRecurringPurchase"
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                dark:border-gray-600 dark:placeholder-gray-400 
                dark:text-white dark:focus:ring-blue-500 
                dark:focus:border-blue-500">
                <option value="disable">Disable for future subscription purchases</option>
                <option value="enable">Allow discount for subscription </option>
            </select>
            <p class="mt-3 text-gray-600 text-sm"> 
                If enabled, every payment that comes in with a 
                subscription / recurring payment will be discounted. 
                If disabled, only the first payment is discounted.
            </p>
        </div>
    </div>
    <div class="mt-4" v-if="model.discount.type=='dollars_off'">
        <label for="dollars_off" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Dollars Off
        </label>
        <input type="number" id="dollars_off" 
        v-model="model.discount.dollarOff"
        class="bg-gray-50 border border-gray-300 
        text-gray-900 text-sm  
        focus:ring-blue-500 focus:border-blue-500 
        block w-full p-2.5 dark:bg-gray-700 
        dark:border-gray-600 dark:placeholder-gray-400 
        dark:text-white dark:focus:ring-blue-500 
        dark:focus:border-blue-500" 
        placeholder="15">
    </div>
    <div class="mt-4" v-if="model.discount.type=='free_shipping'">
        <label for="free_shipping" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Set a free shipping maximum amount?
        </label>
        <input type="number" id="free_shipping" 
        v-model="model.discount.freeShipping"
        class="bg-gray-50 border border-gray-300 
        text-gray-900 text-sm  
        focus:ring-blue-500 focus:border-blue-500 
        block w-full p-2.5 dark:bg-gray-700 
        dark:border-gray-600 dark:placeholder-gray-400 
        dark:text-white dark:focus:ring-blue-500 
        dark:focus:border-blue-500" 
        placeholder="Leave blank for no maximum shipping">
        
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