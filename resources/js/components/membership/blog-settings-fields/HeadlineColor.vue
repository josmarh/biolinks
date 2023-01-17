<template>
    <div>
        <label for="headline_color" 
            class="block mb-2 text-sm font-medium 
            text-gray-900 dark:text-white">
            Healine Color
        </label>
        <input type="text" id="headline_color" 
        v-model="model.headlineColor"
        class="bg-gray-50 border border-gray-300 
        text-gray-900 text-sm rounded-lg 
        focus:ring-blue-500 focus:border-blue-500 
        block w-full p-2.5 dark:bg-gray-700 
        dark:border-gray-600 dark:placeholder-gray-400 
        dark:text-white dark:focus:ring-blue-500 
        dark:focus:border-blue-500" 
        placeholder="" 
        @click="colorPickerModel.show = true"
        @blur="colorPickerModel.show = false">
        <div class="flex justify-end relative">
            <ColorPicker
            class="absolute bottom-0"
            theme="light"
            :color="model.headlineColor"
            :sucker-hide="true"
            :sucker-canvas="colorPickerModel.suckerCanvas"
            :sucker-area="colorPickerModel.suckerArea"
            @changeColor="changeColorColor"
            v-show="colorPickerModel.show"/>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue"
import { ColorPicker } from 'vue-color-kit';
import 'vue-color-kit/dist/vue-color-kit.css';

const props = defineProps({
    data: Object
})
const emit = defineEmits(['update'])
let model = ref(props.data)
let colorPickerModel = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});

function changeColorColor(color) {
    const { r, g, b, a } = color.rgba
    colorPickerModel.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    colorPickerModel.value.colorHex = color.hex
    model.value.headlineColor = color.hex
}

watch(model, (newVal, oldVal) => {
    emit('update', model.value)
}, {deep:true})
</script>

<style>

</style>