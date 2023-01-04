<template>
    <div class="md:grid md:grid-cols-3 md:gap-6 mt-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Inventory and SKU</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Set-up a SKU or inventory for this product if applicable. 
                    Leave blank if infinite inventory (digital products)
                </p>
            </div>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <div class="shadow-xl sm:overflow-hidden sm:rounded-md">
                <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                    <div class="mt-4">
                        <label for="sku" 
                            class="block mb-2 text-sm font-medium 
                            text-gray-900 dark:text-white">
                            SKU
                        </label>
                        <input type="text" id="sku" 
                        v-model="inventory.inventory.sku"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5  
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500 dark:bg-gray-700" 
                        placeholder="">
                    </div>
                    <div class="flex gap-3 mt-4">
                        <div class="w-full">
                            <label for="track" 
                                class="block mb-2 text-sm font-medium 
                                text-gray-900 dark:text-white">
                                Track Inventory?
                            </label>
                            <select id="track" 
                                v-model="inventory.inventory.track"
                                class="bg-gray-50 border border-gray-300 
                                text-gray-900 text-sm  
                                focus:ring-blue-500 focus:border-blue-500 
                                block w-full p-2.5 dark:bg-gray-700 
                                dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 
                                dark:focus:border-blue-500">
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                        <div v-if="inventory.inventory.track=='yes'" class="w-full">
                            <label for="inventory" 
                                class="block mb-2 text-sm font-medium 
                                text-gray-900 dark:text-white capitalize">
                                inventory
                            </label>
                            <input type="number" id="inventory" 
                            v-model="inventory.inventory.inventory"
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm  
                            focus:ring-blue-500 focus:border-blue-500 
                            block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500" 
                            placeholder="1000">
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

let inventory = ref({
    inventory: props.data,
    type: 'inventory'
})

watch(inventory, (newVal, oldVal) => {
    emit('updateProduct', inventory.value)
})
</script>

<style>

</style>