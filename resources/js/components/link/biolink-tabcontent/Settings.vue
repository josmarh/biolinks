<template>
    <div>
        <div class="block p-6 bg-white border 
            border-gray-200 shadow-md dark:bg-gray-800 
            dark:border-gray-700 dark:hover:bg-gray-700">
            <div>
                <label for="shortUrl" 
                    class="block mb-2 text-sm font-medium flex
                    text-gray-900 dark:text-white capitalize gap-2">
                    <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5" />
                    Short Url
                </label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 
                        text-sm text-gray-900 bg-gray-200 border 
                        border-r-0 border-gray-300 
                        dark:bg-gray-600 dark:text-gray-400 
                        dark:border-gray-600">
                        {{helper.applink}}
                    </span>
                    <input type="text" id="shortUrl" v-model="model.linkId"
                        class="rounded-none bg-gray-50 
                        border text-gray-900 focus:ring-blue-500 
                        focus:border-blue-500 block flex-1 min-w-0 
                        w-full text-sm border-gray-300 p-2.5 
                        dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="alias" required>
                </div>
                <p class="text-sm text-gray-500">
                    Leave empty for a random generated one.
                </p>
            </div>
            <!-- Logo Upload -->
            <div class="mt-4">
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" 
                        class="flex flex-col items-center justify-center 
                        w-full border-2 border-gray-300 border-dashed 
                        rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 
                        dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 
                        dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <font-awesome-icon icon="fa-solid fa-camera" class="w-10 h-10 mb-3 text-gray-400" />
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" />
                    </label>
                </div>
            </div>
            <!-- Video link -->
            <div class="mt-8">
                <div class="inline-flex gap-3">
                    <div class="flex items-center">
                        <input id="ytube" type="radio" value="youtube" name="video" 
                            v-model="modelSettings.video.type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 
                            border-gray-300 focus:ring-blue-500 
                            dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                            focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="ytube" 
                            class="ml-2 text-sm font-medium 
                            text-gray-900 dark:text-gray-300">
                            YouTube Video
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input id="vimeo" type="radio" value="vimeo" name="video" 
                            v-model="modelSettings.video.type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 
                            border-gray-300 focus:ring-blue-500 
                            dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                            focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="vimeo" 
                            class="ml-2 text-sm font-medium 
                            text-gray-900 dark:text-gray-300">
                            Vimeo Video
                        </label>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="video-link" 
                        class="block mb-2 text-sm font-medium flex
                        text-gray-900 dark:text-white capitalize gap-2">
                        <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5" />
                        {{modelSettings.video.type === 'youtube' ? 'Add Welcome Video' : 'Add Vimeo Video'}}
                    </label>
                    <div class="flex">
                        <input type="url" id="video-link" v-model="modelSettings.video.link"
                        class="rounded-none bg-gray-50 
                        border text-gray-900 focus:ring-blue-500 
                        focus:border-blue-500 block flex-1 min-w-0 
                        w-full text-sm border-gray-300 p-2.5 
                        dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        :placeholder="modelSettings.video.type === 'youtube' ? 'https://youtu.be/GgeTnpTkzI0' : 'https://vimeo.com/44437887'">
                        <button v-if="modelSettings.video.type === 'youtube'"
                            class="inline-flex items-center px-3 
                            text-sm text-white bg-[#38B2AC] border 
                            border-r-0 border-[#38B2AC] 
                            dark:bg-[#38B2AC] dark:text-white 
                            dark:border-[#38B2AC]">
                            <font-awesome-icon icon="fa-solid fa-eye" class="mr-2" />
                            Preview
                        </button>
                    </div>
                </div>
                <!-- Title -->
                <div class="mt-4">
                    <label for="title" 
                        class="block mb-2 text-sm font-medium flex
                        text-gray-900 dark:text-white capitalize gap-2">
                        <font-awesome-icon icon="fa-solid fa-heading" class="mt-0.5" />
                        Title
                    </label>
                    <div class="flex">
                        <input type="text" id="title" v-model="modelSettings.title"
                        class="rounded-none bg-gray-50 
                        border text-gray-900 focus:ring-blue-500 
                        focus:border-blue-500 block flex-1 min-w-0 
                        w-full text-sm border-gray-300 p-2.5 
                        dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Page Title">
                    </div>
                </div>
                <!-- Description -->
                <div class="mt-4">
                    <label for="title" 
                        class="block mb-2 text-sm font-medium flex
                        text-gray-900 dark:text-white capitalize gap-2">
                        <font-awesome-icon icon="fa-solid fa-pencil" class="mt-0.5" />
                        Description
                    </label>
                    <div>
                        <editor 
                            api-key="nz91pgequ1i4nogj6arnwzcz01gd4h5d43gbnj6pdvyfdzzx" 
                            v-model="modelSettings.description" 
                        />
                    </div>
                </div>
                <!-- Text color -->
                <div class="mt-4">
                    <label for="title" 
                        class="block mb-2 text-sm font-medium flex
                        text-gray-900 dark:text-white capitalize gap-2">
                        <font-awesome-icon icon="fa-solid fa-paint-brush" class="mt-0.5" />
                        Text Color
                    </label>
                    <div class="flex">
                        <input type="text" id="title" 
                        v-model="modelSettings.textColor"
                        class="rounded-none bg-gray-50 
                        border text-gray-900 focus:ring-blue-500 
                        focus:border-blue-500 block flex-1 min-w-0 
                        w-full text-sm border-gray-300 p-1 
                        dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white cursor-pointer
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Text color"
                        @click="textPicker.show = true"
                        @blur="textPicker.show = false"
                        :style="{background: modelSettings.textColor}">
                    </div>
                    <div class="flex justify-end relative">
                        <ColorPicker
                            class="absolute bottom-0"
                            theme="light"
                            :color="modelSettings.textColor"
                            :sucker-hide="true"
                            :sucker-canvas="textPicker.suckerCanvas"
                            :sucker-area="textPicker.suckerArea"
                            @changeColor="changeTextColor"
                            v-show="textPicker.show"/>
                    </div>
                </div>
                <!-- Background type -->
                <div class="mt-4">
                    <label for="target-type" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        <font-awesome-icon icon="fa-solid fa-palette" />
                        Background Type
                    </label>
                    <select id="target-type" v-model="modelSettings.bckgd.type"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="preset">Preset</option>
                        <option value="gradient">Custom Gradient</option>
                        <option value="color">Custom Color</option>
                        <option value="image">Custom Image</option>
                    </select>
                </div>
                <!-- Background type content -->
                <div class="mt-4">
                    <div v-if="modelSettings.bckgd.type === 'preset'">
                        <div class="grid grid-cols-12 gap-4">
                            <div v-for="(item, i) in biolinkBckgd.preset" :key="i"
                                class="col-span-4 cursor-pointer">
                                <label :for="'background-' + i">
                                    <input type="radio" name="biolink-background" :id="'background-' + i"
                                        :value="item.color" v-model="modelSettings.bckgd.presetbckg" 
                                        class="hidden">
                                    <div class="w-full h-20 rounded-md" :style="item.color"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div v-if="modelSettings.bckgd.type === 'gradient'">
                        <label for="color-one" 
                            class="block mb-2 text-sm font-normal flex
                            text-gray-900 dark:text-white capitalize gap-2">
                            Color One
                        </label>
                        <div class="flex">
                            <input type="text" id="color-one" 
                            v-model="modelSettings.bckgd.grad1"
                            class="rounded-none bg-gray-50 
                            border text-gray-900 focus:ring-blue-500 
                            focus:border-blue-500 block flex-1 min-w-0 
                            w-full text-sm border-gray-300 p-1 
                            dark:bg-gray-700 dark:border-gray-600 cursor-pointer
                            dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Text color"
                            @click="grad1ColorPicker.show = true"
                            @blur="grad1ColorPicker.show = false"
                            :style="{background: modelSettings.bckgd.grad1}">
                        </div>
                        <div class="flex justify-end relative">
                            <ColorPicker
                                class="absolute bottom-0"
                                theme="light"
                                :color="modelSettings.bckgd.grad1"
                                :sucker-hide="true"
                                :sucker-canvas="grad1ColorPicker.suckerCanvas"
                                :sucker-area="grad1ColorPicker.suckerArea"
                                @changeColor="changeGrad1Color"
                                v-show="grad1ColorPicker.show"/>
                        </div>

                        <label for="color-two" 
                            class="block mb-2 text-sm font-normal flex mt-4
                            text-gray-900 dark:text-white capitalize gap-2">
                            Color Two
                        </label>
                        <div class="flex">
                            <input type="text" id="color-two" 
                            v-model="modelSettings.bckgd.grad2"
                            class="rounded-none bg-gray-50 
                            border text-gray-900 focus:ring-blue-500 
                            focus:border-blue-500 block flex-1 min-w-0 
                            w-full text-sm border-gray-300 p-1 
                            dark:bg-gray-700 dark:border-gray-600 cursor-pointer
                            dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Text color"
                            @click="grad2ColorPicker.show = true"
                            @blur="grad2ColorPicker.show = false"
                            :style="{background: modelSettings.bckgd.grad2}">
                        </div>
                        <div class="flex justify-end relative">
                            <ColorPicker
                                class="absolute bottom-0"
                                theme="light"
                                :color="modelSettings.bckgd.grad2"
                                :sucker-hide="true"
                                :sucker-canvas="grad2ColorPicker.suckerCanvas"
                                :sucker-area="grad2ColorPicker.suckerArea"
                                @changeColor="changeGrad2Color"
                                v-show="grad2ColorPicker.show"/>
                        </div>
                    </div>
                    <div v-if="modelSettings.bckgd.type === 'color'">
                        <label for="custom-color" 
                            class="block mb-2 text-sm font-normal flex
                            text-gray-900 dark:text-white capitalize gap-2">
                            Custom Color
                        </label>
                        <div class="flex">
                            <input type="text" id="custom-color" 
                            v-model="modelSettings.bckgd.color"
                            class="rounded-none bg-gray-50 
                            border text-gray-900 focus:ring-blue-500 
                            focus:border-blue-500 block flex-1 min-w-0 
                            w-full text-sm border-gray-300 p-1 
                            dark:bg-gray-700 dark:border-gray-600 cursor-pointer
                            dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Text color"
                            @click="bckgdColorPicker.show = true"
                            @blur="bckgdColorPicker.show = false"
                            :style="{background: modelSettings.bckgd.color}">
                        </div>
                        <div class="flex justify-end relative">
                            <ColorPicker
                                class="absolute bottom-0"
                                theme="light"
                                :color="modelSettings.bckgd.color"
                                :sucker-hide="true"
                                :sucker-canvas="bckgdColorPicker.suckerCanvas"
                                :sucker-area="bckgdColorPicker.suckerArea"
                                @changeColor="changeBckgdColor"
                                v-show="bckgdColorPicker.show"/>
                        </div>
                    </div>
                    <div v-if="modelSettings.bckgd.type === 'image'">
                        <span class="text-sm font-normal text-gray-700">Custom Image</span>
                        <input class="block w-full mt-3 text-sm 
                            text-gray-900 bg-gray-50 rounded-lg border 
                            border-gray-300 cursor-pointer focus:outline-none"
                            @change="uploadFile($event)"
                            id="file_input" 
                            type="file">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import Editor from '@tinymce/tinymce-vue'
import { ColorPicker } from 'vue-color-kit';
import 'vue-color-kit/dist/vue-color-kit.css';
import helper from '../../../helpers';
import biolinkBckgd from '../../../includes/biolink-background'

const props = defineProps({
    data: Object,
    dataSettings: Object
});
const emit = defineEmits(['updateSettings'])

let model = ref(props.data);
let modelSettings = ref(props.dataSettings);
let textPicker = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});

let bckgdColorPicker = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});

