<template>
    <modal-layout title="Create a HTML/ js Block" :show-form="open" @close-modal="closeModal">
        <form @submit.prevent="newHtmlJsBlock">
            <p class="text-md text-gray-600 font-normal mt-8 tracking-tight">
                Add a HTML/ js Block.
            </p>
            <div class="mt-4">
                <label for="html-js-block" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    HTML/ js Code
                </label>
                <textarea id="html-js-block" rows="4" 
                    v-model="model.sectionFields.codeBlock"
                    class="block p-2.5 w-full text-sm text-gray-900 
                    bg-gray-50 rounded-lg border border-gray-300 
                    focus:ring-blue-500 focus:border-blue-500 
                    dark:bg-gray-700 dark:border-gray-600 
                    dark:placeholder-gray-400 dark:text-white 
                    dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    placeholder=""></textarea>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:flex mt-4
                sm:flex-row-reverse sm:px-6 mb-6 justify-center">
                <button type="submit"
                    class="inline-flex w-full
                    border border-transparent bg-blue-600 px-4 py-2 text-base 
                    font-medium text-white shadow-sm hover:bg-blue-700 
                    focus:outline-none focus:ring-0 focus:ring-blue-500 
                    focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                    :disabled="isDisabled">
                    Add
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
let isRequired = true
let model = ref({
    linkId: route.params.linkId,
    sectionName: 'HtmlJsBlock',
    buttonText: '',
    buttonTextColor: '#000000',
    buttonBckgColor: '#FFFFFF',
    sectionFields: {
        codeBlock: ''
    }
})

watch(() => props.showForm, (newVal, oldVal) => {
    open.value = newVal
})
watch(open, (newVal, oldVal) => {
    if(!newVal)
        emit('closeForm');
})

function closeModal() {
    open.value = false
}

function newHtmlJsBlock() {
    isDisabled.value = true;
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