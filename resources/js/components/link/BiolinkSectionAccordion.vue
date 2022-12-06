<template>
    <div class="border-2 p-2 rounded mt-2">
        <div @click="isOpen = !isOpen" 
            class="flex justify-between bg-white px-4 
            rounded cursor-pointer hover:text-blue-500"
            :class="isOpen ? 'text-blue-500' : 'text-gray-600'">
            <span class="flex font-medium">
                <font-awesome-icon  
                    v-if="icon"
                    :icon="icon" 
                    class="mt-1 mr-2"/>
                {{title}}
            </span>
            <span>
                <font-awesome-icon  
                    icon="fa-solid fa-ellipsis-vertical" 
                    class="mt-1.5"/>
            </span>
        </div>
        <div class="mt-4 border-2 p-2 rounded transition duration-300 ease-in-out" 
            :class="isOpen ? 'd-block' : 'hidden'">
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const isOpen = ref(false)
const props = defineProps({
    title: String,
    icon: String,
    data: Object
})
</script>

<style>

</style>