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
                                <button type="button" @click="removeLogo(index)"
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
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import draggable from 'vuedraggable'
import helper from '../../../helpers'

const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateModel'])

let model = ref(props.data)

watch(model, (newVal, oldVal) => {
    emit('updateModel', model.value)
})

function onImageChoose(ev) {
    const file = ev.target.files;
    setFiles(file);
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

function removeLogo(index) {
    let filtered = model['_rawValue'].images.filter((data, i) => i != index)
    model.value.images = [];

    for (let f of filtered) {
        model.value.images.push(f)
    }
}
</script>

<style>

</style>