<template>
    <div>
        <biolink-section-accordion
            v-for="item in model" :key="item.id"
            :title="item.section.name"
            :data="item">
            <!-- accordion body -->
            <lead-generation
                v-if="item.section.name == 'Lead Generation'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <Link 
                v-if="item.section.name == 'Link'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <Fbgroup 
                v-if="item.section.name == 'Facebook Group'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <TextBlock 
                v-if="item.section.name == 'Text Block'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <Soundcloud
                v-if="item.section.name == 'Soundcloud'"
                :data="item"
                @reload-settings="reloadSettings" 
            />
            <Youtube
                v-if="item.section.name == 'Youtube'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <Twitch
                v-if="item.section.name == 'Twitch'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <Vimeo
                v-if="item.section.name == 'Vimeo'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <Spotify
                v-if="item.section.name == 'Spotify'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <TikTok
                v-if="item.section.name == 'TikTok'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <MailSignup
                v-if="item.section.name == 'Mail signup'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <Whatsapp
                v-if="item.section.name == 'WhatsApp'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <Faq
                v-if="item.section.name == 'FAQ'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <Calendly
                v-if="item.section.name == 'Calendly'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <Clubhouse
                v-if="item.section.name == 'Clubhouse'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <HtmlJsBlock
                v-if="item.section.name == 'HtmlJsBlock'"
                :data="item"
                @reload-settings="reloadSettings"
            />
            <GoogleReview
                v-if="item.section.name == 'GoogleReview'"
                :data="item"
                @reload-settings="reloadSettings"
            />
        </biolink-section-accordion>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
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

const props = defineProps({
    data: Object
});

const emit = defineEmits(['reloadSettings'])

let model = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function reloadSettings() {
    emit('reloadSettings')
}
</script>

<style>

</style>