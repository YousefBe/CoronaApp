<script setup>
import {Head} from '@inertiajs/inertia-vue3';
import {ref, onMounted, watch} from 'vue'

const props =defineProps({
    laravelVersion: String,
    phpVersion: String,
    tomtomKey : String
});
import StatsCard from "@/components/StatsCard.vue";
import WelcomeActionsCard from "@/components/WelcomeActionsCard.vue";
import SelectedCountry from "@/components/SelectedCountry.vue";

console.log(props.tomtomKey)
const statistics = ref([
    {
        'new': 0,
        'total': 0,
        "title": "recovered"
    }, {
        'new': 0,
        'total': 0,
        "title": "confirmed"
    },
    {
        'new': 0,
        'total': 0,
        "title": "Deaths"
    }

])

const selectedCountry = ref(null)
const selectedCountryError = ref(false)

onMounted(() => {
    var map = tt.map({
        key: props.tomtomKey ,
        container: "map",
    })
    map.on('click', (e) => {
        console.log(e)
        selectedCountryError.value = false
        axios.get(route('view.country'), {
            params: {
                long: e.lngLat.lng,
                lat: e.lngLat.lat
            }
        })
            .then((res) => {
                selectedCountry.value = res.data
            })
            .catch((err) => {
                selectedCountry.value = null
                selectedCountryError.value = true
            })
    })
})

const updateStats = (data) => {
    statistics.value = data.stats
    console.log(statistics.value)
}
</script>

<template>
    <Head title="Welcome"/>

    <div
        class="relative flex flex-col justify-center p-6 items-top justify-center min-h-screen bg-gray-900 sm:items-center sm:pt-0">
        <p class="text-white text-2xl my-4">Corona Virus Tracker</p>
        <div class="flex flex-col lg:flex-row justify-between min-h-[270px] w-full mb-2">
            <WelcomeActionsCard @statsUpdated="updateStats"/>
            <StatsCard cardType="statsCard" v-for="(stat , index) in statistics"
                       :todayStatCount="stat.new" :totalStatCount="stat.total" :key="index" :title="stat.title"/>
        </div>
        <section class="w-full flex flex-col lg:flex-row justify-between">
            <div id="map" class="w-full md:w-2/3"></div>
            <div class="w-full lg:w-1/3 lg:px-6 mt-4 lg:mt-0">
                <SelectedCountry :countryError="selectedCountryError" :country="selectedCountry"/>
            </div>
        </section>
    </div>
</template>
<style>
#map {
    height: 500px;
    width: 100%;
    margin: 0 auto;
    border-radius: 12px;
}

.map-popup {
    border-radius: 12px;
    min-width: 200px;
    transition: .2s ease-out;
}
</style>
