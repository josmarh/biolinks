<template>
    <div>
        <div class="block p-6 bg-white border 
            border-gray-200 shadow-md dark:bg-gray-800 
            dark:border-gray-700 dark:hover:bg-gray-700">
            <form @submit.prevent="updateBiolinkSetting">
                <!-- Short URL -->
                <div>
                    <label for="shortUrl" 
                        class="block mb-2 text-sm font-medium flex
                        text-gray-900 dark:text-white capitalize gap-2">
                        <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5" />
                        Short Url
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 
                            text-sm text-gray-900 bg-gray-200 border 
                            border-r-0 border-gray-300 
                            dark:bg-gray-600 dark:text-gray-400 
                            dark:border-gray-600">
                            {{helper.applink + 'w/'}}
                        </span>
                        <input type="text" id="shortUrl" v-model="model.linkId"
                            class="rounded-none bg-gray-50 
                            border text-gray-900 focus:ring-blue-500 
                            focus:border-blue-500 block flex-1 min-w-0 
                            w-full text-sm border-gray-300 p-2.5 
                            dark:bg-gray-700 dark:border-gray-600 
                            dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="alias" required>
                    </div>
                    <p class="text-sm text-gray-500">
                        Leave empty for a random generated one.
                    </p>
                </div>
                <!-- Logo Upload -->
                <div class="mt-4" id="logo-fileform">
                    <div class="flex items-center justify-center w-full">
                        <label v-if="!modelSettings.topLogo" for="top-logo" 
                            class="flex flex-col items-center justify-center 
                            w-full border-2 border-gray-300 border-dashed 
                            rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 
                            dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 
                            dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <font-awesome-icon icon="fa-solid fa-camera" class="w-10 h-10 mb-3 text-gray-400" />
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                </p>
                            </div>
                            <input id="top-logo"
                                type="file"
                                class="hidden"
                                accept="image/jpeg, image/png, image/gif"
                                @change="uploadFile($event, 'logo')"
                            />
                        </label>
                        <label v-else  class="img-contain">
                            <img :src="modelSettings.topLogo.includes('biolink') 
                                ? helper.applink + modelSettings.topLogo 
                                : modelSettings.topLogo"
                                class="w-32 h-32 object-cover image rounded-full"/>
                            <div class="middle">
                                <button @click="removeImage('logo')"
                                    class="text p-2 bg-gray-300 rounded-full">
                                    <!-- <XIcon class="w-6 h-6" /> -->
                                    <font-awesome-icon icon="fa-solid fa-x" />
                                </button>
                            </div>
                        </label>
                    </div>
                </div>
                <!-- Video link -->
                <div class="mt-8">
                    <div class="inline-flex gap-3">
                        <div class="flex items-center">
                            <input id="ytube" type="radio" value="youtube" name="video" 
                                v-model="modelSettings.video.type"
                                class="w-4 h-4 text-blue-600 bg-gray-100 
                                border-gray-300 focus:ring-blue-500 
                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="ytube" 
                                class="ml-2 text-sm font-medium 
                                text-gray-900 dark:text-gray-300">
                                YouTube Video
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="vimeo" type="radio" value="vimeo" name="video" 
                                v-model="modelSettings.video.type"
                                class="w-4 h-4 text-blue-600 bg-gray-100 
                                border-gray-300 focus:ring-blue-500 
                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="vimeo" 
                                class="ml-2 text-sm font-medium 
                                text-gray-900 dark:text-gray-300">
                                Vimeo Video
                            </label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="video-link" 
                            class="block mb-2 text-sm font-medium flex
                            text-gray-900 dark:text-white capitalize gap-2">
                            <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5" />
                            {{modelSettings.video.type === 'youtube' ? 'Add Welcome Video' : 'Add Vimeo Video'}}
                        </label>
                        <div class="flex">
                            <input type="url" id="video-link" v-model="modelSettings.video.link"
                            class="rounded-none bg-gray-50 
                            border text-gray-900 focus:ring-blue-500 
                            focus:border-blue-500 block flex-1 min-w-0 
                            w-full text-sm border-gray-300 p-2.5 
                            dark:bg-gray-700 dark:border-gray-600 
                            dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            :placeholder="modelSettings.video.type === 'youtube' ? 'https://youtu.be/GgeTnpTkzI0' : 'https://vimeo.com/44437887'">
                            <!-- <button v-if="modelSettings.video.type === 'youtube'"
                                class="inline-flex items-center px-3 
                                text-sm text-white bg-[#38B2AC] border 
                                border-r-0 border-[#38B2AC] 
                                dark:bg-[#38B2AC] dark:text-white 
                                dark:border-[#38B2AC]">
                                <font-awesome-icon icon="fa-solid fa-eye" class="mr-2" />
                                Preview
                            </button> -->
                        </div>
                    </div>
                </div>
                <!-- Title -->
                <div class="mt-4">
                    <label for="title" 
                        class="block mb-2 text-sm font-medium flex
                        text-gray-900 dark:text-white capitalize gap-2">
                        <font-awesome-icon icon="fa-solid fa-heading" class="mt-0.5" />
                        Title
                    </label>
                    <div class="flex">
                        <input type="text" id="title" v-model="modelSettings.title"
                        class="rounded-none bg-gray-50 
                        border text-gray-900 focus:ring-blue-500 
                        focus:border-blue-500 block flex-1 min-w-0 
                        w-full text-sm border-gray-300 p-2.5 
                        dark:bg-gray-700 dark:border-gray-600 
                        dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Page Title">
                    </div>
                </div>
                <!-- Description -->
                <div class="mt-4">
                    <label for="title" 
                        class="block mb-2 text-sm font-medium flex
                        text-gray-900 dark:text-white capitalize gap-2">
                        <font-awesome-icon icon="fa-solid fa-pencil" class="mt-0.5" />
                        Description
                    </label>
                    <div>
                        <editor 
                            api-key="nz91pgequ1i4nogj6arnwzcz01gd4h5d43gbnj6pdvyfdzzx" 
                            v-model="modelSettings.description" class="z-0"
                        />
                    </div>
                </div>
                <!-- Text color -->
                <div class="mt-4">
                    <label for="title" 
                        class="block mb-2 text-sm font-medium flex
                        text-gray-900 dark:text-white capitalize gap-2">
                        <font-awesome-icon icon="fa-solid fa-paint-brush" class="mt-0.5" />
                        Text Color
                    </label>
                    <div class="flex">
                        <input type="text" id="title" 
                        v-model="modelSettings.textColor"
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
                        :style="{background: modelSettings.textColor}">
                    </div>
                    <div class="flex justify-end relative">
                        <ColorPicker
                            class="absolute bottom-0"
                            theme="light"
                            :color="modelSettings.textColor"
                            :sucker-hide="true"
                            :sucker-canvas="textPicker.suckerCanvas"
                            :sucker-area="textPicker.suckerArea"
                            @changeColor="changeTextColor"
                            v-show="textPicker.show"/>
                    </div>
                </div>
                <!-- Background type -->
                <div class="mt-4">
                    <label for="target-type" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        <font-awesome-icon icon="fa-solid fa-palette" />
                        Background Type
                    </label>
                    <select id="target-type" v-model="modelSettings.bckgdType"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="preset">Preset</option>
                        <option value="gradient">Custom Gradient</option>
                        <option value="color">Custom Color</option>
                        <option value="image">Custom Image</option>
                    </select>
                </div>
                <!-- Background type content -->
                <div class="mt-4 mb-6">
                    <div v-if="modelSettings.bckgdType === 'preset'">
                        <div class="grid grid-cols-12 gap-4">
                            <div v-for="(item, i) in biolinkBckgd.preset" :key="i"
                                class="col-span-4 cursor-pointer">
                                <label :for="'background-' + i" class="cursor-pointer">
                                    <input type="radio" name="biolink-background" :id="'background-' + i"
                                        :value="item.color" v-model="modelSettings.bckgd.presetbckg" 
                                        class="hidden">
                                    <div class="w-full h-20 rounded-md drop-shadow-xl" 
                                        :class="[modelSettings.bckgd.presetbckg == item.color
                                        ? 'contrast-50' : '']"
                                        :style="item.color"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div v-if="modelSettings.bckgdType === 'gradient'">
                        <label for="color-one" 
                            class="block mb-2 text-sm font-normal flex
                            text-gray-900 dark:text-white capitalize gap-2">
                            Color One
                        </label>
                        <div class="flex">
                            <input type="text" id="color-one" 
                            v-model="modelSettings.bckgd.grad1"
                            class="rounded-none bg-gray-50 
                            border text-gray-900 focus:ring-blue-500 
                            focus:border-blue-500 block flex-1 min-w-0 
                            w-full text-sm border-gray-300 p-1 
                            dark:bg-gray-700 dark:border-gray-600 cursor-pointer
                            dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Text color"
                            @click="grad1ColorPicker.show = true"
                            @blur="grad1ColorPicker.show = false"
                            :style="{background: modelSettings.bckgd.grad1}">
                        </div>
                        <div class="flex justify-end relative">
                            <ColorPicker
                                class="absolute bottom-0"
                                theme="light"
                                :color="modelSettings.bckgd.grad1"
                                :sucker-hide="true"
                                :sucker-canvas="grad1ColorPicker.suckerCanvas"
                                :sucker-area="grad1ColorPicker.suckerArea"
                                @changeColor="changeGrad1Color"
                                v-show="grad1ColorPicker.show"/>
                        </div>

                        <label for="color-two" 
                            class="block mb-2 text-sm font-normal flex mt-4
                            text-gray-900 dark:text-white capitalize gap-2">
                            Color Two
                        </label>
                        <div class="flex">
                            <input type="text" id="color-two" 
                            v-model="modelSettings.bckgd.grad2"
                            class="rounded-none bg-gray-50 
                            border text-gray-900 focus:ring-blue-500 
                            focus:border-blue-500 block flex-1 min-w-0 
                            w-full text-sm border-gray-300 p-1 
                            dark:bg-gray-700 dark:border-gray-600 cursor-pointer
                            dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Text color"
                            @click="grad2ColorPicker.show = true"
                            @blur="grad2ColorPicker.show = false"
                            :style="{background: modelSettings.bckgd.grad2}">
                        </div>
                        <div class="flex justify-end relative">
                            <ColorPicker
                                class="absolute bottom-0"
                                theme="light"
                                :color="modelSettings.bckgd.grad2"
                                :sucker-hide="true"
                                :sucker-canvas="grad2ColorPicker.suckerCanvas"
                                :sucker-area="grad2ColorPicker.suckerArea"
                                @changeColor="changeGrad2Color"
                                v-show="grad2ColorPicker.show"/>
                        </div>
                    </div>
                    <div v-if="modelSettings.bckgdType === 'color'">
                        <label for="custom-color" 
                            class="block mb-2 text-sm font-normal flex
                            text-gray-900 dark:text-white capitalize gap-2">
                            Custom Color
                        </label>
                        <div class="flex">
                            <input type="text" id="custom-color" 
                            v-model="modelSettings.bckgd.color"
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
                            :style="{background: modelSettings.bckgd.color}">
                        </div>
                        <div class="flex justify-end relative">
                            <ColorPicker
                                class="absolute bottom-0"
                                theme="light"
                                :color="modelSettings.bckgd.color"
                                :sucker-hide="true"
                                :sucker-canvas="bckgdColorPicker.suckerCanvas"
                                :sucker-area="bckgdColorPicker.suckerArea"
                                @changeColor="changeBckgdColor"
                                v-show="bckgdColorPicker.show"/>
                        </div>
                    </div>
                    <div v-if="modelSettings.bckgdType === 'image'" id="bckgimg-fileform">
                        <span class="text-sm font-normal text-gray-700">Custom Image</span>
                        <div v-if="!modelSettings.bckgd.image">
                            <input class="block w-full mt-3 text-sm 
                                text-gray-900 bg-gray-50 rounded-lg border 
                                border-gray-300 cursor-pointer focus:outline-none"
                                @change="uploadFile($event, 'bckgImage')"
                                id="bckgImage"
                                accept="image/jpeg, image/png"
                                type="file">
                        </div>
                        <div v-else  class="img-contain flex items-center justify-center w-full">
                            <img :src="modelSettings.bckgd.image.includes('biolink') 
                                ? helper.applink + modelSettings.bckgd.image 
                                : modelSettings.bckgd.image"
                                class="w-32 h-32 object-cover image rounded-full"/>
                            <div class="middle">
                                <button @click="removeImage('bckgImage')"
                                    class="text p-2 bg-gray-300 rounded-full">
                                    <!-- <XIcon class="w-6 h-6" /> -->
                                    <font-awesome-icon icon="fa-solid fa-x" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Branding -->
                <link-accordion title="Branding">
                    <brand :data="modelSettings" @update-settings="updateSetting" />
                </link-accordion>
                <!-- Analytics -->
                <link-accordion title="Analytics">
                    <analytics :data="modelSettings" @update-settings="updateSetting" />
                </link-accordion>
                <!-- Seo -->
                <link-accordion title="SEO">
                    <SEO :data="modelSettings" @update-settings="updateSetting" />
                </link-accordion>
                <!-- UTM Parameters -->
                <link-accordion title="UTM Parameters">
                    <utm-params :data="modelSettings" @update-settings="updateSetting" />
                </link-accordion>
                <!-- Socials -->
                <link-accordion title="Socials">
                    <socials :data="modelSettings" @update-settings="updateSetting" />
                </link-accordion>
                <!-- Fonts -->
                <link-accordion title="Fonts">
                    <font :data="modelSettings" @update-settings="updateSetting" />
                </link-accordion>

                <!-- showMemberNavbar -->
                <div class="flex items-center mb-4 mt-6">
                    <input id="show-member-checkbox" 
                    type="checkbox" @change="memberNavCheck"
                    class="w-4 h-4 text-blue-600 bg-gray-100 
                    border-gray-300 rounded focus:ring-blue-500 
                    dark:focus:ring-blue-600 dark:ring-offset-gray-800 
                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    :checked="modelSettings.showMemberNavbar == 'yes' ? true : false">
                    <label for="show-member-checkbox" 
                    class="ml-2 text-sm font-medium 
                    text-gray-900 dark:text-gray-300">
                        Show Membership Login | Signup Navbar
                    </label>
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
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { useRoute } from 'vue-router'
import { notify } from 'notiwind';
import { ColorPicker } from 'vue-color-kit';
import 'vue-color-kit/dist/vue-color-kit.css';
import Editor from '@tinymce/tinymce-vue'
import helper from '../../../helpers';
import biolinkBckgd from '../../../includes/biolink-background'
import LinkAccordion from '../LinkAccordion.vue'
import Font from '../biolink-accordion-body/Font.vue'
import Brand from '../biolink-accordion-body/Brand.vue'
import Analytics from '../biolink-accordion-body/Analytics.vue'
import SEO from '../biolink-accordion-body/SEO.vue'
import UtmParams from '../biolink-accordion-body/UtmParams.vue'
import Socials from '../biolink-accordion-body/Socials.vue'
import projectlinks from '../../../store/projectlinks'


const route = useRoute();
const props = defineProps({
    data: Object,
    dataSettings: Object
});
const emit = defineEmits(['reloadSettings', 'updatePreview'])

let dragAndDropCapable = ref(false)
let isDisabled = ref(false)
let model = ref(props.data);
let modelSettings = ref({
    topLogo: props.dataSettings.topLogo,
    video: props.dataSettings.video,
    title: props.dataSettings.title,
    description: props.dataSettings.description,
    textColor: props.dataSettings.textColor,
    verifiedCheckmark: props.dataSettings.verifiedCheckmark,
    bckgdType: props.dataSettings.backgroundType,
    bckgd: props.dataSettings.backgroundTypeContent,
    branding: props.dataSettings.branding,
    analytics: props.dataSettings.analytics,
    seo: props.dataSettings.seo,
    utmParams: props.dataSettings.utm,
    socials: props.dataSettings.socials,
    fonts: props.dataSettings.font,
    showMemberNavbar: props.dataSettings.showMemberNavbar
});

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

let grad1ColorPicker = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});
let grad2ColorPicker = ref({
    color: '#f3f3f3',
    colorHex: '#f3f3f3',
    suckerCanvas: null,
    suckerArea: [],
    isSucking: false,
    show: false
});

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep:true});

