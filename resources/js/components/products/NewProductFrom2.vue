<template>
    <div class="flex justify-between mt-6">
        <div>
            <h1 class="py- text-3xl font-bold text-gray-800">
                Product Options
            </h1>
        </div>
        <div>
            <button type="button" @click="updateForm2"
                class="text-white bg-blue-700 hover:bg-blue-800 
                focus:ring-0 focus:ring-blue-300 font-medium 
                text-sm px-5 py-2.5 mr-2 capitalize
                dark:bg-blue-600 dark:hover:bg-blue-700 
                focus:outline-none dark:focus:ring-blue-800">
                Save Progress
            </button>
        </div>
    </div>
    <!-- form -->
    <div class="mt-8">
        <pricing :data="model.pricing" @updateProduct="updateProduct" />
        <hr class="mt-6 w-full">

        <!-- Shipping & Weight -->
        <shipping :data="model.shipping" @updateProduct="updateProduct" />
        <hr class="mt-6 w-full">

        <!-- Inventory and SKU -->
        <inventory :data="model.inventory" @updateProduct="updateProduct" />
        <hr class="mt-6 w-full">

        <!-- Digital Files & Deliverables -->
        <digital-file :data="model.files" @updateProduct="updateProduct" />
        <hr class="mt-6 w-full">

        <!-- external link -->
        <external-link :data="model.extLink" @updateProduct="updateProduct" />
        <hr class="mt-6 w-full">

        <button type="button" @click="updateForm2"
            class="text-white bg-blue-700 hover:bg-blue-800 
            focus:ring-0 focus:ring-blue-300 font-medium 
            text-sm px-5 py-4 mr-2 capitalize mt-6
            dark:bg-blue-600 dark:hover:bg-blue-700 w-full
            focus:outline-none dark:focus:ring-blue-800"
            :disabled="isDisabled">
            Save & Finish
        </button>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Pricing from './product-price-options/Pricing.vue'
import Shipping from './product-price-options/Shipping.vue'
import Inventory from './product-price-options/Inventory.vue'
import DigitalFile from './product-price-options/DigitalFile.vue';
import ExternalLink from './product-price-options/ExternalLink.vue';

const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateModel'])

let model = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

let isDisabled = ref(false)

function updateProduct(data) {
    switch (data.type) {
        case 'pricing':
            model.value.pricing = data.pricing
            break;
        case 'shipping':
            model.value.shipping = data.shipping
            break;
        case 'inventory':
            model.value.inventory = data.inventory
            break;
        case 'files':
            model.value.files = data.files
            break;
        case 'extLink':
            model.value.extLink = data.link
            break;

        default:
            break;
    }
}

function updateForm2() {
    emit('updateModel', model.value)
}

</script>

<style>

</style>