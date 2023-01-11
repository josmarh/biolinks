<template>
    <div>
        <project-breadcrumbs
            v-if="projectInfo.data"
            currentPage="Coupons" 
            :projectInfo="projectInfo.data" 
        />
        <div class="flex justify-between">
            <div class="mt-4">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Coupons
                </h1>
                <p class="text-gray-500 text-sm font-bold">
                    Create discount coupon codes for your products. Understand the restrictions on coupons.
                </p>
            </div>
            <div class="mt-6">
                <button type="button" @click="newCoupon"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-5 py-2.5 mr-2 capitalize
                    dark:bg-blue-600 dark:hover:bg-blue-700 
                    focus:outline-none dark:focus:ring-blue-800">
                    <font-awesome-icon icon="fa-solid fa-plus" />
                    Create New Coupon
                </button>
            </div>
        </div>
        <div class="mt-10">
            <coupon-list :data="coupons.data" :meta="coupons.meta" />
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { notify } from 'notiwind';
import ProjectBreadcrumbs from '../../components/ProjectBreadcrumbs.vue';
import CouponList from '../../components/products/CouponList.vue';
import project from '../../store/project';
import productStore from '../../store/product-store';
import productData from '../../includes/product-default-data'

const route = useRoute();
const router = useRouter();
const projectInfo = computed(() => project.state.projects);
const coupons = computed(() => productStore.state.coupons);

function newCoupon() {
    router.push({
        name: 'CouponNewForm'
    })
}

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
    productStore.dispatch('getCoupons', route.params.id)
})
</script>

<style>

</style>