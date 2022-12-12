<template>
<!-- Show Agreement -->
    <div class="mt-4">
        <label for="showAgreements" 
            class="inline-flex relative items-center cursor-pointer">
            <input type="checkbox"
                id="showAgreements" 
                class="sr-only peer"
                @change="updateCheckbox($event)"
                :checked="showAgreement == 'yes' ? true : false">
            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                peer peer-checked:after:translate-x-full 
                peer-checked:after:border-white 
                after:content-[''] after:absolute after:top-[2px] 
                after:left-[2px] after:bg-white after:border-gray-300 
                after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                Show Agreement
            </span>
        </label>
        <p class="text-sm text-gray-500">
            Require the user to confirm his agreement by ticking a checkbox.
        </p>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: String
})
const emit = defineEmits(['update'])

let showAgreement = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    showAgreement.value = newVal
})

function updateCheckbox(ev) {
    let checked = ev.target.checked;
    if(checked)
        showAgreement.value = 'yes'
    else
        showAgreement.value = 'no'
    emit('update', showAgreement.value)
}
</script>

<style>

</style>