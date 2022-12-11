<template>
    <!-- Description -->
    <div class="mt-4">
        <label for="description" 
            class="block mb-2 text-sm font-medium flex
            text-gray-900 dark:text-white capitalize gap-2">
            <font-awesome-icon icon="fa-solid fa-pencil" class="mt-0.5" />
            Description
        </label>
        <div>
            <editor 
                api-key="nz91pgequ1i4nogj6arnwzcz01gd4h5d43gbnj6pdvyfdzzx" 
                v-model="description" class="z-0"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Editor from '@tinymce/tinymce-vue'

const props = defineProps({
    data: String
})
const emit = defineEmits(['update'])

let description = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    description.value = newVal
})

watch(description, (newVal, oldVal) => {
    emit('update', description.value)
})
</script>

<style>

</style>