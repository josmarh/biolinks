<template>
    <form @submit.prevent="updateLinkBlock" class="p-4">
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
        <title-field :data="model.sectionFields.title" @update="updateTitle" />
        <description-field :data="model.sectionFields.description" @update="updateDescription" />
        <link-field :data="model.sectionFields.link" label="Link" @update="updateLink" />
        <button-text-field :data="model.buttonText" @update="updateButtonText" />
        <title-color-field :data="model.sectionFields.titleColor" @update="updateColor" />
        <button-text-color-field :data="model.buttonTextColor" @update="updateColor" />
        <button-bg-color-field :data="model.buttonBgColor" @update="updateColor" />

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
import TitleField from '../../customfields/TitleField.vue';
import DescriptionField from '../../customfields/DescriptionField.vue';
import LinkField from '../../customfields/LinkField.vue';
import ButtonTextField from '../../customfields/ButtonTextField.vue';
import TitleColorField from '../../customfields/TitleColorField.vue';
import ButtonTextColorField from '../../customfields/ButtonTextColorField.vue'
import ButtonBgColorField from '../../customfields/ButtonBgColorField.vue';
import biolinksection from '../../../store/biolink-section';

const props = defineProps({
    data: Object
});

const emit = defineEmits(['reloadSettings'])

let model = ref(props.data)
let isDisabled = ref(false)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function updateImage(data) {
    model.value.sectionFields.typeContentImage = data
}

function updateVideo(data) {
    model.value.sectionFields.typeContentVideo = data.type
    model.value.sectionFields.typeContentVideoUrl = data.url
}

function updateTitle(data) {
    model.value.sectionFields.title = data
}

function updateDescription(data) {
    model.value.sectionFields.description = data
}

function updateLink(data) {
    model.value.sectionFields.link = data
}

function updateButtonText(data) {
    model.value.buttonText = data
}

function updateColor(data, type) {
    if(type == 'titleColor')
        model.value.sectionFields.titleColor = data;
    else if(type == 'btnTextColor')
        model.value.buttonTextColor = data;
    else if(type == 'btnBgColor')
        model.value.buttonBgColor = data;
}

function updateLinkBlock() {
    isDisabled.value = true
    if(model.value.sectionFields.type == 'video')
        model.value.sectionFields.typeContentImage == null;
    else if(model.value.sectionFields.type == 'image')
        model.value.sectionFields.typeContentVideoUrl = ''

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