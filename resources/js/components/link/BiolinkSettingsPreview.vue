<template>
    <div class="biolink-preview-container">
        <div class="biolink-preview">
            <div class="biolink-preview-iframe-container">
                <div class="biolink-preview-iframe">
                    <div class="bg-white h-full p-4 overflow-y-auto"
                        v-if="setting.bckgdType == 'preset'"
                        :style="setting.bckgd.presetbckg">
                        <Main :settings="setting" :custom-settings="custom" />
                    </div>
                    <div v-if="setting.bckgdType == 'gradient'"
                        class="bg-white h-full p-4 overflow-y-auto"
                        :style="{'background-image': `linear-gradient(109.6deg, ${setting.bckgd.grad1} 11.2%, ${setting.bckgd.grad2} 91.1%)`}">
                        <Main :settings="setting" :custom-settings="custom" />
                    </div>
                    <div v-if="setting.bckgdType == 'color'"
                        :style="{background: setting.bckgd.color}"
                        class="bg-white h-full p-4 overflow-y-auto">
                        <Main :settings="setting" :custom-settings="custom" />
                    </div>
                    <div v-if="setting.bckgdType == 'image' && setting.bckgd.image"
                        class="bg-white h-full p-4 overflow-y-auto"
                        :style="{backgroundImage: setting.bckgd.image.includes('biolink') 
                            ? `url(${helper.applink + setting.bckgd.image})` 
                            : `url(${setting.bckgd.image})`,
                            backgroundSize: 'cover',
                            backgroundPosition: 'center',
                            backgroundRepeat: 'no-repeat'}">
                        <Main :settings="setting" :custom-settings="custom" />
                    </div>
                    <div v-if="setting.bckgdType == 'image' && !setting.bckgd.image"
                        class="bg-white h-full p-4 overflow-y-auto"
                        :style="setting.bckgd.presetbckg">
                        <Main :settings="setting" :custom-settings="custom" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Main from './biolink-webpage/Main.vue'
import helper from '../../helpers'

const props = defineProps({
    settings: Object,
    sectionSettings: Object,
    customSettings: Object
});

let setting = ref(props.settings)
let section = ref(props.sectionSettings)
let custom = ref(props.customSettings)

watch(() => props.settings, (newVal, oldVal) => {
    setting.value = newVal
});

watch(() => props.sectionSettings, (newVal, oldVal) => {
    section.value = newVal
});

watch(() => props.customSettings, (newVal, oldVal) => {
    custom.value = newVal
});
</script>

<style scoped>
/* Biolink preview iframe */
/* .biolink-preview-container {

} */

.biolink-preview {
	position: relative;
	margin: 0 auto;
	height: auto;
	width: auto;
	display: inline-block;
	text-align: left;
	border-radius: 4rem;
	padding: .7rem;
	background: linear-gradient(45deg,#444,#111);
	box-shadow: 0 0px 30px rgba(0,0,0,0.20);
	border: .3rem solid #444546;
}

@media (min-width: 768px) {
	.biolink-preview {
		position: sticky;
		top: 5rem;
	}
}

.biolink-preview-iframe-container {
	overflow: hidden;
	width: 300px;
	height: 625px;
	border-radius: 3rem;
	position: relative;
}

@media (min-width: 768px) {
	.biolink-preview-iframe-container {
		width: 375px;
		height: 825px;
	}
}

.biolink-preview-iframe {
	width: 100%;
	height: 100%;
	border: 0;
	margin: 0;
	padding: 0;
}
</style>