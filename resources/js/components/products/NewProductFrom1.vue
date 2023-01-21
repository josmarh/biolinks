<template>
    <div class="md:flex justify-between">
        <div class="md:w-1/2">
            <label for="product_title" 
                class="block mb-2 text-sm 
                font-medium text-gray-900 
                dark:text-white capitalize">
                product title
            </label>
            <input type="text" id="product_title" 
            v-model="model.title"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm focus:ring-blue-500 
            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
            placeholder="">
        </div>
        <div class="mt-2">
            <button type="button" @click="updateForm1"
                class="text-white bg-blue-700 hover:bg-blue-800 
                focus:ring-0 focus:ring-blue-300 font-medium 
                text-sm px-5 py-2.5 mr-2 capitalize
                dark:bg-blue-600 dark:hover:bg-blue-700 
                focus:outline-none dark:focus:ring-blue-800">
                Save Progress
            </button>
        </div>
    </div>
    <div class="lg:grid grid-cols-12 gap-10 mt-4">
        <div class="col-span-8">    
            <label for="description" 
                class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Description
            </label>
            <p class="text-gray-500 text-sm font-semibold">
                Sell and describe your product! Hype it up in this section. 🔥 
                Please note that any styling you add to the text will be applied 
                in your store's product page.
            </p>
            <div class="mt-4">
                <editor 
                    api-key="nz91pgequ1i4nogj6arnwzcz01gd4h5d43gbnj6pdvyfdzzx" 
                    v-model="model.description" class="z-0"
                />
            </div>
            <!-- Images -->
            <div class="mt-6">
                <h3 class="block mb-2 text-sm font-medium flex
                    text-gray-900 dark:text-white capitalize gap-2">
                    images
                </h3>
                <p class="text-gray-500 text-sm font-semibold">
                    These images are shown in your product gallery when you view 
                    this product inside your store.
                </p>
                <!-- <button type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-5 py-2.5 mr-2 capitalize mt-6
                    dark:bg-blue-600 dark:hover:bg-blue-700 
                    focus:outline-none dark:focus:ring-blue-800">
                    Upload
                    <input id="file-upload" type="file" class="hidden" accept="" />
                </button> -->
                <input class="block w-full mt-3 text-sm 
                    text-gray-900 bg-gray-50 rounded-lg border 
                    border-gray-300 cursor-pointer focus:outline-none"
                    @change="uploadFile"
                    id="file_input" 
                    type="file"
                    accept="image/jpeg, image/png"
                    multiple>
                <p class="text-gray-500 text-sm font-normal mt-4">
                    Drag your images to re-arrange your image order. The first image is your featured image.
                </p>
                <!-- Image collections -->
                <div>
                    <div v-if="model.images.length" class="mt-4 mb-4">
                        <div class="md:flex flex-wrap gap-6 mt-6">
                            <draggable v-model="model.images"
                                @start="drag=true" 
                                @end="drag=false"
                                @update="updateFilePos"
                                item-key="id" class="flex flex-wrap gap-6 mt-6">
                                <template #item="{element, index}">
                                    <div >
                                        <div class="flex items-center">
                                            <img v-if="!element.includes('default')"
                                                :src="element" class="w-36 h-32 object-cover image"/>
                                            <img v-else 
                                                :src="`${host}${element}`" 
                                                class="w-36 h-32 object-cover image"/>
                                        </div>
                                        <button type="button" @click="removeLogo(index)"
                                            class="relative overflow-hidden bg-white py-2 px-6 border border-gray-300
                                            shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 mt-1
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                                            xl:w-full w-36">
                                            Remove
                                        </button>
                                    </div>
                                </template>
                            </draggable>
                        </div>

                        <!-- <div class="md:flex flex-wrap gap-6 mt-6">
                            <div v-for="(item, index) in model.images" :key="index">
                                <div class="flex items-center">
                                    <img v-if="!item.includes('default')"
                                        :src="item" class="w-36 h-32 object-cover image"/>
                                    <img v-else 
                                        :src="`${host}${item}`" 
                                        class="w-36 h-32 object-cover image"/>
                                </div>
                                <button type="button" @click="removeLogo(index)"
                                    class="relative overflow-hidden bg-white py-2 px-6 border border-gray-300
                                    shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 mt-1
                                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                                    xl:w-full w-36">
                                    Remove
                                </button>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-4">
            <h3 class="block mb-2 text-sm font-medium flex
                text-gray-900 dark:text-white capitalize gap-2">
                Status & Availablity
            </h3>
            <!-- <div class="block p-6 bg-[#FF3860] border 
                border-gray-200 shadow-md dark:bg-gray-800 
                dark:border-gray-700 dark:hover:bg-gray-700">
                <p class="font-normal text-white dark:text-gray-400 text-sm">
                    To go live, please 
                    <a href="#" class="underline">set up your Stripe account!</a>
                </p>
            </div> -->
            <select id="status" v-model="model.publishedStatus"
                class="bg-gray-50 border 
                border-gray-300 text-gray-900 text-sm  
                focus:ring-blue-500 focus:border-blue-500 block 
                w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 
                dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="Unpublished">Unpublished</option>
                <option value="Published">Published</option>
            </select>
            <!-- <button type="button"
                class="text-white bg-blue-700 hover:bg-blue-800 
                focus:ring-0 focus:ring-blue-300 font-medium 
                text-sm px-5 py-4 mr-2 capitalize mt-6
                dark:bg-blue-600 dark:hover:bg-blue-700 w-full
                focus:outline-none dark:focus:ring-blue-800">
                Add your product to a link page
            </button> -->
            <!-- Category -->
            <h3 class="block mb-2 text-sm font-medium flex mt-4
                text-gray-900 dark:text-white capitalize">
                Category
            </h3>
            <div v-if="model.category.length">
                <div class="flex flex-wrap gap-1 mt-4">
                    <div v-for="(item, i) in model.category" :key="i">
                        <div class="flex mb-0.5">
                            <span class="flex bg-blue-100 text-blue-800 text-sm font-medium 
                                mr-2 px-2.5 py-1.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                {{item}} &nbsp;
                                <span @click="rmCategory(item)"
                                    class="w-4 h-4 flex items-center justify-center 
                                    rounded-full transition-color cursor-pointer 
                                    hover:bg-[rgba(0,0,0,0.2)] mt-0.5">
                                    <font-awesome-icon icon="fa-solid fa-circle-xmark" />
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <input type="text" id="category" 
            @keyup.enter="addCategory"
            v-model="catSearch.category"
            class="bg-gray-50 border border-gray-300 
            text-gray-900 text-sm focus:ring-blue-500 mt-4
            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
            placeholder="Enter a category">
            <!-- <ul class="autocomplete-results" id="autocomplete-results" v-show="searchCatList.isOpen">
                <li class="loading" v-if="searchCatList.isLoading">
                    Loading results...
                </li>
                <li v-else
                    v-for="(result, i) in searchCatData.data"
                    :key="i"
                    @click="setResult(result)"
                    class="autocomplete-result"
                    :class="{ 'is-active': i === searchCatList.arrowCounter }">
                    {{ result }}
                </li>
            </ul> -->
            <p class="mt-1 text-sm text-gray-500">
                Hit the enter button when you're done with the category
            </p>
        </div>
    </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import MoreOptions from './MoreOptions.vue'
