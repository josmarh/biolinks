<template>
    <div>
        <div v-for="(item, i) in model" :key="i"
            class="md:flex gap-4">
            <div class="w-full mt-2">
                <select :id="'os-select-' + i" v-model="model[i].os"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm 
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                    dark:placeholder-gray-400 dark:text-white 
                    dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="iOS">iOS</option>
                    <option value="Android">Android</option>
                    <option value="Windows">Windows</option>
                    <option value="OS X">OS X</option>
                    <option value="Linux">Linux</option>
                    <option value="Chrome OS">Chrome OS</option>
                </select>
            </div>
            <div class="w-full mt-2">
                <input type="url" :id="`os-url-${i}`" v-model="model[i].url"
                    class="bg-gray-50 border border-gray-300 text-gray-900 
                    text-sm focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                    dark:placeholder-gray-400 dark:text-white 
                    dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="https://domain.com/example">
            </div>
            <div>
                <button type="button" @click="removeField(i)"
                    class="text-red-500 hover:text-white border 
                    border-red-500 hover:bg-red-600 focus:ring-0 
                    focusCreate:outline-none focus:ring-red-300 font-medium 
                    text-sm px-5 py-2.5 text-center mr-2 
                    dark:border-red-500 dark:text-red-500 
                    dark:hover:text-white dark:hover:bg-red-600 
                    dark:focus:ring-red-800 mt-2">
                    <font-awesome-icon icon="fa-solid fa-trash" />
                    <span class="sr-only">Delete</span>
                </button>
            </div>
        </div>
        <button type="button" @click="addOS"
            class="text-green-500 hover:text-white border 
            border-green-500 hover:bg-green-600 focus:ring-0 
            focusCreate:outline-none focus:ring-green-300 font-medium 
            text-sm px-5 py-2.5 text-center mr-2 mb-2 
            dark:border-green-500 dark:text-green-500 
            dark:hover:text-white dark:hover:bg-green-600 
            dark:focus:ring-green-800 mt-6">
            <font-awesome-icon icon="fa-solid fa-plus" />
            Create
        </button>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const emit = defineEmits(['addOS', 'updateOS']);
const props = defineProps({
    addedOS: Array,
});

let model = ref(props.addedOS)

watch(() => props.addedOS, (newVal, oldVal) => {
    model.value = newVal
}, {deep:true})

function addOS() {
    if(model.value.length < 3)
        emit('addOS');
}

function removeField(index) {
    let filtered = model['_rawValue'].filter((data, i) => i != index)

    model.value = [];
    
    for (let f of filtered) {
        model.value.push(f)
    }

    emit('updateOS', model.value)
}
</script>

<style>

</style>