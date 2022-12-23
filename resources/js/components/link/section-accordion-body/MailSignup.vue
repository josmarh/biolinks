<template>
    <form @submit.prevent="updateMailSignup" class="p-4">
        <name-field 
            :data="model.sectionFields.name" 
            :isRequired="requiredFields.name"
            @update="updateName"/>
        <button-icon-field :data="model.sectionFields.buttonIcon" @update="updateIcon"/>
        <button-text-field :data="model.buttonText" @update="updateButtonText"/>
        <button-text-color-field :data="model.buttonTextColor" @update="updateBtnTextColor"/>
        <button-bg-color-field :data="model.buttonBgColor" @update="updateBtnBgColor"/>
        <button-outline-field :data="model.sectionFields.buttonOutline" @update="updateBtnOutline"/>
        <button-border-radius-field :data="model.sectionFields.borderRadius" @update="updateBtnBorderRadius"/>
        <email-placeholder-field 
            :data="model.sectionFields.emailPlaceholder" 
            :isRequired="requiredFields.emailPlaceholder"
            @update="updateEmailPlaceholder"/>
        <thankyou-message-field :data="model.sectionFields.thankYouMsg" @update="updateThankyouMsg"/>
        <show-agreement-field :data="model.sectionFields.showAgreement" @update="updateShowAgreement"/>
        <agreement-text-field :data="model.sectionFields.agreementText" @update="updateAgreementText"/>
        <agreement-url-field :data="model.sectionFields.agreementURL" @update="updateAgreementURL"/>
        <mailchimp-apikey-field :data="model.sectionFields.mailchimpAPIKey" @update="updateMailchimpAPIKey"/>
        <mailchimp-list-field :data="model.sectionFields.mailchimpList" @update="updateMailchimpList"/>
        <webhook-url-field :data="model.sectionFields.webhookURL" @update="updateWebhookURL"/>

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
import NameField from '../../customfields/NameField.vue';
import ButtonIconField from '../../customfields/ButtonIconField.vue';
import ButtonTextField from '../../customfields/ButtonTextField.vue';
import ButtonTextColorField from '../../customfields/ButtonTextColorField.vue';
import ButtonBgColorField from '../../customfields/ButtonBgColorField.vue';
import ButtonOutlineField from '../../customfields/ButtonOutlineField.vue';
import ButtonBorderRadiusField from '../../customfields/ButtonBorderRadiusField.vue';
import EmailPlaceholderField from '../../customfields/EmailPlaceholderField.vue';
import ThankyouMessageField from '../../customfields/ThankyouMessageField.vue'
import ShowAgreementField from '../../customfields/ShowAgreementField.vue';
import AgreementTextField from '../../customfields/AgreementTextField.vue';
import AgreementUrlField from '../../customfields/AgreementUrlField.vue';
import MailchimpApikeyField from '../../customfields/MailchimpApikeyField.vue';
import MailchimpListField from '../../customfields/MailchimpListField.vue';
import WebhookUrlField from '../../customfields/WebhookUrlField.vue';
import biolinksection from '../../../store/biolink-section';

const props = defineProps({
    data: Object
});

const emit = defineEmits(['reloadSettings'])

let model = ref(props.data)
let isDisabled = ref(false)
let requiredFields = {
    name: true,
    emailPlaceholder: false
}

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function updateName(data) {
    model.value.sectionFields.name = data
}
function updateIcon(data) {
    model.value.sectionFields.buttonIcon = data
}
function updateButtonText(data) {
    model.value.buttonText = data
}
function updateBtnTextColor(data) {
    model.value.buttonTextColor = data
}
function updateBtnBgColor(data) {
    model.value.buttonBgColor = data
}
function updateBtnOutline(data) {
    model.value.sectionFields.buttonOutline = data
}
function updateBtnBorderRadius(data) {
    model.value.sectionFields.borderRadius = data
}
function updateEmailPlaceholder(data) {
    model.value.sectionFields.emailPlaceholder = data
}
function updateThankyouMsg(data) {
    model.value.sectionFields.thankYouMsg = data
}
function updateShowAgreement(data) {
    model.value.sectionFields.showAgreement = data
}
function updateAgreementText(data) {
    model.value.sectionFields.agreementText = data
}
function updateAgreementURL(data) {
    model.value.sectionFields.agreementURL = data
}
function updateMailchimpAPIKey(data) {
    model.value.sectionFields.mailchimpAPIKey = data
}
function updateMailchimpList(data) {
    model.value.sectionFields.mailchimpList = data
}
function updateWebhookURL(data) {
    model.value.sectionFields.webhookURL = data
}

function updateMailSignup () {
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