// watch(() => props.dataSettings, (newVal, oldVal) => {
//     modelSettings.value = newVal
// }, {deep:true});

// watch(model, (newVal, oldVal) => {
//     emit('updateSettings', model.value, modelSettings.value)
// }, {deep:true})

watch(modelSettings, (newVal, oldVal) => {
    emit('updatePreview', modelSettings.value)
}, {deep:true})

function changeTextColor(color) {
    const { r, g, b, a } = color.rgba
    textPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    textPicker.value.colorHex = color.hex
    modelSettings.value.textColor = color.hex
}

function changeBckgdColor(color) {
    const { r, g, b, a } = color.rgba
    bckgdColorPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    bckgdColorPicker.value.colorHex = color.hex
    modelSettings.value.bckgd.color = color.hex
}

function changeGrad1Color(color) {
    const { r, g, b, a } = color.rgba
    grad1ColorPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    grad1ColorPicker.value.colorHex = color.hex
    modelSettings.value.bckgd.grad1 = color.hex
}

function changeGrad2Color(color) {
    const { r, g, b, a } = color.rgba
    grad2ColorPicker.value.color = `rgba(${r}, ${g}, ${b}, ${a})`
    grad2ColorPicker.value.colorHex = color.hex
    modelSettings.value.bckgd.grad2 = color.hex
}

