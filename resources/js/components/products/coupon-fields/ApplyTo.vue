<template>
    <div>
        <label for="applyTo" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Only Apply For Certain Products / Courses / Membership?
        </label>
        <select id="applyTo" 
            v-model="model.applyTo.apply"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm focus:ring-blue-500 
            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 
            dark:text-white dark:focus:ring-blue-500 
            dark:focus:border-blue-500">
            <option value="all_products">Applies to all products</option>
            <option value="specific">Choose specific products / courses</option>
        </select>
        <div v-if="model.applyTo.apply=='specific'" class="mt-4 ml-4">
            <div class="mt-4">
                <label for="applyTo" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                    Choose specific product
                </label>
                <select id="applyTo" 
                    v-model="model.applyTo.specificProduct"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500">
                    <option value="no_products">Apply to NO products</option>
                    <option value="yes_products">Apply to YES products</option>
                </select>
            </div>
            <div class="mt-4">
                <label for="courses" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                    Choose specific course
                </label>
                <select id="courses" 
                    v-model="model.applyTo.specificCourse"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500">
                    <option value="no_courses">Apply to NO courses</option>
                    <option value="yes_courses">Apply to YES courses</option>
                </select>
            </div>
            <div class="mt-4">
                <label for="membership" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                    Choose specific membership
                </label>
                <select id="membership" 
                    v-model="model.applyTo.membership"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500">
                    <option value="exclude_membership">Exclude membership</option>
                    <option value="apply_membership">Apply to membership</option>
                </select>
            </div>
        </div>
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