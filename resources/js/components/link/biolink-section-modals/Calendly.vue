<template>
    <modal-layout title="Add a Calendly Block" :show-form="open" @close-modal="closeModal">
        <form @submit.prevent="newCalendly">
            <p class="text-md text-gray-600 font-normal mt-8 tracking-tight">
                Add a title and a text with the Calendly Block.
            </p>
            <title-field :data="model.sectionFields.title" @update="updateTitle"/>
            <description-field :data="model.sectionFields.description" @update="updateDescription"/>
            <link-field 
                :data="model.sectionFields.calendlyLink"
                :required="isRequired"
                label="Calendly Link URL"
                placeholder=""
                @update="updateLink"/>
            
            <div class="bg-gray-50 px-4 py-4 sm:flex mt-4
                sm:flex-row-reverse sm:px-6 mb-6 justify-center">
                <button type="submit"
                    class="inline-flex w-full
                    border border-transparent bg-blue-600 px-4 py-2 text-base 
                    font-medium text-white shadow-sm hover:bg-blue-700 
                    focus:outline-none focus:ring-0 focus:ring-blue-500 
                    focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm" 
                    :disabled="isDisabled">
                    Add Calendar
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
import TitleField from '../../customfields/TitleField.vue';
import DescriptionField from '../../customfields/DescriptionField.vue';
import LinkField from '../../customfields/LinkField.vue';
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
    sectionName: 'Calendly',
    buttonText: 'Sign up',
    buttonTextColor: '#000000',
    buttonBckgColor: '#FFFFFF',
    sectionFields: {
        title: '',
        titleColor: '#000000',
        description: '',
        calendlyLink: ''
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

function updateTitle(data) {
    model.value.sectionFields.title = data
}
function updateDescription(data) {
    model.value.sectionFields.description = data
}
function updateLink(data) {
    model.value.sectionFields.calendlyLink = data
}

function newCalendly() {
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