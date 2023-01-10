<template>
    <Breadcrumbs 
        v-if="projectInfo.data"
        :currentPage="'Update Category: '+ model.title " 
        :projectInfo="projectInfo.data"
        :prevPage="{
            to: 'ProductCategory',
            label: 'Category'
        }"
    />
    <!-- Form -->
    <div class="mt-8">
        <div class="w-full p-4 bg-white border border-gray-200 shadow-md 
        sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            <form class="space-y-6" @submit.prevent="updateCategory">
                <div>
                    <label for="title" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        Category Title
                    </label>
                    <input type="text" name="title" id="title" v-model="model.title"
                    class="bg-gray-50 border border-gray-300 text-gray-900 
                    text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 
                    dark:placeholder-gray-400 dark:text-white" placeholder="" required>
                </div>
                <div>
                    <label for="slug" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        Category Slug
                    </label>
                    <input type="text" name="slug" id="slug" v-model="model.slug"
                    class="bg-gray-50 border border-gray-300 text-gray-900 
                    text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 
                    dark:placeholder-gray-400 dark:text-white" placeholder="" required>
                </div>
                <hr class="mt-6">
                <div class="mt-6">
                    <p class="text-sm text-gray-600">
                        Re-arrange the view order of the products in this category. 
                        The highest product shows first.
                    </p>
                    <!-- Products -->
                    <div class="mt-4" v-if="model.products.length">
                        <ul class="text-sm font-medium text-gray-900 
                        rounded-lg dark:bg-gray-700 dark:border-gray-600 
                        dark:text-white">
                        <draggable v-model="model.products"
                            @start="drag=true" 
                            @end="drag=false"
                            item-key="id" 
                            class="mt-6">
                            <template #item="{element}">
                                <li class="w-full px-4 py-2.5 bg-gray-100
                                    border-b border-gray-200 rounded-lg 
                                    dark:border-gray-600">
                                    <font-awesome-icon icon="fa-solid fa-up-down-left-right" class="mr-2" />
                                    {{ element.name }}
                                </li>                                
                            </template>
                        </draggable>
                        </ul>
                    </div>
                </div>
                <button type="submit" 
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:outline-none focus:ring-blue-300 
                    font-medium text-sm px-5 py-2.5 text-center 
                    dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    :disabled="isDisabled">
                    Update
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import draggable from 'vuedraggable'
import Breadcrumbs from '../../components/4StageBreadcrumbs.vue'
import project from '../../store/project';
import productStore from '../../store/product-store'

const route = useRoute();
const projectInfo = computed(() => project.state.projects)
const category = computed(() => productStore.state.category)
const isDisabled = ref(false)

let model = ref({
    id: route.query.cat_id,
    title: '',
    slug: '',
    products: []
})

watch(category, (newVal, oldVal) => {
    model.value = newVal.data
})

function updateCategory() {
    isDisabled.value = true
    productStore
        .dispatch('updateCategory', {
            id: model.value.id,
            title: model.value.title,
            slug: model.value.slug,
            products: JSON.stringify(model.value.products)
        })
        .then((res) => {
            isDisabled.value = false
            productStore.dispatch('getCategory', model.value.id)
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

onMounted(() => {
    project.dispatch('getProjectInfo', route.params.id)
    productStore.dispatch('getCategory', model.value.id)
})
</script>

<style>

</style>