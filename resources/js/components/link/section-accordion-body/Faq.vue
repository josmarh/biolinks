<template>
    <form @submit.prevent="updateFAQ" class="p-4">
        <title-field :data="model.sectionFields.title" @update="updateTitle"/>
        <text-field :data="model.sectionFields.text" @update="updateText"/>
        <title-color-field :data="model.sectionFields.titleColor" @update="updateColor"/>
        <text-color-field :data="model.sectionFields.textColor" @update="updateColor"/>
        <qstn-text-color-field :data="model.sectionFields.qstnTextColor" @update="updateColor"/>
        <qstn-bg-color-field :data="model.sectionFields.qstnBgColor" @update="updateColor"/>
        <!-- Initial Question -->
        <div class="mt-4">
            <label for="question" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Question
            </label>
            <div class="flex">
                <input type="text" id="question" 
                v-model="model.sectionFields.qestion"
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
        <!-- Initial Answer -->
        <div class="mt-4">
            <label for="answer" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Answer
            </label>
            <div class="flex">
                <input type="text" id="answer" 
                v-model="model.sectionFields.answer"
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

        <!-- more questions n answers -->
        <div v-for="(item, i) in model.sectionFields.moreFaq" :key="i">
            <div class="mt-4">
                <label :for="'more-question-'+i" 
                    class="block mb-2 text-sm font-medium flex justify-between
                    text-gray-900 dark:text-white capitalize gap-2">
                    Question
                    <button type="button" @click="removeFaq(i)" class="hover:text-blue-500">
                        <font-awesome-icon icon="fa-solid fa-trash"/>
                    </button>
                </label>
                <div class="flex">
                    <input type="text" :id="'more-question-'+i" 
                    v-model="model.sectionFields.moreFaq[i].qestion"
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
            <div class="mt-4">
                <label :for="'more-anwser-'+i" 
                    class="block mb-2 text-sm font-medium flex
                    text-gray-900 dark:text-white capitalize gap-2">
                    Answer
                </label>
                <div class="flex">
                    <input type="text" :id="'more-anwser-'+i" 
                    v-model="model.sectionFields.moreFaq[i].answer"
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
        </div>

        <button type="button" @click="addFaq"
            class="w-full text-white bg-blue-700 
            hover:bg-blue-800 focus:ring-0 mt-6
            focus:outline-none focus:ring-blue-300 
            font-medium text-sm px-5 py-2.5 
            text-center dark:bg-blue-600 dark:hover:bg-blue-700 
            dark:focus:ring-blue-800">
            Add
        </button>

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
import TextField from '../../customfields/TextField.vue';
import TitleColorField from '../../customfields/TitleColorField.vue';
import TextColorField from '../../customfields/TextColorField.vue'
import QstnTextColorField from '../../customfields/QstnTextColorField.vue'
import QstnBgColorField from '../../customfields/QstnBgColorField.vue'
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

function updateTitle(data) {
    model.value.sectionFields.title = data
}
function updateText(data) {
    model.value.sectionFields.text = data
}
function updateColor(data, type) {
    if(type == 'titleColor')
        model.value.sectionFields.titleColor = data
    else if(type == 'textColor')
        model.value.sectionFields.textColor = data
    else if(type == 'qstnTextColor')
        model.value.sectionFields.qstnTextColor = data
    else if(type == 'qstnBgColor')
        model.value.sectionFields.qstnBgColor = data
}

function addFaq() {
    model.value.sectionFields.moreFaq.push({
        question: '',
        answer: ''
    })
}

function removeFaq(index) {
    let filtered = model['_rawValue'].sectionFields.moreFaq.filter((data, i) => i != index)

    model.value.sectionFields.moreFaq = [];
    for (let f of filtered) {
        model.value.sectionFields.moreFaq.push(f)
    }
}

function updateFAQ () {
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