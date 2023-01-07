<script setup>
    defineProps({
        title: String,
        todayStatCount: Number,
        totalStatCount:Number
    });
</script>
<template>
    <div class="w-full p-2 lg:w-1/4 ">
        <div
            class="flex flex-col px-6 py-10 overflow-hidden bg-white hover:bg-gradient-to-br
             hover:from-blue-400 hover:via-blue-400 hover:to-blue-500 rounded-xl shadow-lg duration-300 hover:shadow-2xl group">
            <p class="font-bold text-2xl mb-6"> <span class="font-bold text-4xl">{{ todayStatCount }}</span> New {{ title }}</p>
            <p class="font-semibold text-lg"> <span class="font-bold text-lg">{{ totalStatCount }}</span> Total {{ title }}</p>

        </div>
    </div>
</template>

<style scoped>

</style>
