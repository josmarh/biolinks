<template>
    <Modal :size="size" v-if="show" @close="closeModal">
        <template #header>
            <div class="flex items-center text-lg">
                Add New Action
            </div>
        </template>
        <template #body>
            <div class="md:grid grid-cols-12 gap-4">
                <div class="col-span-4">
                    <label for="trigger" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white capitalize">
                        trigger When User
                    </label>
                    <select id="trigger" 
                        v-model="model.trigger"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm  
                        focus:ring-blue-500 focus:border-blue-500 
                        block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500">
                        <option value="purchase_plan">Purchase Plan</option>
                    </select>
                </div>
                <div class="col-span-4">
                    <label for="action" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white capitalize">
                        action
                    </label>
                    <select id="action" 
                        v-model="model.action"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm  
                        focus:ring-blue-500 focus:border-blue-500 
                        block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500">
                        <option value="add_profile_tag">Add profile tag</option>
                        <option value="remove_profile_tag">Remove tag</option>
                    </select>
                </div>
                <div class="col-span-4">
                    <label for="tag" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                        Tag
                    </label>
                    <input type="text" id="tag" 
                    v-model="model.tag"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex justify-between">
                <button @click="closeModal" type="button" 
                class="text-gray-500 bg-white hover:bg-gray-100 
                focus:ring-0 focus:outline-none focus:ring-blue-300 
                border border-gray-200 text-sm font-medium px-5 py-2.5 
                hover:text-gray-900 focus:z-10 dark:bg-gray-700 
                dark:text-gray-300 dark:border-gray-500 
                dark:hover:text-white dark:hover:bg-gray-600 
                dark:focus:ring-gray-600">
                    Close
                </button>
                <button @click="addAction" type="button" v-if="task=='new'"
                class="text-white bg-blue-700 hover:bg-blue-800 
                focus:ring-0 focus:outline-none focus:ring-blue-300 
                font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 
                dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Finish
                </button>
                <button @click="updateAction" type="button" v-if="task=='update'"
                class="text-white bg-blue-700 hover:bg-blue-800 
                focus:ring-0 focus:outline-none focus:ring-blue-300 
                font-medium text-sm px-5 py-2.5 text-center dark:bg-blue-600 
                dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Finish
                </button>
            </div>
        </template>
    </Modal>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Modal } from 'flowbite-vue'

const props = defineProps({
    show: Boolean,
    data: Object,
    task: String
})
const emit = defineEmits(['closeModal', 'updateModel'])
let model = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})
watch(model, (newVal, oldVal) => {
    emit('updateModel', newVal)
}, {deep:true})

function closeModal() {
    emit('closeModal')
}

function addAction() {
    model.value.actionList.push({
        action: model.value.action,
        tag: model.value.tag
    })
    model.value.tag = ''
    emit('closeModal')
}

function updateAction() {
    for(const [i, v] of model.value.actionList.entries()) {
        if(i == model.value.index) {
            v.tag = model.value.tag
            break;
        }
    }
    emit('closeModal')
}
</script>

<style>

</style>