<template>
    <div>
        <h1 class="font-semibold text-xl">Image Gallery / Featured Image</h1>
        <div class="block p-4 bg-slate-100 border border-gray-200  
        shadow-md dark:bg-gray-800 dark:border-gray-700 w-full
        dark:hover:bg-gray-700 mt-6">
            <div class="flex justify-between">
                <p class="text-gray-600 text-sm font-semibold">
                    The first photo will appear as your "featured image" for this post.
                </p>
                <button type="button" 
                    class="relative overflow-hidden bg-blue-400 py-2 px-6 border border-gray-300
                    shadow-sm text-sm leading-4 font-medium text-white hover:bg-blue-500 
                    focus:outline-none focus:ring-0 focus:ring-offset-2 focus:ring-indigo-500 mb-2">
                    <input 
                        type="file" accept="image/jpeg, image/png" 
                        class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                        @change="onImageChoose">
                    Upload new
                </button>
            </div>
            <!-- Images preview -->
            <div class="mt-6" v-if="model.images.length">
                <div class="xl:flex flex-wrap gap-6 mt-6">
                    <!-- <div v-for="(item, index) in model.images" :key="index"> -->
                    <draggable v-model="model.images"
                        @start="drag=true" 
                        @end="drag=false"
                        item-key="id" 
                        class="mt-6 xl:flex flex-wrap gap-6">
                        <template #item="{element, index}">
                            <div class="cursor-pointer">
                                <div class="flex items-center">
                                    <img v-if="!element.includes('post-images')"
                                        :src="element" class="w-36 h-32 object-cover image"/>
                                    <img v-else 
                                        :src="helper.applink + element" 
                                        class="w-36 h-32 object-cover image"/>
                                </div>
                                <button type="button" @click="removeMedia(index, 'image')"
                                    class="relative overflow-hidden bg-blue-400 py-2 px-6 border border-gray-300
                                    shadow-sm text-sm leading-4 font-medium text-white hover:bg-blue-500 mt-1
                                    focus:outline-none focus:ring-0 focus:ring-offset-2 focus:ring-indigo-500 
                                    xl:w-full w-36">
                                    Remove
                                </button>
                            </div>
                        </template>
                    </draggable>
                    <!-- </div> -->
                </div>
            </div>
            <div class="mt-6">
                <label for="featured_image_style" 
                    class="block mb-2 text-sm 
                    font-medium text-gray-900 
                    dark:text-white capitalize">
                    Featured Image Style
                </label>
                <select id="featured_image_style"
                    v-model="model.featuredImageStyle"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm focus:ring-blue-500 
                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500">
                    <option value="rounded">Rounded Image</option>
                    <option value="square">Squared Image</option>
                    <option value="full">Full Width</option>
                    <option value="hide">Hide</option>
                </select>
            </div>
        </div>

        <h1 class="font-semibold text-xl mt-8">Add media To Post</h1>
        <div class="block p-4 bg-slate-100 border border-gray-200  
        shadow-md dark:bg-gray-800 dark:border-gray-700 w-full
        dark:hover:bg-gray-700 mt-6">
            <!-- <p class="text-gray-600 text-sm font-semibold"></p> -->
            <button type="button" 
            class="relative overflow-hidden bg-blue-400 py-2 px-6 border border-gray-300
            shadow-sm text-sm leading-4 font-medium text-white hover:bg-blue-500
            focus:outline-none focus:ring-0 focus:ring-offset-2 focus:ring-indigo-500 mb-2">
                <input type="file"
                    class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                    @change="onMediaChoose">
                <font-awesome-icon icon="fa-solid fa-plus" class="mr-1.5" />
                Add Media
            </button>
            <!-- Media list previews -->
            <div class="mt-6" v-if="model.media.length">
                <div v-for="(vid, index) in model.media" :key="vid.name" 
                    class="flex justify-center items-center w-full mt-3">
                    <div id="toast-default" 
                        class="flex justify-between items-center w-full p-4 
                        text-gray-500 bg-white rounded-lg shadow 
                        dark:text-gray-400 dark:bg-gray-800" 
                        role="alert">
                        <div class="flex">
                            <div class="inline-flex items-center justify-center 
                            flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 
                            rounded-lg dark:bg-blue-800 dark:text-blue-200">
                                <svg v-if="vid.name.includes('.mp3')" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-3 mt-2 text-sm font-normal" data-tooltip-target="tooltip-default" 
                                :title="vid.name">{{(vid.name).replace(/(.{70})..+/, "$1…")}}
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="button" @click="showEditModal(index, vid.name)"
                                class="ml-auto -mx-1.5 -my-1.5 bg-white 
                                text-gray-400 hover:text-gray-900 rounded-lg 
                                focus:ring-2 focus:ring-gray-300 p-1.5 
                                hover:bg-gray-100 inline-flex h-8 w-8 
                                dark:text-gray-500 dark:hover:text-white 
                                dark:bg-gray-800 dark:hover:bg-gray-700" 
                                data-dismiss-target="#toast-default" 
                                aria-label="Close">
                                <span class="sr-only">Edit</span>
                                <font-awesome-icon icon="fa-solid fa-pencil" class="w-5 h-5" />
                            </button>
                            <button type="button" @click="removeMedia(index, 'media')"
                                class="ml-auto -mx-1.5 -my-1.5 bg-white 
                                text-gray-400 hover:text-gray-900 rounded-lg 
                                focus:ring-2 focus:ring-gray-300 p-1.5 
                                hover:bg-gray-100 inline-flex h-8 w-8 
                                dark:text-gray-500 dark:hover:text-white 
                                dark:bg-gray-800 dark:hover:bg-gray-700" 
                                data-dismiss-target="#toast-default" 
                                aria-label="Close">
                                <span class="sr-only">Close</span>
                                <font-awesome-icon icon="fa-solid fa-trash" class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <edit-media-name-modal 
    :showModal="showModal" 
    :name="mediaName"
    :index="mediaIndex"
    @update="updateMediaName" 
    @cancel="cancelModal" />
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import EditMediaNameModal from './EditMediaNameModal.vue'
import draggable from 'vuedraggable'
import helper from '../../../helpers'

