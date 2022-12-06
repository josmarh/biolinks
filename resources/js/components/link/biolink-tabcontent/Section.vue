<template>
    
</template>

<script setup>
import { ref, watch } from 'vue'
import { notify } from 'notiwind';
import biolinksection from '../../../store/biolink-section';

const props = defineProps({
    data: Object
});

const emit = defineEmits(['reloadSettings'])

let model = ref(props.data)
let isDisabled = ref(false)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function updateSection() {
    isDisabled.value = true
    biolinksection
        .dispatch('updateSection', model.value)
        .then((res) => {
            isDisabled.value = false;
            
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);

            emit('reloadSettings')
        })
        .catch((err) => {
            isDisabled.value = false;
            let errMsg;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message"))
                        errMsg = err.response.data.message;
                    else
                        errMsg = err.response.data.error;
                }
            }else{
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