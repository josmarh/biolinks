<template>
    <draggable v-model="model"
        @start="drag=true" 
        @end="drag=false"
        @update="onUpdate"
        item-key="id">
        <template #item="{element}">
            <biolink-section-accordion 
                :title="element.section.name"
                :data="element">
                <lead-generation
                    v-if="element.section.name == 'Lead Generation'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <Link 
                    v-if="element.section.name == 'Link'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <Fbgroup 
                    v-if="element.section.name == 'Facebook Group'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <TextBlock 
                    v-if="element.section.name == 'Text Block'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <Soundcloud
                    v-if="element.section.name == 'Soundcloud'"
                    :data="element"
                    @reload-settings="reloadSettings" 
                />
                <Youtube
                    v-if="element.section.name == 'Youtube'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <Twitch
                    v-if="element.section.name == 'Twitch'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <Vimeo
                    v-if="element.section.name == 'Vimeo'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <Spotify
                    v-if="element.section.name == 'Spotify'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <TikTok
                    v-if="element.section.name == 'TikTok'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <MailSignup
                    v-if="element.section.name == 'Mail signup'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <Whatsapp
                    v-if="element.section.name == 'WhatsApp'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <Faq
                    v-if="element.section.name == 'FAQ'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <Calendly
                    v-if="element.section.name == 'Calendly'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <Clubhouse
                    v-if="element.section.name == 'Clubhouse'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <HtmlJsBlock
                    v-if="element.section.name == 'HtmlJsBlock'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
                <GoogleReview
                    v-if="element.section.name == 'GoogleReview'"
                    :data="element"
                    @reload-settings="reloadSettings"
                />
            </biolink-section-accordion>
        </template>
    </draggable>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import draggable from 'vuedraggable'
import BiolinkSectionAccordion from '../BiolinkSectionAccordion.vue';
import LeadGeneration from '../section-accordion-body/LeadGeneration.vue'
import Link from '../section-accordion-body/Link.vue';
import Fbgroup from '../section-accordion-body/Fbgroup.vue';
import TextBlock from '../section-accordion-body/TextBlock.vue'
import Soundcloud from '../section-accordion-body/Soundcloud.vue'
import Youtube from '../section-accordion-body/Youtube.vue'
import Twitch from '../section-accordion-body/Twitch.vue';
import Vimeo from '../section-accordion-body/Vimeo.vue';
import Spotify from '../section-accordion-body/Spotify.vue'
import TikTok from '../section-accordion-body/TikTok.vue'
import MailSignup from '../section-accordion-body/MailSignup.vue'
import Whatsapp from '../section-accordion-body/Whatapp.vue'
import Faq from '../section-accordion-body/Faq.vue';
import Calendly from '../section-accordion-body/Calendly.vue';
import Clubhouse from '../section-accordion-body/Clubhouse.vue';
import HtmlJsBlock from '../section-accordion-body/HtmlJsBlock.vue'
import GoogleReview from '../section-accordion-body/GoogleReview.vue';
import biolinksection from '../../../store/biolink-section'

const route = useRoute()
const props = defineProps({
    data: Object
});

const emit = defineEmits(['reloadSettings'])

let model = ref(props.data)
let modelUpdate = ref([])

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function reloadSettings() {
    emit('reloadSettings')
}

function onUpdate(moved) {
    for(const [i, v] of model.value.entries()) {
        modelUpdate.value.push({
            id: v.section.id,
            pos: i
        })
    }
    setTimeout(() => {
        updateSectionPosition();
    }, 1500);
}

function updateSectionPosition() {
    biolinksection
        .dispatch('updateSectionPosition', {
            linkId: route.params.id,
            position: JSON.stringify(modelUpdate.value)
        })
        .then((res) => {
            emit('reloadSettings')
        })
        .catch((err) => {
            let errMsg;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message"))
                        errMsg = err.response.data.message;
                    else
                        errMsg = err.response.data.error;
                }
            }else {
                errMsg = err;
            }
            notify({
                group: "error",
                title: "Error",
                text: errMsg
            }, 4000);
        })
}
</script>

<style>

</style>