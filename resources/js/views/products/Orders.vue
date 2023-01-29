<template>
    <tabs variant="pills" v-model="activeTab" class="p-5"> <!-- class appends to content DIV for all tabs -->
        <tab name="first" title="ORDERS">
            <order-list :data="orders.data" :meta="orders.meta" />
        </tab>
        <tab name="second" title="SUBSCRIPTIONS">
            <subscription-list :data="subscriptions.data" :meta="orders.meta" />
        </tab>
    </tabs>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router';
import { Tabs, Tab } from 'flowbite-vue'
import OrderList from '../../components/products/OrderList.vue'
import SubscriptionList from '../../components/products/SubscriptionList.vue';
import productStore from '../../store/product-store';

const route = useRoute()
const orders = computed(() => productStore.state.orders)
const subscriptions = computed(() => productStore.state.subscriptions)
const activeTab = ref('first')

onMounted(() => {
    productStore.dispatch('getOrders', route.params.id)
    productStore.dispatch('getSubscriptions', route.params.id)
})
</script>

<style>

</style>