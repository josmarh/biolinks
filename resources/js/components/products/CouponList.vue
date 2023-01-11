<template>
    <div v-if="data.length">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-sm text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th v-for="theader in theaders" :key="theader" 
                        scope="col" class="px-6 py-3">
                        {{theader}}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data" :key="item.id"
                    class="bg-white border-b hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium 
                    text-gray-900 dark:text-white whitespace-nowrap">
                        <router-link :to="{
                        name: 'CouponUpdateForm', 
                        params: {id: $route.params.id}, 
                        query: {cop_id: item.id}}"
                        class="hover:text-blue-600">
                            {{ item.couponCode }}
                        </router-link>
                    </th>
                    <td class="px-6 py-4">

                    </td>
                    <td class="px-6 py-4">
                        {{ !item.expiryDate ? 'Active' : 'Inactive' }}
                    </td>
                    <td class="px-6 py-4">
                        0
                    </td>
                    <td class="px-6 py-4">
                        {{ item.isExpires == 'no' ? 'No expiration.' : item.expiryDate }}
                    </td>
                    <td class="px-6 py-4">
                        <button type="button" @click="deleteModal(item.id)"
                            class="text-gray-500 bg-gray-100 hover:bg-gray-200 
                            focus:outline-none focus:ring-gray-100
                            font-medium text-sm px-5 py-2.5 text-center 
                            inline-flex items-center dark:focus:ring-gray-500 mr-2">
                            <font-awesome-icon 
                                icon="fa-solid fa-trash"
                                class="" />
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="flex justify-center mt-5 mb-5">
            <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm"
                aria-label="Pagination">
                <a v-for="(link, i) of meta.links" 
                    :key="i"
                    :disabled="!link.url"
                    href="#"
                    @click="getForPage($event,link)"
                    aria-current="page"
                    class="relative inline-flex items-center px-4 py-2 border text-sm
                    font-medium whitespace-nowrap"
                    :class="[
                        link.active 
                        ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' 
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                        i === 0 ? 'rounded-l-md' : '',
                        i === meta.links.length - 1 ? 'rounded-r-md' : '',
                    ]"
                    v-html="link.label">
                </a>
            </nav>
        </div>
    </div>
    <confirm-delete 
        from="coupon" 
        :showDelete="showDelete" 
        :isDisabled="isDisabled"
        @confirm="deleteCoupon"
        @cancel="cancelModal"
    />
</template>

<script setup>
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { notify } from 'notiwind';
import ConfirmDelete from '../ConfirmDelete.vue'
import productStore from '../../store/product-store';

const route = useRoute();
const router = useRouter();
const theaders = ['coupon','discount','status','number used','date expired','']
const props = defineProps({
    data: Array,
    meta: Object
})
let isDisabled = ref(false)
let showDelete = ref(false)
let copId = ref(null)

function deleteModal(id) {
    showDelete.value = true
    copId.value = id
}

function cancelModal() {
    showDelete.value = false
}

function deleteCoupon() {
    isDisabled.value = true
    productStore
        .dispatch('deleteCoupon', copId.value)
        .then((res) => {
            isDisabled.value = false
            showDelete.value = false
            productStore.dispatch('getCoupons', route.params.id)
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
        })
        .catch((err) => {
            isDisabled.value = false
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

const getForPage = (ev,link) => {
    ev.preventDefault();
    if(!link.url || link.active) {
        return;
    }
    productStore.dispatch('paginateCoupon', link.url);
}
</script>

<style>

</style>