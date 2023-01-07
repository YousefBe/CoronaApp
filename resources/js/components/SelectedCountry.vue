<script setup>
    defineProps({
        country : Object ,
        countryError : Boolean ,
    })
</script>
<template>
    <div class="rounded bg-white overflow-hidden h-full w-full shadow-lg">
        <!--       a country is selected         -->
        <div v-if="country">
            <div class="px-6 py-4">
                <div class="font-bold text-3xl mb-2">{{ country.name }}</div>
            </div>

            <!--    stats        -->
            <div class="px-6 py-4 mb-8">
                <div class="flex justify-between w-full items-center">
                    <p class="font-bold text-lg">New Confirmed</p>
                    <p class="text-gray-500" >{{country.newConfirmed}}</p>
                </div>
                <div class="flex justify-between w-full items-center">
                    <p class="font-bold text-lg">TotalConfirmed</p>
                    <p class="text-gray-500" >{{country.totalConfirmed}}</p>
                </div>
                <br>
                <div class="flex justify-between w-full items-center">
                    <p class="font-bold text-lg">Total Recovered</p>
                    <p class="text-gray-500" >{{country.totalRecovered}}</p>
                </div>
                <div class="flex justify-between w-full items-center">
                    <p class="font-bold text-lg">New Recovered</p>
                    <p class="text-gray-500" >{{country.newRecovered}}</p>
                </div>
                <br>

                <div class="flex justify-between w-full items-center">
                    <p class="font-bold text-lg">Total Deaths</p>
                    <p class="text-gray-500" >{{country.totalDeaths}}</p>
                </div>
                <div class="flex justify-between w-full items-center">
                    <p class="font-bold text-lg">New Deaths</p>
                    <p class="text-gray-500" >{{country.newDeaths}}</p>
                </div>
                <br>
                <div class="flex justify-between w-full items-center">
                    <p class="font-bold text-lg">Updated At</p>
                    <p class="text-gray-500" >{{country.updatedAt}}</p>
                </div>
            </div>

            <div class="px-6 py-4 mb-8">
                <p class="mb-1">Check a list of our supported
                    <span @click="$inertia.get('/countries')" class="text-indigo-600 decoration-2 cursor-pointer underline">countries</span>
                </p>
            </div>

        </div>
        <!--  if no country is selected   -->
        <div class="flex items-center justify-center w-full h-full" v-else-if="!country && countryError">
            <div class="text-center">
                <h3 class="mb-4">The Country You clicked Is Not Supported , please Choose another country</h3>
                <p class="mb-4">or</p>
                <p  >Check a list of our supported
                    <span @click="$inertia.get('/countries')" class="text-indigo-600 decoration-2 underline">countries</span>
                </p>
            </div>
        </div>
        <!--  if no country is selected   -->
        <div class="flex items-center justify-center w-full h-full" v-else>
            <div class="text-center">
                <h3 class="mb-4">PLease Click On Map To Check Country Details</h3>
                <p class="mb-4">or</p>
                <p  >Check a list of our supported
                    <span @click="$inertia.get('/countries')" class="text-indigo-600 decoration-2 underline">countries</span>
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
