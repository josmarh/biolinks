<template>
    <form @submit.prevent="updateWhatsapp" class="p-4">
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
        <title-field :data="model.sectionFields.title" @update="updateTitle"/>
        <description-field :data="model.sectionFields.description" @update="updateDescription"/>
        <div class="mt-4">
            <label for="whatsappNumber" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <svg role="img" class="mt-0.5 w-3 h-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <title>WhatsApp</title>
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Whatsapp Number
            </label>
            <div class="flex">
                <input type="text" id="whatsappNumber" 
                v-model="model.sectionFields.whatsappNumber"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="+1xxxxxxxxx" required>
            </div>
        </div>
        <button-text-field :data="model.buttonText" @update="updateButtonText"/>
        <title-color-field :data="model.sectionFields.titleColor" @update="updateTitleColor"/>
        <button-text-color-field :data="model.buttonTextColor" @update="updateButtonTextColor"/>
        <button-bg-color-field :data="model.buttonBgColor" @update="updateButtonBckgColor"/>

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
import FileUpload from '../../customfields/FileUpload.vue';
import VideoLinkFields from '../../customfields/VideoLinkFields.vue';
import TitleField from '../../customfields/TitleField.vue';
import DescriptionField from '../../customfields/DescriptionField.vue';
import ButtonTextField from '../../customfields/ButtonTextField.vue';
import biolinksection from '../../../store/biolink-section';
import TitleColorField from '../../customfields/TitleColorField.vue';
import ButtonTextColorField from '../../customfields/ButtonTextColorField.vue';
import ButtonBgColorField from '../../customfields/ButtonBgColorField.vue';

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
function updateButtonText(data) {
    model.value.buttonText = data
}
function updateTitleColor(data) {
    model.value.sectionFields.titleColor = data
}
function updateButtonTextColor(data) {
    model.value.buttonTextColor = data
}
function updateButtonBckgColor(data) {
    model.value.buttonBgColor = data
}

function updateWhatsapp() {
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