let grad1ColorPicker = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});
let grad2ColorPicker = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep:true});

watch(() => props.dataSettings, (newVal, oldVal) => {
    modelSettings.value = newVal
}, {deep:true});

watch(model, (newVal, oldVal) => {
    emit('updateSettings', model.value, modelSettings.value)
}, {deep:true})

watch(modelSettings, (newVal, oldVal) => {
    emit('updateSettings', model.value, modelSettings.value)
    console.log(modelSettings.value.bckgd.presetbckg)
}, {deep:true})

function changeTextColor(color) {
    const { r, g, b, a } = color.rgba
    textPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    textPicker.value.colorHex = color.hex
    modelSettings.value.textColor = color.hex
}

function changeBckgdColor(color) {
    const { r, g, b, a } = color.rgba
    bckgdColorPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    bckgdColorPicker.value.colorHex = color.hex
    modelSettings.value.bckgd.color = color.hex
}

function changeGrad1Color(color) {
    const { r, g, b, a } = color.rgba
    grad1ColorPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    grad1ColorPicker.value.colorHex = color.hex
    modelSettings.value.bckgd.grad1 = color.hex
}

function changeGrad2Color(color) {
    const { r, g, b, a } = color.rgba
    grad2ColorPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    grad2ColorPicker.value.colorHex = color.hex
    modelSettings.value.bckgd.grad2 = color.hex
}

function uploadFile(ev) {
    const file = ev.target.files[0];
    const reader = new FileReader();

    reader.onload = () => {
        modelSettings.value.bckgd.image = reader.result;
    }
    reader.readAsDataURL(file);
}

</script>

<style>

</style>