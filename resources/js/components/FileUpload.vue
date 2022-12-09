<template>
    <!-- Logo Upload -->
    <div class="mt-4" id="logo-fileform">
        <div class="flex items-center justify-center w-full">
            <label v-if="!image" for="top-logo" 
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
                    accept="image/jpeg, image/png"
                    @change="uploadFile($event)"
                />
            </label>
            <label v-else class="img-contain">
                <img :src="image.includes('biolink') 
                    ? helper.applink + image : image"
                    class="w-32 h-32 object-cover image rounded-full"/>
                <div class="middle">
                    <button @click="removeImage()"
                        class="text p-2 bg-gray-300 rounded-full">
                        <!-- <XIcon class="w-6 h-6" /> -->
                        <font-awesome-icon icon="fa-solid fa-x" />
                    </button>
                </div>
            </label>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import helper from '../helpers';

const props = defineProps({
    data: String
})
const emit = defineEmits(['update'])
let image = ref(props.data)
let dragAndDropCapable = ref(false)

watch(() => props.data, (newVal, oldVal) => {
    image.value = newVal
})

function uploadFile(ev) {
    const file = ev.target.files[0];
    setImage(file)
}

function setImage(file) {
    const reader = new FileReader();

    reader.onload = () => {
        image.value = reader.result;
        emit('update', image.value);
    }
    reader.readAsDataURL(file);
}

function removeImage() {
    image.value = null;
    emit('update', image.value);
}

function determineDragAndDropCapableImage() {
  var div = document.createElement('div');
  return ( ( 'draggable' in div )
    || ( 'ondragstart' in div && 'ondrop' in div ) )
    && 'FormData' in window
    && 'FileReader' in window;
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
            setImage(e.dataTransfer.files[0])
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