<template>
    <modal-layout title="Create a Text Block" :show-form="open" @close-modal="closeModal">
        <form @submit.prevent="newTextBlock">
            <p class="text-md text-gray-600 font-normal mt-8 tracking-tight">
                Add a title and a description with the Text Block.
            </p>
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
            <link-field :data="model.sectionFields.link" label="Link" :required="linkRequired" @update="updateLink" />
            <button-text-field :data="model.buttonText" @update="updateButtonText" />
            <div class="bg-gray-50 px-4 py-4 sm:flex mt-4
                sm:flex-row-reverse sm:px-6 mb-6 justify-center ">
                <button type="submit" 
                    class="inline-flex w-full
                    border border-transparent bg-blue-600 px-4 py-2 text-base 
                    font-medium text-white shadow-sm hover:bg-blue-700 
                    focus:outline-none focus:ring-0 focus:ring-blue-500 
                    focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm" 
                    :disabled="isDisabled">
                    Add Block
                    <button-spinner v-if="isDisabled" class="pl-2"/>
                </button>
            </div>
        </form>
    </modal-layout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { notify } from 'notiwind';
import ButtonSpinner from '../../ButtonSpinner.vue';
import ModalLayout from './ModalLayout.vue'
import FileUpload from '../../customfields/FileUpload.vue';
import VideoLinkFields from '../../customfields/VideoLinkFields.vue';
import TitleField from '../../customfields/TitleField.vue';
import DescriptionField from '../../customfields/DescriptionField.vue';
import LinkField from '../../customfields/LinkField.vue';
import ButtonTextField from '../../customfields/ButtonTextField.vue';
import biolinksection from '../../../store/biolink-section';

const route = useRoute();
const props = defineProps({
    showForm: Boolean
});
const emit = defineEmits(['closeForm'])
const open = ref(props.showForm)
const linkRequired = false

let isDisabled = ref(false)
let model = ref({
    linkId: route.params.linkId,
    sectionName: 'Text Block',
    buttonText: '',
    buttonTextColor: '#000000',
    buttonBckgColor: '#FFFFFF',
    sectionFields: {
        type: 'image',
        typeContentImage: null,
        typeContentVideo: 'youtube',
        typeContentVideoUrl: '',
        title: '',
        titleColor: '#000000',
        description: '',
        link: ''
    }
})

watch(() => props.showForm, (newVal, oldVal) => {
    open.value = newVal
})

watch(open, (newVal, oldVal) => {
    if(!newVal)
        emit('closeForm');
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

function closeModal() {
    open.value = false
}

function newTextBlock() {
    isDisabled.value = true
    if(model.value.sectionFields.type == 'video')
        model.value.sectionFields.typeContentImage == null;
    else if(model.value.sectionFields.type == 'image')
        model.value.sectionFields.typeContentVideoUrl = ''

    biolinksection
        .dispatch('storeSection', {
            linkId: route.params.linkId,
            sectionName: model.value.sectionName,
            buttonText: model.value.buttonText,
            buttonTextColor: model.value.buttonTextColor,
            buttonBckgColor: model.value.buttonBckgColor,
            sectionFields: JSON.stringify(model.value.sectionFields)
        })
        .then((res) => {
            isDisabled.value = false
            emit('closeForm');
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
        })
        .catch((err) => {
            isDisabled.value = false
            emit('closeForm');

            let errMsg;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message"))
                        errMsg = err.response.data.message;
                    else
                        errMsg = err.response.data.error;
                }
            }else{
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