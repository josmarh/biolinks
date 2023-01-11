<template>
    <div>
        <Breadcrumbs 
        v-if="projectInfo.data"
        :currentPage="product.data.title" 
        :projectInfo="projectInfo.data" 
        :prevPage="{
            to: 'ProductSimple',
            label: 'Products'
        }"
        />
        <div class="flex flex-wrap mt-8">
            <div class="w-full">
                <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                    <li class="-mb-px mr-2 last:mr-0 flex-auto cursor-pointer">
                        <a class="text-xs px-5 py-3 shadow-lg block leading-normal" 
                            @click="toggleTabs(1)" 
                            :class="{'text-blue-600 bg-white': openTab !== 1, 'text-white bg-blue-600': openTab === 1}">
                            <span class="uppercase font-bold ">
                                <font-awesome-icon icon="fa-solid fa-gear mr-1 mt-0.5" />
                                Main Settings
                            </span>
                            <p class="mt-2 text-sm">
                                Set your product title, categories, and brief description here.
                            </p>
                        </a>
                    </li>
                    <li class="-mb-px mr-2 last:mr-0 flex-auto cursor-pointer">
                        <a class="text-xs px-5 py-3 shadow-lg block leading-normal" 
                            @click="toggleTabs(2)" 
                            :class="{'text-blue-600 bg-white': openTab !== 2, 'text-white bg-blue-600': openTab === 2}">
                            <span class="uppercase font-bold ">
                                <font-awesome-icon icon="fa-solid fa-sliders mr-1 mt-0.5" />
                                price/product options
                            </span>
                            <p class="mt-2 text-sm">
                                Set pricing, variants, stock, shipping, and download files.
                            </p>
                        </a>
                    </li>
                </ul>
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 mt-4 shadow-lg rounded">
                    <div class="px-4 py-5 flex-auto">
                        <div class="tab-content tab-space">
                            <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                                <new-product-from-1 :data="productModel" @updateModel="updateModel" />
                            </div>
                            <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                                <new-product-from-2 :data="productModel" @updateModel="updateModel" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import Breadcrumbs from '../../components/4StageBreadcrumbs.vue'
import NewProductFrom1 from '../../components/products/NewProductFrom1.vue';
import NewProductFrom2 from '../../components/products/NewProductFrom2.vue';
import project from '../../store/project';
import productStore from '../../store/product-store'

const route = useRoute();
const projectInfo = computed(() => project.state.projects)
const product = computed(() => productStore.state.product)

let openTab = ref(1)
let productModel = ref({
    id: route.query.pid,
    title:'Your awesome product!',
    description: '',
    category: [],
    catCheck: [],
    images: [],
    pricing: {
        price: 10.05,
        comparePrice: null,
        paymentType: 'one-time',
    },
    shipping: {
        isRequired: 'no',
        weight: 0
    },
    inventory: {
        sku: '',
        track: 'no',
        inventory: 0
    },
    files: [],
    extLink: '',
    linkId: null,
})

watch(product, (newVal, oldVal) => {
    productModel.value = newVal.data
})

function toggleTabs(tabNumber) {
    openTab.value = tabNumber
}

function updateModel(data) {
    productModel.value = data
    updateProduct();
}

function updateProduct() {
    productStore
        .dispatch('updateProduct', {
            id: route.query.pid,
            linkId: productModel.value.linkId,
            title: productModel.value.title,
            description: productModel.value.description,
            category: JSON.stringify(productModel.value.category),
            images: JSON.stringify(productModel.value.images),
            pricing: JSON.stringify(productModel.value.pricing),
            shipping: JSON.stringify(productModel.value.shipping),
            inventory: JSON.stringify(productModel.value.inventory),
            prodFiles: JSON.stringify(productModel.value.files),
            extLink: productModel.value.extLink
        })
        .then((res) => {
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
            productStore.dispatch('getProduct', route.query.pid)
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

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
    productStore.dispatch('getProduct', route.query.pid)
})
</script>

<style>

</style>