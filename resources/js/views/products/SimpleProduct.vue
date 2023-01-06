<template>
    <div>
        <project-breadcrumbs
            v-if="projectInfo.data"
            currentPage="Products" 
            :projectInfo="projectInfo.data" 
        />
        <div class="flex justify-between">
            <div class="mt-4">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    Simple Products
                </h1>
                <p class="text-gray-500 text-sm font-bold">
                    This area is for creating simple digital (digital download) or physical products.
                </p>
            </div>
            <div class="mt-6">
                <button type="button" @click="newProduct"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-5 py-2.5 mr-2 capitalize
                    dark:bg-blue-600 dark:hover:bg-blue-700 
                    focus:outline-none dark:focus:ring-blue-800">
                    <font-awesome-icon icon="fa-solid fa-plus" />
                    Create New Product
                </button>
            </div>
        </div>
        <div class="flex mt-10 gap-10">
            <div class="w-96">
                <label for="product_search" 
                    class="block mb-2 text-sm 
                    font-medium text-gray-900 
                    dark:text-white">
                    Search for product
                </label>
                <input type="text" id="product_search" 
                v-model="searchProduct.title"
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Search by title">
            </div>
            <product-list :data="products.data" :meta="products.meta" />
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { notify } from 'notiwind';
import ProjectBreadcrumbs from '../../components/ProjectBreadcrumbs.vue';
import ProductList from '../../components/products/ProductList.vue';
import project from '../../store/project';
import productStore from '../../store/product-store';
import productData from '../../includes/product-default-data'

const route = useRoute();
const router = useRouter();
const projectInfo = computed(() => project.state.projects)
const products = computed(() => productStore.state.products)
const isDisabled = ref(false)
let searchProduct = ref({
    title: '',
    projectId: route.params.id
})

watch(searchProduct, (newVal, oldVal) => {
    setTimeout(() => {
        productStore.dispatch('searchProducts', searchProduct.value)
    }, 1200)
}, {deep: true})

function newProduct() {
    isDisabled.value = true
    productStore
        .dispatch('storeProduct', {
            projectId: route.params.id,
            title: productData.title,
            description: productData.description,
            category: JSON.stringify(productData.category),
            images: JSON.stringify(productData.images),
            pricing: JSON.stringify(productData.pricing),
            shipping: JSON.stringify(productData.shipping),
            inventory: JSON.stringify(productData.inventory),
            prodFiles: JSON.stringify(productData.files),
            extLink: productData.extLink
        })
        .then((res) => {
            isDisabled.value = false
            router.push({
                name: 'NewProduct',
                params: {id: route.params.id},
                query: {pid: res.productId}
            })
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

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
    productStore.dispatch('getProducts', route.params.id)
})
</script>

<style>

</style>