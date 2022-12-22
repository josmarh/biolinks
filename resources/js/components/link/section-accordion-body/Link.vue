<template>
    <form @submit.prevent="updateLink" class="p-4">
        <!-- Link Type -->
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
        <!-- Destination URL -->
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
        <!-- Schedule -->
        <div class="mt-4">
            <label for="scheduleSwitch" 
                class="inline-flex relative items-center cursor-pointer">
                <input type="checkbox"
                    id="scheduleSwitch" 
                    class="sr-only peer"
                    @change="updateCheckbox($event, 'scheduleSwitch')"
                    :checked="model.sectionFields.scheduleSwitch == 'yes' ? true : false">
                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                    peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                    peer peer-checked:after:translate-x-full 
                    peer-checked:after:border-white 
                    after:content-[''] after:absolute after:top-[2px] 
                    after:left-[2px] after:bg-white after:border-gray-300 
                    after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                    peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Schedule
                </span>
            </label>
            <p class="text-sm text-gray-500">
                Set an exact date when the link will work.
            </p>
        </div>
        <div v-if="model.sectionFields.scheduleSwitch == 'yes'"
            class="mt-4 md:flex gap-4 w-full">
            <div class="w-full">
                <label for="start-date" 
                    class="block mb-2 text-sm 
                    text-gray-900 pt-2 mr-3">
                    <font-awesome-icon icon="fa-solid fa-clock" />
                    Start Date
                </label>
                <Datepicker 
                    v-model="model.sectionFields.scheduleStart"
                    class="border border-gray-300 
                    text-gray-900 text-sm rounded-lg
                    focus:ring-0 focus:border-blue-500 
                    block w-full"
                ></Datepicker>
            </div>
            <div class="w-full">
                <label for="end-date" 
                    class="block mb-2 text-sm 
                    text-gray-900 pt-2 mr-3">
                    <font-awesome-icon icon="fa-solid fa-clock" />
                    End Date
                </label>
                <Datepicker 
                    v-model="model.sectionFields.scheduleEnd"
                    class="border border-gray-300 
                    text-gray-900 text-sm rounded-lg
                    focus:ring-0 focus:border-blue-500 
                    block w-full"
                ></Datepicker>
            </div>
        </div>
        <!-- Label button text -->
        <div class="mt-4">
            <label for="buttonText" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-paragraph" class="mt-0.5" />
                Name
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
                placeholder="" required>
            </div>
        </div>
        <!-- button icon -->
        <div class="mt-4">
            <label for="buttonIcon" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-earth-africa" class="mt-0.5" />
                Icon
            </label>
            <div class="flex">
                <input type="text" id="buttonIcon" 
                v-model="model.sectionFields.buttonIcon"
                class="rounded-none bg-gray-50 
                border text-gray-900 focus:ring-blue-500 
                focus:border-blue-500 block flex-1 min-w-0 
                w-full text-sm border-gray-300 p-2.5 
                dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="fa-solid fa-house" >
            </div>
            <p class="text-sm text-gray-500 mt-1">
                <a href="https://fontawesome.com/search?o=r&m=free&s=thin%2Csolid%2Cregular%2Cduotone" 
                    target="_blank" rel="noopener noreferrer" class="underline">
                    FontAwesome
                </a>
                icon class. Leave empty for no icon.
            </p>
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
         <!-- Button Outline -->
         <div class="mt-4">
            <label for="buttonOutline" 
                class="inline-flex relative items-center cursor-pointer">
                <input type="checkbox"
                    id="buttonOutline" 
                    class="sr-only peer"
                    @change="updateCheckbox($event, 'buttonOutline')"
                    :checked="model.sectionFields.buttonOutline == 'yes' ? true : false">
                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                    peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                    peer peer-checked:after:translate-x-full 
                    peer-checked:after:border-white 
                    after:content-[''] after:absolute after:top-[2px] 
                    after:left-[2px] after:bg-white after:border-gray-300 
                    after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                    peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Outline
                </span>
            </label>
        </div>
        <!-- Border Radius -->
        <div class="mt-4">
            <label for="borderRadius" 
                class="block mb-2 text-sm font-medium 
                text-gray-900 dark:text-white">
                Border radius
            </label>
            <select id="borderRadius" 
                v-model="model.sectionFields.borderRadius"
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="straight">Straight</option>
                <option value="round">Round</option>
                <option value="rounded">Rounded</option>
            </select>
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
import { ref, watch } from 'vue';
import { notify } from 'notiwind';
import { ColorPicker } from 'vue-color-kit';
import 'vue-color-kit/dist/vue-color-kit.css';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import biolinksection from '../../../store/biolink-section';

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

    if(checked && type === 'scheduleSwitch')
        model.value.sectionFields.scheduleSwitch = 'yes'
    else if(!checked && type === 'scheduleSwitch')
        model.value.sectionFields.scheduleSwitch = 'no'
    else if(checked && type === 'buttonOutline')
        model.value.sectionFields.buttonOutline = 'yes'
    else if(!checked && type === 'buttonOutline')
        model.value.sectionFields.buttonOutline = 'no'
}

function updateLink() {
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