<template>
    <form @submit.prevent="updateLeads" class="p-4">
        <!-- Form name -->
        <div class="mt-4">
            <label for="form-name" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-heading" class="mt-0.5" />
                Form Name
            </label>
            <div class="flex">
                <input type="text" id="form-name" 
                v-model="model.sectionFields.formName"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Form Name" >
            </div>
        </div>
        <!-- Text -->
        <div class="mt-4">
            <label for="text" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-heading" class="mt-0.5" />
                Text
            </label>
            <div class="flex">
                <input type="text" id="text" 
                v-model="model.sectionFields.text"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Text">
            </div>
        </div>
        <!-- Show Phone -->
        <div class="mt-4">
            <label for="show-phone" 
                class="inline-flex relative items-center cursor-pointer">
                <input type="checkbox"
                    id="show-phone" 
                    class="sr-only peer"
                    @change="updateCheckbox($event, 'showPhone')"
                    :checked="model.sectionFields.showPhone == 'yes' ? true : false">
                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                    peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                    peer peer-checked:after:translate-x-full 
                    peer-checked:after:border-white 
                    after:content-[''] after:absolute after:top-[2px] 
                    after:left-[2px] after:bg-white after:border-gray-300 
                    after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                    peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Show Phone
                </span>
            </label>
            <p class="text-sm text-gray-500">
                Show phone number input field by ticking a checkbox.
            </p>
        </div>
        <!-- Require Phone number -->
        <div class="mt-4">
            <label for="require-phone" 
                class="inline-flex relative items-center cursor-pointer">
                <input type="checkbox"
                    id="require-phone" 
                    class="sr-only peer"
                    @change="updateCheckbox($event, 'requirePhone')"
                    :checked="model.sectionFields.requirePhone == 'yes' ? true : false">
                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                    peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                    peer peer-checked:after:translate-x-full 
                    peer-checked:after:border-white 
                    after:content-[''] after:absolute after:top-[2px] 
                    after:left-[2px] after:bg-white after:border-gray-300 
                    after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                    peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Required Phone No.
                </span>
            </label>
            <p class="text-sm text-gray-500">
                Phone number input field required by ticking a checkbox.
            </p>
        </div>
        <!-- Lead notification email address -->
        <div class="mt-4">
            <label for="leadNotifyEmail" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Lead Notification Email Address
            </label>
            <div class="flex">
                <input type="text" id="leadNotifyEmail" 
                v-model="model.sectionFields.leadNotifyEmail"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="" >
            </div>
        </div>
        <!-- Label button text -->
        <div class="mt-4">
            <label for="buttonText" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Label Button Text
            </label>
            <div class="flex">
                <input type="text" id="buttonText" 
                v-model="model.buttonText"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="" >
            </div>
        </div>
        <!-- Button Text color -->
        <div class="mt-4">
            <label for="btnTextColor" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-paint-brush" class="mt-0.5" />
                Button Text Color
            </label>
            <div class="flex">
                <input type="text" id="btnTextColor" 
                v-model="model.buttonTextColor"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-1 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white cursor-pointer
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Text color"
                @click="textPicker.show = true"
                @blur="textPicker.show = false"
                :style="{background: model.buttonTextColor}">
            </div>
            <div class="flex justify-end relative">
                <ColorPicker
                    class="absolute bottom-0"
                    theme="light"
                    :color="model.buttonTextColor"
                    :sucker-hide="true"
                    :sucker-canvas="textPicker.suckerCanvas"
                    :sucker-area="textPicker.suckerArea"
                    @changeColor="changeTextColor"
                    v-show="textPicker.show"/>
            </div>
        </div>
        <!-- Button Background Color -->
        <div class="mt-4">
            <label for="custom-color" 
                class="block mb-2 text-sm font-normal flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-palette" class="mt-0.5" />
                Button Background Color
            </label>
            <div class="flex">
                <input type="text" id="custom-color" 
                v-model="model.buttonBgColor"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-1 
                dark:bg-gray-700 dark:border-gray-600 cursor-pointer
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Text color"
                @click="bckgdColorPicker.show = true"
                @blur="bckgdColorPicker.show = false"
                :style="{background: model.buttonBgColor}">
            </div>
            <div class="flex justify-end relative">
                <ColorPicker
                    class="absolute bottom-0"
                    theme="light"
                    :color="model.buttonBgColor"
                    :sucker-hide="true"
                    :sucker-canvas="bckgdColorPicker.suckerCanvas"
                    :sucker-area="bckgdColorPicker.suckerArea"
                    @changeColor="changeBckgdColor"
                    v-show="bckgdColorPicker.show"/>
            </div>
        </div>
        <!-- Thank You Message -->
        <div class="mt-4">
            <label for="thankYouMsg" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Thank You Message
            </label>
            <div class="flex">
                <input type="text" id="thankYouMsg" 
                v-model="model.sectionFields.thankYouMsg"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="">
            </div>
        </div>
        <!-- Link to Your Website -->
        <div class="mt-4">
            <label for="websiteLink" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Link to Your Website
            </label>
            <div class="flex">
                <input type="url" id="websiteLink" 
                v-model="model.sectionFields.websiteLink"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="https://website.com">
            </div>
        </div>
        <!-- Link Button Text -->
        <div class="mt-4">
            <label for="linkButtonText" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Link Button Text
            </label>
            <div class="flex">
                <input type="text" id="linkButtonText" 
                v-model="model.sectionFields.linkButtonText"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="">
            </div>
        </div>
        <!-- Show Agreement -->
        <div class="mt-4">
            <label for="showAgreement" 
                class="inline-flex relative items-center cursor-pointer">
                <input type="checkbox"
                    id="showAgreement" 
                    class="sr-only peer"
                    @change="updateCheckbox($event, 'showAgreement')"
                    :checked="model.sectionFields.showAgreement == 'yes' ? true : false">
                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                    peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                    peer peer-checked:after:translate-x-full 
                    peer-checked:after:border-white 
                    after:content-[''] after:absolute after:top-[2px] 
                    after:left-[2px] after:bg-white after:border-gray-300 
                    after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                    peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Show Agreement
                </span>
            </label>
            <p class="text-sm text-gray-500">
                Require the user to confirm his agreement by ticking a checkbox.
            </p>
        </div>
        <!-- Agreement Text -->
        <div class="mt-4">
            <label for="agreementText" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Agreement Text
            </label>
            <div class="flex">
                <input type="text" id="agreementText" 
                v-model="model.sectionFields.agreementText"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="">
            </div>
        </div>
        <!-- Agreement URL -->
        <div class="mt-4">
            <label for="agreementURL" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Agreement URL
            </label>
            <div class="flex">
                <input type="url" id="agreementURL" 
                v-model="model.sectionFields.agreementURL"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="https://website.com">
            </div>
        </div>
        <!-- Mailchimp API Key -->
        <div class="mt-4">
            <label for="mailchimpAPIKey" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Mailchimp API Key
            </label>
            <div class="flex">
                <input type="text" id="mailchimpAPIKey" 
                v-model="model.sectionFields.mailchimpAPIKey"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="">
            </div>
            <p class="text-sm text-gray-500">
                Leave empty to disable mailchimp integration. 
                How to get these details: 
                <a href="https://mailchimp.com/developer/guides/manage-subscribers-with-the-mailchimp-api/#Before_you_start" 
                    target="_blank" class="underline">
                    MailChimp Documentation
                </a> 
            </p>
        </div>
        <!-- Mailchimp List -->
        <div class="mt-4">
            <label for="mailchimpList" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Mailchimp List
            </label>
            <div class="flex">
                <input type="text" id="mailchimpList" 
                v-model="model.sectionFields.mailchimpList"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="">
            </div>
            <p class="text-sm text-gray-500">
                Ensure you add the List/Audience ID 
            </p>
        </div>
        <!-- Webhook URL -->
        <div class="mt-4">
            <label for="webhookURL" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Webhook URL
            </label>
            <div class="flex">
                <input type="url" id="webhookURL" 
                v-model="model.sectionFields.webhookURL"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="">
            </div>
            <p class="text-sm text-gray-500">
                Where to send the caught email to. Leave empty to disable.
            </p>
        </div>
        <!--  -->
        <div class="mt-4">
            <label for="customConvertCode" 
                class="block mb-2 text-sm font-medium 
                text-gray-900 dark:text-white">
                Custom Conversion Code
            </label>
            <textarea id="customConvertCode" rows="4" 
                v-model="model.customConvertCode"
                class="block p-2.5 w-full text-sm text-gray-900 
                bg-gray-50 border border-gray-300 
                focus:ring-blue-500 focus:border-blue-500 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder=""></textarea>
        </div>

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
import { ref, watch } from 'vue'
import { notify } from 'notiwind';
import { ColorPicker } from 'vue-color-kit';
import 'vue-color-kit/dist/vue-color-kit.css';
import biolinksection from '../../../store/biolink-section'

