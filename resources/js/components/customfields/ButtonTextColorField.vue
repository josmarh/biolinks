<template>
    <div class="mt-4">
        <label for="btnTextColor" 
            class="block mb-2 text-sm font-medium flex
            text-gray-900 dark:text-white capitalize gap-2">
            <font-awesome-icon icon="fa-solid fa-paint-brush" class="mt-0.5" />
            Button Text Color
        </label>
        <div class="flex">
            <input type="text" id="btnTextColor" 
            v-model="colorp"
            class="rounded-none bg-gray-50 
            border text-gray-900 focus:ring-blue-500 
            focus:border-blue-500 block flex-1 min-w-0 
            w-full text-sm border-gray-300 p-1 
            dark:bg-gray-700 dark:border-gray-600 
            dark:placeholder-gray-400 dark:text-white cursor-pointer
            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
            placeholder=""
            @click="colorPickera.show = true"
            @blur="colorPickera.show = false"
            :style="{background: colorp}">
        </div>
        <div class="flex justify-end relative">
            <ColorPicker
                class="absolute bottom-0"
                theme="light"
                :color="colorp"
                :sucker-hide="true"
                :sucker-canvas="colorPickera.suckerCanvas"
                :sucker-area="colorPickera.suckerArea"
                @changeColor="changeColor"
                v-show="colorPickera.show"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { ColorPicker } from 'vue-color-kit';
import 'vue-color-kit/dist/vue-color-kit.css';

const props = defineProps({
    data: String,
})
const emit = defineEmits(['update'])

let colorp = ref(props.data)
let colorPickera = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});

watch(() => props.data, (newVal, oldVal) => {
    colorp.value = newVal;
})

function changeColor(color) {
    const { r, g, b, a } = color.rgba
    colorPickera.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    colorPickera.value.colorHex = color.hex
    colorp.value = color.hex
    emit('update', colorp.value, 'btnTextColor')
}
</script>

<style>

</style>