function updateSetting(data) {
    modelSettings.value = data;
}

function removeImage(type) {
    if(type === 'bckgImage')
        modelSettings.value.bckgd.image = null;
    else
        modelSettings.value.topLogo = null;
}

function uploadFile(ev, type) {
    const file = ev.target.files[0];
    setImage(file, type)
}

function setImage(file, type) {
    const reader = new FileReader();

    reader.onload = () => {
        if(type === 'bckgImage')
            modelSettings.value.bckgd.image = reader.result;
        else
            modelSettings.value.topLogo = reader.result;
    }
    reader.readAsDataURL(file);
}

function determineDragAndDropCapableImage() {
  var div = document.createElement('div');
  return ( ( 'draggable' in div )
    || ( 'ondragstart' in div && 'ondrop' in div ) )
    && 'FormData' in window
    && 'FileReader' in window;
}

function memberNavCheck(ev) {
    let checked = ev.target.checked;
    if(checked)
        modelSettings.value.showMemberNavbar = 'yes'
    else
        modelSettings.value.showMemberNavbar = 'no'
}

function updateBiolinkSetting() {
    isDisabled.value = true;
    projectlinks
        .dispatch('updateBiolinkSettings', {
            linkId: route.params.linkId,
            link: model.value,
            linkSettings: JSON.stringify(modelSettings.value)
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

onMounted(() => {
    dragAndDropCapable.value = determineDragAndDropCapableImage();
    
    let former = document.getElementById('logo-fileform');
    if(dragAndDropCapable.value) {
        ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach( function( evt ) {
        former.addEventListener(evt, function(e){
            e.preventDefault();
            e.stopPropagation();
        }.bind(this), false);
        }.bind(this));
        former.addEventListener('drop', function(e){
            setImage(e.dataTransfer.files[0], 'logo')
        }.bind(this));
    }
})
</script>

<style scoped>
.img-contain {
  position: relative;
}
.image {
  opacity: 1;
  transition: .5s ease;
  backface-visibility: hidden;
}
.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}
.img-contain:hover .image {
  opacity: 0.3;
}
.img-contain:hover .middle {
  opacity: 1;
}
</style>