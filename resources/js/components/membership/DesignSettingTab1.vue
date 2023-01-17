<template>
    <Accordion flush>
        <accordion-panel>
            <accordion-header>Colors</accordion-header>
            <accordion-content>
                <div>
                    <headline-color :data="model" @update="updateColorModel" />
                    <text-color :data="model" @update="updateColorModel" />
                    <bg-color :data="model" @update="updateColorModel" />
                    <button-color :data="model" @update="updateColorModel" />
                    <link-color :data="model" @update="updateColorModel" />
                    <post-bg-color :data="model" @update="updateColorModel" />
                </div>
            </accordion-content>
        </accordion-panel>
        <accordion-panel>
            <accordion-header>Text / Fonts</accordion-header>
            <accordion-content>
                <div>
                    <text-font :data="model" @update="updateColorModel" />
                </div>
            </accordion-content>
        </accordion-panel>
        <accordion-panel>
            <accordion-header>Posts</accordion-header>
            <accordion-content>
                <div>
                    <posts :data="model" @update="updateColorModel" />
                </div>
            </accordion-content>
        </accordion-panel>
        <accordion-panel>
            <accordion-header>Subscribe Alert</accordion-header>
            <accordion-content>
                <div>
                    <subscriber-alert :data="model" @update="updateColorModel" />
                </div>
            </accordion-content>
        </accordion-panel>
        <accordion-panel>
            <accordion-header>Email Box</accordion-header>
            <accordion-content>
                <div>
                    <email-box :data="model" @update="updateColorModel" />
                </div>
            </accordion-content>
        </accordion-panel>
    </Accordion>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Accordion, AccordionPanel, AccordionHeader, AccordionContent } from 'flowbite-vue'
import HeadlineColor from './blog-settings-fields/HeadlineColor.vue'
import TextColor from './blog-settings-fields/TextColor.vue'
import BgColor from './blog-settings-fields/BgColor.vue'
import ButtonColor from './blog-settings-fields/ButtonColor.vue'
import LinkColor from './blog-settings-fields/LinkColor.vue'
import PostBgColor from './blog-settings-fields/PostBgColor.vue'
import TextFont from './blog-settings-fields/TextFont.vue'
import Posts from './blog-settings-fields/Posts.vue'
import SubscriberAlert from './blog-settings-fields/SubscriberAlert.vue'
import EmailBox from './blog-settings-fields/EmailBox.vue'

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