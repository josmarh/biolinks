<template>
    <div>
        <biolink-section-accordion
            v-for="item in model" :key="item.id"
            :title="item.section.name">
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
        </biolink-section-accordion>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import BiolinkSectionAccordion from '../BiolinkSectionAccordion.vue';
import LeadGeneration from '../section-accordion-body/LeadGeneration.vue'
import Link from '../section-accordion-body/Link.vue';

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