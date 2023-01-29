<template>
    <div>
        <div class="flex justify-between">
            <div class="mt-2">
                <h1 class="py-4 text-3xl font-bold text-gray-800">
                    50 DFY Profit Campaigns
                </h1>
            </div>
        </div>
        <!-- main content -->
        <div class="flex mt-4">
            <div class="block p-6 w-full bg-white border border-gray-200 shadow-md">
                <div class="md:grid grid-cols-12 gap-4">
                    <div v-for="(item, i) in campaigns" :key="i"
                        class="md:col-span-3 col-span-6 flex justify-center">
                        <div>
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium mb-2
                            mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{ i+1 }}
                            </span>
                            <a :href="item" targert="_blank" class="relative inline-flex items-center 
                            justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm 
                            font-medium text-gray-900 rounded-lg group bg-gradient-to-br 
                            from-purple-600 to-blue-500 group-hover:from-purple-600 
                            group-hover:to-blue-500 hover:text-white dark:text-white 
                            focus:ring-4 focus:outline-none focus:ring-blue-300 
                            dark:focus:ring-blue-800">
                                <span class="relative px-5 py-2.5 transition-all ease-in 
                                duration-75 bg-white dark:bg-gray-900 rounded-md 
                                group-hover:bg-opacity-0">
                                    Access Here
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const campaigns = [
    'https://docs.google.com/document/d/1CG-d-ILUi44L5EtMp11kfHwiD8dTUdrBW_tIqnk2eIY/edit?usp=sharing',
    'https://docs.google.com/document/d/1j3sVThlkGWx1AzxG-YyZxIGk2BJ-Qcj6D1xfAWn3nSU/edit?usp=sharing',
    'https://docs.google.com/document/d/19hsvH9xpG3JFCW6pMxwjmpne1ThXEoZFISBLfhOAh30/edit?usp=sharing',
    'https://docs.google.com/document/d/16Z2Kyx85g-sDuzqGeJCQbUn0VjNuR821Iqun26kBe-Q/edit?usp=sharing',
    'https://docs.google.com/document/d/1MfErvYZ4GoW5BMZbfYZZON-fB-nubxQSt3z0iK1teEc/edit?usp=sharing',
    'https://docs.google.com/document/d/1fCnUDHkf_Zynw1VhAYINWb7V4ZiCvQfhFeRhAucVoqE/edit?usp=sharing',
    'https://docs.google.com/document/d/1jfHlIqkaUFL3S4tkuZFCq3eqazX4rJ6kWcG3QLg2trA/edit?usp=sharing',
    'https://docs.google.com/document/d/1a_Ufa8uzcHD79JyiAjC64ajr14v8WKzvJPI37wxU-V4/edit?usp=sharing',
    'https://docs.google.com/document/d/1DAf7WqnGw3ttkZ6S7e1tnbjSS0nPOF4tQIRiTRLratI/edit?usp=sharing',
    'https://docs.google.com/document/d/1KMPVOK2aDrHF9fx55ZtaW5LqvlT6uBjEXOk1t7gSCr8/edit?usp=sharing',
    'https://docs.google.com/document/d/1qHcbryeUgN6SuLbzFfSDFcrHXACDnokOiW1jDulod8Y/edit?usp=sharing',
    'https://docs.google.com/document/d/1oUWcKdVlNzeHXlFAREFZzKcKI7nm8i5yJ-gyPqyNbRQ/edit?usp=sharing',
    'https://docs.google.com/document/d/1Os0CJnQ6zb60EkBfuNmEe8oXKhddXdIn516ij9FODVg/edit?usp=sharing',
    'https://docs.google.com/document/d/1zcfQ4tH9-uf6Znswhl01g9gVtUg1EDjRofKwME6txKE/edit?usp=sharing',
    'https://docs.google.com/document/d/1N4G7T7m8YX6VdEZqQQZFilSionRyaGGE2HohL2OPi0Q/edit?usp=sharing',
    'https://docs.google.com/document/d/1e48D1e24YNvk_cXyjuYz8QWdXfSBOWW4vs9L02wxRzo/edit?usp=sharing',
    'https://docs.google.com/document/d/1dVIMULdgRlZDlcU_4d30oV4ApSim99eBgkMoSnSybio/edit?usp=sharing',
    'https://docs.google.com/document/d/1LPZEVnk6uvMjOsFPpcFFiQmdA-5i8gujFEZnFpjRwKU/edit?usp=sharing',
    'https://docs.google.com/document/d/148zwYeOH0lIp1mpS6YSF1hQ6IT7yK12oCvbnjvUTDeE/edit?usp=sharing',
    'https://docs.google.com/document/d/19CUfIfST6JdjxWmUNqmhSjtTb6I6ivhAovOvu3vewf0/edit?usp=sharing',
    'https://docs.google.com/document/d/1N7enGrp_g-ldaAZ2GFny4T5oFgnC6bRMJsTECtuHgtA/edit?usp=sharing',
    'https://docs.google.com/document/d/1lKF3McO1tI-X8jgrctFwpQsKDEr0tjRweljS8Av38GY/edit?usp=sharing',
    'https://docs.google.com/document/d/1hQm3-l0i2LrSa0eZRz2J53hWk_gUfJQU4EuRnYqsF40/edit?usp=sharing',
    'https://docs.google.com/document/d/1chz5kqCYlFTkQiggJyANmS48tqUktTDfL-rUpvagx3A/edit?usp=sharing',
    'https://docs.google.com/document/d/1gHWdbjq_G8rAz01EfaMPv8TdF0HT8tUhkIlh1ykcbFQ/edit?usp=sharing',
    'https://docs.google.com/document/d/1UBBkflILlObpYKSTkJtnGO558QCN6Rikb2Fk-gdt97Q/edit?usp=sharing',
    'https://docs.google.com/document/d/1c5bQjFLWruCRv0lUHpNIsd7AUsP6NgV8O_kAFjiJ1lo/edit?usp=sharing',
    'https://docs.google.com/document/d/1n7ikv5KQgL7NCL0dp_qcQUtQacVTfSLOSWhWcQbUth0/edit?usp=sharing',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);',
    'javascript:void(0);'

]
</script>

<style>

</style>