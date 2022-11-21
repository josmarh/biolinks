<template>
    <div>
        <main>
            <section class="absolute w-full h-full">
                <div class="absolute top-0 w-full h-full bg-gray-100"
                style="background-size: 100%; background-repeat: no-repeat;">
                    <div class="container mx-auto px-4 h-full">
                        <div class="flex content-center h-full
                            items-center justify-center">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>

</script>

<style>

</style>