import Editor from '@tinymce/tinymce-vue'
import draggable from 'vuedraggable'
import productStore from '../../store/product-store'

const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateModel'])
const route = useRoute();
const searchCatData = computed(() => productStore.state.searchCategory)

let host = window.location.protocol+'//'+window.location.host
let model = ref(props.data)
let catSearch = ref({
    projId: route.params.id,
    category: ''
})
// let searchCatList = ref({
//     isOpen: false,
//     isLoading: false,
//     arrowCounter: -1,
// })

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
    model.value['catCheck'] = newVal.category
})

// watch(catSearch, (newVal, oldVal) => {
//     if(newVal.category) {
//         setTimeout(() => {
//             productStore.dispatch('searchCategory', catSearch.value)
//         }, 1300)
//     }
// }, {deep: true})

function addCategory() {
    let cat = document.getElementById('category');
    model.value.category.push(cat.value);
    model.value.catCheck.push(cat.value);
    cat.value = '';
    catSearch.value.category = '';

    model.value.category = []
    model['_rawValue'].catCheck.forEach((c) => {
        if (!model.value.category.includes(c)) {
            model.value.category.push(c);
        }
    });
}

function rmCategory(item) {
    let filtered = model['_rawValue'].category.filter(data => data != item)

    model.value.category = [];
    model.value.catCheck = [];

    for (let f of filtered) {
        model.value.category.push(f)
        model.value.catCheck.push(f)
    }
}

function uploadFile(ev) {
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

function updateFilePos(moved) {
    for(const [i, v] of model.value.images.entries()) {
        
    }
}

function updateForm1() {
    emit('updateModel', model.value)
}
</script>

<style setup>
.autocomplete {
    position: relative;
}

.autocomplete-results {
    padding: 0;
    margin: 0;
    border: 1px solid #eeeeee;
    height: 120px;
    min-height: 1em;
    max-height: 6em;    
    overflow: auto;
}

.autocomplete-result {
    list-style: none;
    text-align: left;
    padding: 4px 2px;
    cursor: pointer;
}

.autocomplete-result:hover {
    background-color: #4AAE9B;
    color: white;
}
</style>