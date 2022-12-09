<template>
    <modal-layout title="Link Your Facebook Group" :show-form="open" @close-modal="closeModal">
        <form @submit.prevent="newFbGroup">
            <p class="text-md text-gray-600 font-normal mt-8 tracking-tight">
                Add a title and a text with the Facebook Block.
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
import Editor from '@tinymce/tinymce-vue'
import ButtonSpinner from '../../ButtonSpinner.vue';
import ModalLayout from './ModalLayout.vue'
import FileUpload from '../../FileUpload.vue';
import VideoLinkFields from '../../VideoLinkFields.vue';
import biolinksection from '../../../store/biolink-section';

const route = useRoute();
const props = defineProps({
    showForm: Boolean
});
const emit = defineEmits(['closeForm'])
const open = ref(props.showForm)

let isDisabled = ref(false)
let model = ref({
    linkId: route.params.id,
    sectionName: 'Facebook Group',
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
        fbGroupLink: '',
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

function closeModal() {
    open.value = false
}

function newFbGroup() {
    isDisabled.value = true
    if(model.value.sectionFields.type == 'video')
        model.value.sectionFields.typeContentImage == null;
    else if(model.value.sectionFields.type == 'image')
        model.value.sectionFields.typeContentVideoUrl = ''

    biolinksection
        .dispatch('storeSection', {
            linkId: route.params.id,
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