<template>
    <div>
        <label for="isExpires" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Does this coupon expires?
        </label>
        <select id="isExpires" 
            v-model="model.isExpires"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm focus:ring-blue-500 
            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 
            dark:text-white dark:focus:ring-blue-500 
            dark:focus:border-blue-500">
            <option value="no">No Expiration</option>
            <option value="yes">Yes it expires</option>
        </select>
    </div>
    <div class="mt-4" v-if="model.isExpires=='yes'">
        <label for="expiryDate" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Pick a date
        </label>
        <Datepicker 
        v-model="model.expiryDate"
        class="border border-gray-300 
        text-gray-900 text-sm rounded-lg
        focus:ring-0 focus:border-blue-500 
        block max-w-xs" />
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

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