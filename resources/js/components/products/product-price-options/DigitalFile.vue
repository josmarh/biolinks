<template>
    <div class="md:grid md:grid-cols-3 md:gap-6 mt-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Digital Files & Deliverables
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    If this product is digital, upload digital files & more.
                </p>
            </div>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <div class="shadow-xl sm:overflow-hidden sm:rounded-md">
                <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                    <div class="mt-4">
                        <input class="block w-full mt-3 text-sm 
                        text-gray-900 bg-gray-50 rounded-lg border 
                        border-gray-300 cursor-pointer focus:outline-none"
                        @change="uploadFile"
                        id="file_input" 
                        type="file">
                    </div>
                </div>
            </div>
            <div class="mt-6" v-if="files.files.length">
                <hr class="mb-6">
                <ul class="text-sm text-gray-900 
                    bg-white border border-gray-200
                    dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li v-for="(item, i) in files.files" :key="i"
                        class="flex justify-between w-full 
                        px-4 py-2 border-b border-gray-200 
                        rounded-t-lg dark:border-gray-600">
                        {{ item.name }}
                        <font-awesome-icon icon="fa-solid fa-trash" 
                        class="cursor-pointer mt-0.5"
                        @click="removeFile(i)" />
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    data: Array
})
const emit = defineEmits(['updateProduct'])

let files = ref({
    files: props.data,
    fileName: '',
    type: 'files'
})

watch(() => props.data, (newVal, oldVal) => {
    files.value.files = newVal
})

watch(files, (newVal, oldVal) => {
    emit('updateProduct', files.value)
}, {deep:true})

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
                let fileName = res.target.fileName;
                let fileSize = res.target.fileSize;
                let fileType = res.target.fileType;
                let fileUrl = reader.result;
                let fsize;

                files.value.files.push({
                    file: fileUrl,
                    name: fileName,
                    type: fileType
                });
            }
            reader.readAsDataURL(f);
        }
    }
}

function removeFile(index) {
    let filtered = files['_rawValue'].files.filter((data, i) => i != index)

    files.value.files = [];
    
    for (let f of filtered) {
        files.value.files.push(f)
    }
}
</script>

<style>

</style>