<template>
    <form @submit.prevent="updateFanRequest" class="p-4">
        <div>
            <label for="thumbnail" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-image" class="mt-0.5" />
                Upload Thumbnail
            </label>
            <file-upload 
                :data="model.sectionFields.thumbnail" 
                @update="updateImage" 
            />
        </div>
        <title-field :data="model.sectionFields.title" @update="updateTitle"/>
        <description-field :data="model.sectionFields.description" @update="updateDescription"/>
        <div class="mt-6">
            <label for="requestCost" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Request Cost ($)
            </label>
            <div class="flex gap-3">
                <input type="number" id="requestCost" 
                v-model="model.sectionFields.requestCost"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="requestCost" >
            </div>
        </div>
        <div class="mt-6">
            <label for="start-date" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-clock" class="mt-1" />
                Schedule Link At A Certain Date
            </label>
            <Datepicker 
                v-model="model.sectionFields.schedule"
                class="border border-gray-300 
                text-gray-900 text-sm rounded-lg
                focus:ring-0 focus:border-blue-500 
                block w-full"
            ></Datepicker>
        </div>
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
import { ref, watch } from 'vue'
import { notify } from 'notiwind';
import FileUpload from '../../customfields/FileUpload.vue'
import TitleField from '../../customfields/TitleField.vue';
import DescriptionField from '../../customfields/DescriptionField.vue'
import ButtonTextColorField from '../../customfields/ButtonTextColorField.vue';
import ButtonBgColorField from '../../customfields/ButtonBgColorField.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import biolinksection from '../../../store/biolink-section';

const props = defineProps({
    data: Object
});

const emit = defineEmits(['reloadSettings'])

let model = ref(props.data)
let isDisabled = ref(false)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function updateImage(data) {
    model.value.sectionFields.thumbnail = data
}
function updateTitle(data) {
    model.value.sectionFields.title = data
}
function updateDescription(data) {
    model.value.sectionFields.description = data
}
function updateColor(data, type) {
    if(type == 'titleColor')
        model.value.sectionFields.titleColor = data
    else if(type == 'btnTextColor')
        model.value.buttonTextColor = data
    else if(type == 'btnBgColor')
        model.value.buttonBgColor = data
}

function updateFanRequest() {
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