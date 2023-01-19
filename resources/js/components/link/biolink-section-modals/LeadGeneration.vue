<template>
    <modal-layout title="Add a Lead Generation form" :show-form="open" @close-modal="closeModal">
        <form @submit.prevent="newLeadGeneration">
            <p class="text-md text-gray-600 font-normal mt-8 tracking-tight">
                Capture Leads and get them sent to you by Email or via Webhook.
            </p>

            <div class="bg-gray-50 px-4 py-4 sm:flex 
                sm:flex-row-reverse sm:px-6 mb-6 justify-center ">
                <button type="submit" 
                    class="inline-flex w-full
                    border border-transparent bg-blue-600 px-4 py-2 text-base 
                    font-medium text-white shadow-sm hover:bg-blue-700 
                    focus:outline-none focus:ring-0 focus:ring-blue-500 
                    focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm" 
                    :disabled="isDisabled">
                    Add Form
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
import leadgenFields from '../../../includes/leadgen-default-fields'

const route = useRoute();
const props = defineProps({
    showForm: Boolean
});
const emit = defineEmits(['closeForm'])
const open = ref(props.showForm)

let isDisabled = ref(false)
let model = ref({
    linkId: route.params.linkId,
    sectionName: 'Lead Generation',
    buttonText: 'Sign Up',
    buttonTextColor: '#000000',
    buttonBckgColor: '#FFFFFF',
    sectionFields: JSON.stringify(leadgenFields)
})

watch(() => props.showForm, (newVal, oldVal) => {
    open.value = newVal
})

watch(open, (newVal, oldVal) => {
    if(!newVal)
        emit('closeForm');
})

function newLeadGeneration() {
    isDisabled.value = true
    biolinksection
        .dispatch('storeSection', model.value)
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
</script>

<style>

</style>