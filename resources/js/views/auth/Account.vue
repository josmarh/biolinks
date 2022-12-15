<template>
    <div class="md:px-20">
        <div class="flex gap-4">
            <font-awesome-icon icon="fa-solid fa-circle-user" class="text-6xl text-gray-500"/>
            <h1 class="font-bold text-2xl">
                {{model.name}} <br>
                <span class="text-sm font-normal">Membership: &nbsp;</span>
                <span class="bg-green-100 text-green-800 text-xs 
                    font-semibold mr-2 px-2.5 py-0.5 rounded 
                    dark:bg-green-200 dark:text-green-900">
                    {{model.membership}}
                </span>
            </h1>
        </div>
        <div class="mt-10">
            <div class="flex justify-between">
                <ul class="flex flex-wrap text-sm font-medium 
                    text-center text-gray-500 dark:text-gray-400">
                    <li class="mr-2">
                        <button @click="selectTab('account')"
                            class="inline-block py-3 px-4 " 
                            aria-current="page"
                            :class="[currentTab==='account' 
                            ? 'text-white bg-[#234E52] active' 
                            : 'hover:text-gray-900 hover:bg-gray-100']">
                            <font-awesome-icon icon="fa-solid fa-wrench"/>
                            Account
                        </button>
                    </li>
                    <li class="mr-2">
                        <button @click="selectTab('logs')"
                            class="inline-block py-3 px-4 " 
                            aria-current="page"
                            :class="[currentTab==='logs' 
                            ? 'text-white bg-[#234E52] active' 
                            : 'hover:text-gray-900 hover:bg-gray-100']">
                            <font-awesome-icon icon="fa-solid fa-scroll"/>
                            Logs
                        </button>
                    </li>
                </ul>
            </div>
            <div class="mt-4">
                <div v-if="currentTab==='account'">
                    <profile-info :data="model" :btn-disable="isDisabled" @update="updateInfo"/>
                    <profile-password :data="model" :btn-disable="isDisabled2" @update="updateInfo"/>
                </div>
                <div v-if="currentTab==='logs'">
                    <profile-logs :data="userLogs"/>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { notify } from 'notiwind';
import AuthLayout from '../../components/layouts/AuthLayout.vue';
import ProfileInfo from '../../components/account-settings/ProfileInfo.vue';
import ProfilePassword from '../../components/account-settings/ProfilePassword.vue';
import ProfileLogs from '../../components/account-settings/ProfileLogs.vue';
import store from '../../store'

const userLogs = computed(() => store.state.loginHistory)
const isDisabled = ref(false)
const isDisabled2 = ref(false)
const currentTab = ref('account');
let model = ref({
    name: store.state.user.data.name,
    email: store.state.user.data.email,
    old_password: '',
    password: '',
    password_confirmation: '',
    membership: store.state.user.membership
})

function selectTab(tab) {
    currentTab.value = tab;
}

function updateInfo(data, from) {
    if(from == 'userInfo') {
        model.value.name = data.name;
        model.value.email = data.email;
        updateUserInfo();
    }else {
        model.value.old_password = data.old_password
        model.value.password = data.password
        model.value.password_confirmation = data.password_confirmation
        updatePassword();
    }
}

function updateUserInfo() {
    isDisabled.value = true
    store
        .dispatch('updateAccount', {
            name: model.value.name,
            email: model.value.email
        })
        .then((res) => {
            isDisabled.value = false
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
        })
        .catch((err) => {
            isDisabled.value = false
            if(err.response) {
                if (err.response.data) {
                    let errMasg;
                    if (err.response.data.hasOwnProperty("message")) {
                        errMasg = err.response.data.message
                    } else {
                        errMasg = err.response.data.error
                    }
                    notify({
                        group: "error",
                        title: "Error",
                        text: errMasg
                    }, 4000)
                }
            }
        })
}

function updatePassword() {
    isDisabled2.value = true
    store
        .dispatch('updatePassword', {
            current_password: model.value.old_password,
            new_password: model.value.password,
            password_confirmation: model.value.password_confirmation
        })
        .then((res) => {
            isDisabled2.value = false
            model.value.old_password = ''
            model.value.password = ''
            model.value.password_confirmation = ''
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000)
        })
        .catch((err) => {
            isDisabled2.value = false
            if(err.response) {
                if (err.response.data) {
                    let errMasg;
                    if (err.response.data.hasOwnProperty("message")) {
                        errMasg = err.response.data.message
                    } else {
                        errMasg = err.response.data.error
                    }
                    notify({
                        group: "error",
                        title: "Error",
                        text: errMasg
                    }, 4000)
                }
            }
        })
}

function getLoginHistory() {
    store
        .dispatch('getLoginHistory', model.value.email)
        .then((res) => {})
        .catch((err) => {
            isDisabled2.value = false
            if(err.response) {
                if (err.response.data) {
                    let errMasg;
                    if (err.response.data.hasOwnProperty("message")) {
                        errMasg = err.response.data.message
                    } else {
                        errMasg = err.response.data.error
                    }
                    notify({
                        group: "error",
                        title: "Error",
                        text: errMasg
                    }, 4000)
                }
            }
        })
}

onMounted(() => {
    getLoginHistory();
});
</script>

<style>

</style>