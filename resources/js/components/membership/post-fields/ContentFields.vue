<template>
    <div class="">
        <label for="post_title" 
            class="block mb-2 text-sm 
            font-medium text-gray-900 
            dark:text-white capitalize">
            post title
        </label>
        <input type="text" id="post_title" 
        v-model="model.title"
        class="bg-gray-50 border border-gray-300 
        text-gray-900 text-sm focus:ring-blue-500 
        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
        dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
        dark:focus:ring-blue-500 dark:focus:border-blue-500" 
        placeholder="">
    </div>
    <div class="mt-6">
        <label for="excerpt" class="block mb-2 text-sm 
        font-medium text-gray-900 dark:text-white">
            Excerpt (Shown to the public)
        </label>
        <textarea id="excerpt" rows="4" v-model="model.excerpt"
        class="block p-2.5 w-full text-sm text-gray-900 
        bg-gray-50 border border-gray-300 
        focus:ring-blue-500 focus:border-blue-500 
        dark:bg-gray-700 dark:border-gray-600 
        dark:placeholder-gray-400 dark:text-white 
        dark:focus:ring-blue-500 dark:focus:border-blue-500" 
        placeholder=""></textarea>
    </div>
    <div class="mt-6">
        <label for="excerpt" class="block mb-2 text-sm 
        font-medium text-gray-900 dark:text-white">
            Write your post
        </label>
        <editor 
        api-key="nz91pgequ1i4nogj6arnwzcz01gd4h5d43gbnj6pdvyfdzzx" 
        v-model="model.post" class="z-0" 
        :init="init"
        />
    </div>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'
import tinymce from 'tinymce/tinymce.js';
import 'tinymce/skins/ui/oxide/skin.css';
import 'tinymce/themes/silver';
import 'tinymce/icons/default';
import 'tinymce/plugins/emoticons';
import 'tinymce/plugins/emoticons/js/emojis.js';
import 'tinymce/plugins/table';
import 'tinymce/plugins/quickbars';
import 'tinymce/plugins/image';
import 'tinymce/plugins/media';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/link';
import 'tinymce/plugins/code';
import 'tinymce/plugins/anchor';
import 'tinymce/plugins/wordcount';
import 'tinymce/plugins/insertdatetime';
import Editor from '@tinymce/tinymce-vue'

const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateModel'])
const plugins = 'quickbars emoticons table image media autolink link code anchor wordcount insertdatetime';
const toolbar = ' bold italic underline strikethrough | fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify|bullist numlist |outdent indent blockquote | undo redo | axupimgs | removeformat | table | emoticons | image | media'
const init = reactive({
    height: 500,
    menubar: true,
    plugins: plugins,
    toolbar: toolbar,
    branding: false,
    a11y_advanced_options: true,
    file_picker_types: 'file image media'
});

let model = ref(props.data)

watch(model, (newVal, oldVal) => {
    emit('updateModel', model.value)
}, {deep: true})
</script>

<style>

</style>