
<script setup>
const emit = defineEmits(['statsUpdated'])

import {  Link ,  } from '@inertiajs/inertia-vue3';
    const getLatestUpdates =()=>{
        axios.get(route('latest.updates')).then((res)=>{
            emit('statsUpdated' , res.data)
        }).catch((err)=>{
            console.log(err.response)
        })
    }
</script>
<template>
    <div class="w-full p-2 lg:w-1/4 ">
        <div
            class="flex flex-col px-6 py-8 overflow-hidden bg-white
            rounded-xl shadow-lg duration-300 2xl group">
            <h3 class="text-3xl mb-2 font-bold text-gray-700">Welcome to Covid Tracker </h3>
            <p class="mb-4" >We Track Latest Covid Updates worldwide ❤️ </p>
            <p class="">
                Click  <span class="text-indigo-600 decoration-2 cursor-pointer underline" @click="getLatestUpdates"  >Here</span> to check for latest updates
            </p>
        </div>
    </div>
</template>

<style scoped>

</style>
