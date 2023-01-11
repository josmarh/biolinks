<template>
    <div v-if="$route.name == 'CouponNewForm'">
        <Breadcrumbs 
            v-if="projectInfo.data"
            currentPage="Create Product Coupon" 
            :projectInfo="projectInfo.data"
            :prevPage="{
                to: 'ProductCouponCode',
                label: 'Coupons'
            }"
        />
    </div>
    <div class="mt-4">
        <h1 class="py-4 text-3xl font-bold text-gray-800"
            v-if="$route.name == 'CouponNewForm'">
            Create New Coupon
        </h1>
        <h1 class="py-4 text-3xl font-bold text-gray-800"
            v-else>
            Update Coupon
        </h1>
    </div>
    <!-- Form -->
    <div class="mt-8">
        <div class="w-full p-4 bg-white border border-gray-200 shadow-md 
            sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            <form class="space-y-6" @submit.prevent="saveCoupon">
                <div class="md:grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <div>
                            <label for="couponCode" 
                                class="block mb-2 text-sm font-medium 
                                text-gray-900 dark:text-white">
                                Coupon Code
                            </label>
                            <input type="text" id="couponCode" 
                            v-model="model.couponCode"
                            class="bg-gray-50 border border-gray-300 
                            text-gray-900 text-sm  
                            focus:ring-blue-500 focus:border-blue-500 
                            block w-full p-2.5 dark:bg-gray-700 
                            dark:border-gray-600 dark:placeholder-gray-400 
                            dark:text-white dark:focus:ring-blue-500 
                            dark:focus:border-blue-500" 
                            placeholder="Ex: 100DOLLAROFF" required>
                            <p class="mt-3 text-gray-600 text-sm"> 
                                Letters and numbers only!
                            </p>
                        </div>
                        <div class="mt-4">
                            <discount-type :data="model" @updateForm="updateCouponData" />
                        </div>
                    </div>
                    <div>
                        <apply-to :data="model" @updateForm="updateCouponData" />
                        <div class="mt-4">
                            <limit-type :data="model" @updateForm="updateCouponData" />
                        </div>
                        <div class="mt-4">
                            <label for="limitPerCustomer" 
                                class="block mb-2 text-sm font-medium 
                                text-gray-900 dark:text-white">
                                Limit the usage per customer
                            </label>
                            <select id="limitPerCustomer" 
                                v-model="model.limitPerCustomer"
                                class="bg-gray-50 border border-gray-300 
                                text-gray-900 text-sm focus:ring-blue-500 
                                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                                dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 
                                dark:focus:border-blue-500">
                                <option value="unlimited">Unlimited uses per customer</option>
                                <option value="used_once">Used only once per customer</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <expires :data="model" @updateForm="updateCouponData" />
                        </div>
                    </div>
                </div>
                <button type="submit" 
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:outline-none focus:ring-blue-300 
                    font-medium text-sm px-5 py-2.5 text-center 
                    dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    :disabled="isDisabled">
                    Save
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import { notify } from 'notiwind';
import { useRoute, useRouter } from 'vue-router';
import Breadcrumbs from '../../components/4StageBreadcrumbs.vue'
import ApplyTo from '../../components/products/coupon-fields/ApplyTo.vue'
import DiscountType from '../../components/products/coupon-fields/DiscountType.vue';
import LimitType from '../../components/products/coupon-fields/LimitType.vue';
import Expires from '../../components/products/coupon-fields/Expires.vue'
import project from '../../store/project';
import productStore from '../../store/product-store'

const route = useRoute();
const router = useRouter();
const projectInfo = computed(() => project.state.projects)
let isDisabled = ref(false)

let model = ref({
    id: null,
    couponCode: '',
    applyTo: {
        apply: 'all_products',
        specificProduct: 'no_products',
        specificCourse: 'no_courses',
        membership: 'exclude_membership'
    },
    discount: {
        type: 'percentage_off',
        percentage: null,
        pacentageRecurringPurchase: 'disable',
        dollarOff: null,
        freeShipping: null,
    },
    couponLimitType: 'unlimited',
    couponLimitedCount: null,
    limitPerCustomer: 'unlimited',
    isExpires: 'no',
    expiryDate: null
})

watch(() => model.value.expiryDate, (newVal, oldVal) => {
    model.value.expiryDate = dformat(newVal)
})

function updateCouponData(data) {
    model.value = data
}

function saveCoupon() {
    isDisabled.value = true
    productStore
        .dispatch('storeCoupon', {
            projectId: route.params.id,
            couponCode: model.value.couponCode,
            applyTo: JSON.stringify(model.value.applyTo),
            discount: JSON.stringify(model.value.discount),
            couponLimitType: model.value.couponLimitType,
            couponLimitedCount: model.value.couponLimitedCount,
            limitPerCustomer: model.value.limitPerCustomer,
            isExpires: model.value.isExpires,
            expiryDate: model.value.expiryDate
        })
        .then((res) => {
            isDisabled.value = false
            router.push({
                name: 'ProductCouponCode',
                params: {id: route.params.id}
            })
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

function updateCoupon() {
    isDisabled.value = true
    productStore
        .dispatch('updateCoupon', {
            id: route.query.cop_id,
            projectId: route.params.id,
            couponCode: model.value.couponCode,
            applyTo: JSON.stringify(model.value.applyTo),
            discount: JSON.stringify(model.value.discount),
            couponLimitType: model.value.couponLimitType,
            couponLimitedCount: model.value.couponLimitedCount,
            limitPerCustomer: model.value.limitPerCustomer,
            isExpires: model.value.isExpires,
            expiryDate: model.value.expiryDate
        })
        .then((res) => {
            isDisabled.value = false
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

function dformat(date) {
    let d = new Date(date);
    const day = d.getDate() <= 9 == 1 ? `0${d.getDate()}` : d.getDate();
    const month = d.getMonth()+1  <= 9 == 1 ? `0${d.getMonth()+1}` : d.getMonth()+1;
    const year = d.getFullYear();
    const time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    return `${year}-${month}-${day}`;
}

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
})
</script>

<style>

</style>