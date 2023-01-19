<template>
    <modal-layout title="Create a New Link" :show-form="open" @close-modal="closeModal">
        <form @submit.prevent="newLink">
            <p class="text-md text-gray-600 font-normal mt-8 tracking-tight">
                Add a new link to you biolink page. More settings 
                are available after the creation of the link.
            </p>

            <!-- <div class="mt-4">
                <label class="block mb-2 text-sm font-medium flex
                    text-gray-900 dark:text-white capitalize gap-2">
                    <font-awesome-icon icon="fa-solid fa-shuffle" class="mt-0.5" />
                    Type
                </label>
                <div class="inline-flex gap-3">
                    <div class="flex items-center">
                        <input id="internal" type="radio" value="internal" name="internal" 
                            v-model="model.sectionFields.type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 
                            border-gray-300 focus:ring-blue-500 
                            dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                            focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="internal" 
                            class="ml-2 text-sm font-medium 
                            text-gray-900 dark:text-gray-300">
                            Internal
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input id="external" type="radio" value="external" name="internal" 
                            v-model="model.sectionFields.type"
                            class="w-4 h-4 text-blue-600 bg-gray-100 
                            border-gray-300 focus:ring-blue-500 
                            dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                            focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="external" 
                            class="ml-2 text-sm font-medium 
                            text-gray-900 dark:text-gray-300">
                            External
                        </label>
                    </div>
                </div>
            </div> -->

            <div class="mt-4">
                <label for="destinationURL" 
                    class="block mb-2 text-sm font-medium flex
                    text-gray-900 dark:text-white capitalize gap-2">
                    <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5" />
                    Destination Url
                </label>
                <input v-model="model.sectionFields.destinationURL"
                    type="url" name="destinationURL" id="destinationURL" 
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
                    Add URL
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
import biolinksection from '../../../store/biolink-section';

const route = useRoute();
const props = defineProps({
    showForm: Boolean
});
const emit = defineEmits(['closeForm'])
const open = ref(props.showForm)

let isDisabled = ref(false)
let model = ref({
    linkId: route.params.linkId,
    sectionName: 'Link',
    buttonText: 'Your own link here',
    buttonTextColor: '#000000',
    buttonBckgColor: '#FFFFFF',
    sectionFields: {
        type: 'internal',
        destinationURL:  '',
        scheduleSwitch: 'no',
        scheduleStart: dformat(new Date()),
        scheduleEnd: dformat(new Date()),
        clickLimit: 5,
        redirectURL: '',
        buttonIcon: '',
        buttonOutline: 'no',
        borderRadius: 'rounded',
        animation: ''
    }
})

watch(() => props.showForm, (newVal, oldVal) => {
    open.value = newVal
})

watch(open, (newVal, oldVal) => {
    if(!newVal)
        emit('closeForm');
})

function newLink() {
    isDisabled.value = true
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

function closeModal() {
    open.value = false
}

function dformat(date) {
    let d = new Date(date);
    const day = d.getDate() <= 9 == 1 ? `0${d.getDate()}` : d.getDate();
    const month = d.getMonth()+1  <= 9 == 1 ? `0${d.getMonth()+1}` : d.getMonth()+1;
    const year = d.getFullYear();
    const time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    return `${year}-${month}-${day} ${time}`;
}
</script>

<style>

</style>