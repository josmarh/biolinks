<template>
    <form @submit.prevent="updateCalendly" class="p-4">
        <title-field :data="model.sectionFields.title" @update="updateTitle"/>
        <description-field :data="model.sectionFields.description" @update="updateDescription"/>
        <link-field
            :data="model.sectionFields.calendlyLink"
            :required="isRequired"
            label="Calendly Link URL"
            placeholder=""
            @update="updateLink"/>
        <button-text-field :data="model.buttonText" @update="updateButtonText"/>
        <title-color-field :data="model.sectionFields.titleColor" @update="updateColor"/>
        <button-text-color-field :data="model.buttonTextColor" @update="updateColor"/>
        <button-bg-color-field :data="model.buttonBgColor" @update="updateColor"/>
        
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
import TitleField from '../../customfields/TitleField.vue';
import TitleColorField from '../../customfields/TitleColorField.vue';
import DescriptionField from '../../customfields/DescriptionField.vue'
import LinkField from '../../customfields/LinkField.vue';
import ButtonTextField from '../../customfields/ButtonTextField.vue';
import ButtonTextColorField from '../../customfields/ButtonTextColorField.vue';
import ButtonBgColorField from '../../customfields/ButtonBgColorField.vue';
import biolinksection from '../../../store/biolink-section';

const props = defineProps({
    data: Object
});

const emit = defineEmits(['reloadSettings'])

let model = ref(props.data)
let isDisabled = ref(false)
let isRequired = true

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function updateTitle(data) {
    model.value.sectionFields.title = data
}
function updateDescription(data) {
    model.value.sectionFields.description = data
}
function updateLink(data) {
    model.value.sectionFields.calendlyLink = data
}
function updateButtonText(data) {
    model.value.buttonText = data
}
function updateColor(data, type) {
    if(type == 'titleColor')
        model.value.sectionFields.titleColor = data
    else if(type == 'btnTextColor')
        model.value.buttonTextColor = data
    else if(type == 'btnBgColor')
        model.value.buttonBgColor = data
}

function updateCalendly() {
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