const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateModel'])

let model = ref(props.data)
let mediaName = ref('')
let mediaIndex = ref(0)
let showModal = ref(false)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep: true})

watch(model, (newVal, oldVal) => {
    emit('updateModel', model.value)
}, {deep: true})

function showEditModal(index, name) {
    showModal.value = true
    mediaIndex.value = index
    mediaName.value = name
}

function cancelModal() {
    showModal.value = false
}

function onImageChoose(ev) {
    const file = ev.target.files;
    setFiles(file);
    ev.target.value = null;
}

function onMediaChoose(ev) {
    const file = ev.target.files;
    setMediaFiles(file);
    ev.target.value = null;
}

function setFiles(file) {
    if (file) {
        for (let f of file) {
            const reader = new FileReader();
            reader.fileName = f.name
            reader.fileSize = f.size
            reader.fileType = f.type
            reader.onload = async (res) => {
                let fileNam = res.target.fileName;
                let fileSize = res.target.fileSize;
                let fileType = res.target.fileType;
                let fileUrl = reader.result;
                let fsize;
                model.value.images.push(fileUrl)
            }
            reader.readAsDataURL(f);
        }
    }
}

function setMediaFiles(file) {
    if (file) {
        for (let f of file) {
            const reader = new FileReader();
            reader.fileName = f.name
            reader.fileSize = f.size
            reader.fileType = f.type
            reader.onload = async (res) => {
                let fileNam = res.target.fileName;
                let fileSize = res.target.fileSize;
                let fileType = res.target.fileType;
                let fileUrl = reader.result;
                let fsize;
                model.value.media.push({
                    name: fileNam,
                    file: fileUrl,
                    type: fileType
                });
                console.log(model.value.media)
            }
            reader.readAsDataURL(f);
        }
    }
}

function removeMedia(index, type) {
    if(type==='image'){
        let filtered = model['_rawValue'].images.filter((data, i) => i != index)
        model.value.images = [];

        for (let f of filtered) {
            model.value.images.push(f)
        }
    }else {
        let filtered = model['_rawValue'].media.filter((data, i) => i != index)
        model.value.media = [];

        for (let f of filtered) {
            model.value.media.push(f)
        }
    }
}

function updateMediaName(name) {
    showModal.value = !showModal.value
    for (const [i, v] of model.value.media.entries()) {
        if(parseInt(mediaIndex.value) == i) {
            model.value.media[i].name = name
            mediaName.value = name
        }
    }
}

// onMounted(() => {
    
// })
</script>

<style>

</style>