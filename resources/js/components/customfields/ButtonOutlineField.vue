<template>
    <div class="mt-4">
        <label for="buttonOutline" 
            class="inline-flex relative items-center cursor-pointer">
            <input type="checkbox"
                id="buttonOutline" 
                class="sr-only peer"
                @change="updateCheckbox($event)"
                :checked="buttonOutline == 'yes' ? true : false">
            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                peer peer-checked:after:translate-x-full 
                peer-checked:after:border-white 
                after:content-[''] after:absolute after:top-[2px] 
                after:left-[2px] after:bg-white after:border-gray-300 
                after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                Outline
            </span>
        </label>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: String
})
const emit = defineEmits(['update'])

let buttonOutline = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    buttonOutline.value = newVal
})

function updateCheckbox(ev) {
    let checked = ev.target.checked;

    if(checked)
        buttonOutline.value = 'yes'
    else
        buttonOutline.value = 'no'
    emit('update', buttonOutline.value)
}
</script>

<style>

</style>