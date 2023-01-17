<template>
    <div>
        <!-- <label for="headerFontFamily" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Heading Font Family
        </label> -->
        <select id="posts" 
        v-model="model.posts"
        class="bg-gray-50 border border-gray-300 
        text-gray-900 text-sm rounded-lg 
        focus:ring-blue-500 focus:border-blue-500 
        block w-full p-2.5 dark:bg-gray-700 
        dark:border-gray-600 dark:placeholder-gray-400 
        dark:text-white dark:focus:ring-blue-500 
        dark:focus:border-blue-500">
            <option value="single post">Single post</option>
            <option value="3 posts per row">3 Posts per row</option>
        </select>
    </div>
</template>

<script setup>
import { ref, watch } from "vue"

const props = defineProps({
    data: Object
})
const emit = defineEmits(['update'])
let model = ref(props.data)

watch(model, (newVal, oldVal) => {
    emit('update', model.value)
}, {deep:true})
</script>

<style>

</style>