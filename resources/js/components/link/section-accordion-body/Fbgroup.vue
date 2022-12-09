<template>
    <form @submit.prevent="updateFbgroup" class="p-4">
        <div class="mt-4">
            <div class="inline-flex gap-3">
                <div class="flex items-center">
                    <input id="Image" type="radio" value="image" name="type" 
                        v-model="model.sectionFields.type"
                        class="w-4 h-4 text-blue-600 bg-gray-100 
                        border-gray-300 focus:ring-blue-500 
                        dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                        focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="Image" 
                        class="ml-2 text-sm font-medium 
                        text-gray-900 dark:text-gray-300">
                        Image
                    </label>
                </div>
                <div class="flex items-center">
                    <input id="Video" type="radio" value="video" name="type" 
                        v-model="model.sectionFields.type"
                        class="w-4 h-4 text-blue-600 bg-gray-100 
                        border-gray-300 focus:ring-blue-500 
                        dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                        focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="Video" 
                        class="ml-2 text-sm font-medium 
                        text-gray-900 dark:text-gray-300">
                        Video
                    </label>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <file-upload 
                v-if="model.sectionFields.type == 'image'"
                :data="model.sectionFields.typeContentImage" 
                @update="updateImage" 
            />
            <video-link-fields 
                v-if="model.sectionFields.type == 'video'"
                :videoType="model.sectionFields.typeContentVideo"
                :videoURL="model.sectionFields.typeContentVideoUrl"
                @update="updateVideo" 
            />
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
                <input type="text" id="title" v-model="model.sectionFields.title"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="" required>
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
                    v-model="model.sectionFields.description" class="z-0"
                />
            </div>
        </div>
        <!-- fb group link -->
        <div class="mt-4">
            <label for="fbGroupLink" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Facebook Group Link
            </label>
            <input v-model="model.sectionFields.fbGroupLink"
                type="url" name="fbGroupLink" id="fbGroupLink" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="" required>
        </div>
        <!-- button text -->
        <div class="mt-4">
            <label for="buttonText" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Button
            </label>
            <input v-model="model.buttonText"
                type="text" name="buttonText" id="buttonText" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="" required>
        </div>
        <!-- title color -->
        <div class="mt-4">
            <label for="titleColor" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-paint-brush" class="mt-0.5" />
                Title Color
            </label>
            <div class="flex">
                <input type="text" id="titleColor" 
                v-model="model.sectionFields.titleColor"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-1 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white cursor-pointer
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Text color"
                @click="titleColorPicker.show = true"
                @blur="titleColorPicker.show = false"
                :style="{background: model.sectionFields.titleColor}">
            </div>
            <div class="flex justify-end relative">
                <ColorPicker
                    class="absolute bottom-0"
                    theme="light"
                    :color="model.sectionFields.titleColor"
                    :sucker-hide="true"
                    :sucker-canvas="titleColorPicker.suckerCanvas"
                    :sucker-area="titleColorPicker.suckerArea"
                    @changeColor="changeTitleColor"
                    v-show="titleColorPicker.show"/>
            </div>
        </div>
        <!-- Button Text color -->
        <div class="mt-4">
            <label for="btnTextColor2" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-paint-brush" class="mt-0.5" />
                Button Text Color
            </label>
            <div class="flex">
                <input type="text" id="btnTextColor2" 
                v-model="model.buttonTextColor"
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
                :style="{background: model.buttonTextColor}">
            </div>
            <div class="flex justify-end relative">
                <ColorPicker
                    class="absolute bottom-0"
                    theme="light"
                    :color="model.buttonTextColor"
                    :sucker-hide="true"
                    :sucker-canvas="textPicker.suckerCanvas"
                    :sucker-area="textPicker.suckerArea"
                    @changeColor="changeTextColor"
                    v-show="textPicker.show"/>
            </div>
        </div>
        <!-- Button Background Color -->
        <div class="mt-4">
            <label for="btnBgcolor" 
                class="block mb-2 text-sm font-normal flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-palette" class="mt-0.5" />
                Button Background Color
            </label>
            <div class="flex">
                <input type="text" id="btnBgcolor" 
                v-model="model.buttonBgColor"
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
                :style="{background: model.buttonBgColor}">
            </div>
            <div class="flex justify-end relative">
                <ColorPicker
                    class="absolute bottom-0"
                    theme="light"
                    :color="model.buttonBgColor"
                    :sucker-hide="true"
                    :sucker-canvas="bckgdColorPicker.suckerCanvas"
                    :sucker-area="bckgdColorPicker.suckerArea"
                    @changeColor="changeBckgdColor"
                    v-show="bckgdColorPicker.show"/>
            </div>
        </div>

        <button type="submit" 
            class="w-full text-white bg-blue-700 
            hover:bg-blue-800 focus:ring-0 mt-6
            focus:outline-none focus:ring-blue-300 
            font-medium text-sm px-5 py-2.5 
            text-center dark:bg-blue-600 dark:hover:bg-blue-700 
            dark:focus:ring-blue-800"
            :disabled="isDisabled">
            Update
        </button>
    </form>
</template>

<script setup>
import { ref, watch } from 'vue';
import { notify } from 'notiwind';
import { ColorPicker } from 'vue-color-kit';
import 'vue-color-kit/dist/vue-color-kit.css';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import FileUpload from '../../customfields/FileUpload.vue'
import VideoLinkFields from '../../customfields/VideoLinkFields.vue';
import Editor from '@tinymce/tinymce-vue'
import biolinksection from '../../../store/biolink-section';

const props = defineProps({
    data: Object
});

const emit = defineEmits(['reloadSettings'])

let model = ref(props.data)
let isDisabled = ref(false)

let titleColorPicker = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});
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

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function changeTitleColor(color) {
    const { r, g, b, a } = color.rgba
    titleColorPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    titleColorPicker.value.colorHex = color.hex
    model.value.sectionFields.titleColor = color.hex
}

function changeTextColor(color) {
    const { r, g, b, a } = color.rgba
    textPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    textPicker.value.colorHex = color.hex
    model.value.buttonTextColor = color.hex
}

function changeBckgdColor(color) {
    const { r, g, b, a } = color.rgba
    bckgdColorPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    bckgdColorPicker.value.colorHex = color.hex
    model.value.buttonBgColor = color.hex
}

function updateImage(data) {
    model.value.sectionFields.typeContentImage = data
}

function updateVideo(data) {
    model.value.sectionFields.typeContentVideo = data.type
    model.value.sectionFields.typeContentVideoUrl = data.url
}

function updateFbgroup() {
    isDisabled.value = true
    biolinksection
        .dispatch('updateSection', {
            id: model.value.id,
            buttonText: model.value.buttonText,
            buttonTextColor: model.value.buttonTextColor,
            buttonBgColor: model.value.buttonBgColor,
            sectionFields: JSON.stringify(model.value.sectionFields)
        })
        .then((res) => {
            isDisabled.value = false;
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
            emit('reloadSettings')
        })
        .catch((err) => {
            isDisabled.value = false;
            let errMsg;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message"))
                        errMsg = err.response.data.message;
                    else
                        errMsg = err.response.data.error;
                }
            }else {
                errMsg = err;
            }
            notify({
                group: "error",
                title: "Error",
                text: errMsg
            }, 4000);
        })
}
</script>

<style>

</style>