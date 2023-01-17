<template>
    <Accordion flush>
        <accordion-panel>
            <accordion-header>Gated Content</accordion-header>
            <accordion-content>
                <div>
                    <div class="mt-2">
                        <p class="mt-0 text-xs">
                            <font-awesome-icon icon="fa-solid fa-triangle-exclamation" class="mr-1 text-red-500" />
                            When you set specific content for paid subscribers only, 
                            this prompt will appear to ask them to sign up. 
                            This does not show up on free posts.
                        </p>
                        <label for="gated_content" 
                            class="block mb-2 text-sm font-medium 
                            text-gray-900 dark:text-white mt-4">
                            Gated Content Text
                        </label>
                        <input type="text" id="gated_content" 
                        v-model="model.postGatedContent"
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm rounded-lg 
                        focus:ring-blue-500 focus:border-blue-500 
                        block w-full p-2.5 dark:bg-gray-700 
                        dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 
                        dark:focus:border-blue-500" 
                        placeholder="" required>
                    </div>
                </div>
            </accordion-content>
        </accordion-panel>
    </Accordion>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Accordion, AccordionPanel, AccordionHeader, AccordionContent } from 'flowbite-vue'

const props = defineProps({
    data: Object
})
const emit = defineEmits(['update'])

let model = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep: true})

watch(model, (newVal, oldVal) => {
    emit('update', model.value)
}, {deep: true})

function updateColorModel(data) {
    model.value = data
}
</script>

<style>

</style>