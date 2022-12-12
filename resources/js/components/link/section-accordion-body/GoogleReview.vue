<template>
    <form @submit.prevent="updateGoogleReview" class="p-4">
        <google-key-field :data="model.sectionFields.googleKey" @update="updateGoogleKey"/>
        <google-placeid-field :data="model.sectionFields.googlePlaceId" @update="updateGooglePlace"/>
        <border-color-field :data="model.sectionFields.borderColor" @update="updateBorderColor"/>
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
import GoogleKeyField from '../../customfields/GoogleKeyField.vue';
import GooglePlaceidField from '../../customfields/GooglePlaceidField.vue';
import BorderColorField from '../../customfields/BorderColorField.vue';
import biolinksection from '../../../store/biolink-section';

const props = defineProps({
    data: Object
});
const emit = defineEmits(['reloadSettings']);

let model = ref(props.data)
let isDisabled = ref(false)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function updateGoogleKey(data) {
    model.value.sectionFields.googleKey = data;
}
function updateGooglePlace(data) {
    model.value.sectionFields.googlePlaceId = data;
}
function updateBorderColor(data, type) {
    model.value.sectionFields.borderColor = data;
}

function updateGoogleReview() {
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