const props = defineProps({
    data: Object
});

const emit = defineEmits(['reloadSettings'])

let model = ref(props.data)
let isDisabled = ref(false)

let textPicker = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});

let bckgdColorPicker = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function changeTextColor(color) {
    const { r, g, b, a } = color.rgba
    textPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    textPicker.value.colorHex = color.hex
    model.value.buttonTextColor = color.hex
}

function changeBckgdColor(color) {
    const { r, g, b, a } = color.rgba
    bckgdColorPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    bckgdColorPicker.value.colorHex = color.hex
    model.value.buttonBgColor = color.hex
}

function updateCheckbox(ev, type) {
    let checked = ev.target.checked;

    if(checked && type === 'showPhone')
        model.value.sectionFields.showPhone = 'yes'
    else if(!checked && type === 'showPhone')
        model.value.sectionFields.showPhone = 'no'
    else if(checked && type === 'requirePhone')
        model.value.sectionFields.requirePhone = 'yes'
    else if(!checked && type === 'requirePhone')
        model.value.sectionFields.requirePhone = 'no'
    else if(checked && type === 'showAgreement')
        model.value.sectionFields.showAgreement = 'yes'
    else if(!checked && type === 'showAgreement')
        model.value.sectionFields.showAgreement = 'no'
}

function updateLeads() {
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