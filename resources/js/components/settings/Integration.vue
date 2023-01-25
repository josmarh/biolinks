<template>
    <div class="md:grid md:grid-cols-3 md:gap-6 bg-white px-4 py-5 shadow-lg rounded">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Payment Integration
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    Set-up your Stripe or Paypal integration here.
                </p>
            </div>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <div class="">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" 
                    :checked="model.stripeStatus=='disabled' ? false : true"
                    @change="updateCheck($event, 'stripe')">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none 
                        peer-focus:ring-4 peer-focus:ring-blue-300 
                        dark:peer-focus:ring-blue-800 rounded-full peer 
                        dark:bg-gray-700 peer-checked:after:translate-x-full 
                        peer-checked:after:border-white after:content-[''] 
                        after:absolute after:top-[2px] after:left-[2px] 
                        after:bg-white after:border-gray-300 after:border 
                        after:rounded-full after:h-5 after:w-5 after:transition-all 
                        dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        Enable Stripe
                    </span>
                </label>
            </div>
            <div class="mt-4" v-if="model.stripeStatus=='enabled'">
                <div>
                    <label for="stripe-secret" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        Stripe Secret
                    </label>
                    <input type="text" id="stripe-secret" 
                    v-model="model.stripeSecret"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                </div>
            </div>
            <div class="mt-6">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" 
                    :checked="model.paypalStatus=='disabled' ? false : true"
                    @change="updateCheck($event, 'paypal')">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none 
                        peer-focus:ring-4 peer-focus:ring-blue-300 
                        dark:peer-focus:ring-blue-800 rounded-full peer 
                        dark:bg-gray-700 peer-checked:after:translate-x-full 
                        peer-checked:after:border-white after:content-[''] 
                        after:absolute after:top-[2px] after:left-[2px] 
                        after:bg-white after:border-gray-300 after:border 
                        after:rounded-full after:h-5 after:w-5 after:transition-all 
                        dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        Enable Paypal
                    </span>
                </label>
            </div>
            <div class="flex gap-4 mt-4" v-if="model.paypalStatus=='enabled'">
                <div class="w-full">
                    <label for="paypal-secret" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        Paypal Secret
                    </label>
                    <input type="text" id="paypal-secret" 
                    v-model="model.paypalSecret"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                </div>
                <div class="w-full">
                    <label for="paypal-client" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        Paypal Client ID
                    </label>
                    <input type="text" id="paypal-client" 
                    v-model="model.paypalClient"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                </div>
            </div>
            <div class="mt-4">
                <button type="button" @click="updatePayment"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-5 py-2.5 mr-2 capitalize
                    dark:bg-blue-600 dark:hover:bg-blue-700 
                    focus:outline-none dark:focus:ring-blue-800">
                    Update
                </button>
            </div>
        </div>
    </div>
    <!-- Email -->
    <MailIntegration :data="mailModel" @updateModel="updateMailProvider" />
</template>

<script setup>
import { ref, watch } from "vue";
import MailIntegration from './MailIntegration.vue'

const props = defineProps({
    data: Object,
    mailData: Object
});
const emit = defineEmits(['updateModel', 'updateMailModel']);

let model = ref(props.data);
let mailModel = ref(props.mailData)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep: true});
watch(() => props.mailData, (newVal, oldVal) => {
    mailModel.value = newVal
}, {deep: true});
// watch(model, (newVal, oldVal) => {
//     emit('updateModel', newVal)
// }, {deep: true});

function updatePayment() {
    emit('updateModel', model.value)
}

function updateMailProvider() {
    emit('updateMailModel', mailModel.value)
}

function updateCheck(ev, type) {
    let checked = ev.target.checked;

    if(checked && type == 'stripe')
        model.value.stripeStatus = 'enabled'
    else if(!checked && type == 'stripe')
        model.value.stripeStatus = 'disabled'
    else if(checked && type == 'paypal')
        model.value.paypalStatus = 'enabled'
    else
        model.value.paypalStatus = 'disabled'
}
</script>

<style>

</style>