<template>
    <div class="md:grid grid-cols-12 gap-6">
        <div v-for="(item, i) in stats" :key="i"
            class="lg:col-span-3 md:col-span-6">
            <div class="block max-w-sm p-6 bg-white 
                border border-gray-200 shadow-md dark:bg-gray-800 
                dark:border-gray-700 dark:hover:bg-gray-700 
                text-center capitalize">
                <div class="flex justify-center items-center 
                    w-14 h-14 bg-blue-200 mb-4 mx-auto">
                    <font-awesome-icon :icon="item.icon" class="w-5 h-5" />
                </div>
                <h5 class="mb-2 text-2xl font-bold 
                    tracking-tight text-gray-700 
                    dark:text-white">
                    {{item.total}}
                </h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">
                    {{item.label}}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>

const stats = [
    {label: 'total clicks', total: 0, icon: 'fa-solid fa-chart-column'},
    {label: 'total links', total: 0, icon: 'fa-solid fa-link'},
    {label: 'total leads', total: 0, icon: 'fa-solid fa-envelope'},
]
</script>

<style>

</style>