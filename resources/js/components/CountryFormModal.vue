<script setup>
    import Modal from "@/components/Modal.vue";
    import {ref, watch} from "vue";
    const emit = defineEmits([
        'updateTable'
    ])
    import axios from "axios";
    const props =defineProps({
        showModal : Boolean ,
        closeModal : Function ,
        selectedCountry : Object ,
    })
    const countryData = ref({
        id:null,
        name:'',
        code:'',
        newConfirmed:0,
        totalConfirmed:0,
        newDeaths:0,
        totalDeaths:0,
        newRecovered:0,
        totalRecovered:0,
    })

    const clearForm = ()=>{
        countryData.value = {
            id:null,
            name:'',
            code:'',
            newConfirmed:0,
            totalConfirmed:0,
            newDeaths:0,
            totalDeaths:0,
            newRecovered:0,
            totalRecovered:0,
        }
    }
    watch(() => _.cloneDeep(props.selectedCountry) , (currentValue , oldValue)=>{
        if(currentValue && currentValue.id){
            countryData.value.id = currentValue.id

            countryData.value.name = currentValue.name
            countryData.value.code = currentValue.code
            countryData.value.newConfirmed = currentValue.newConfirmed
            countryData.value.totalConfirmed = currentValue.totalConfirmed

            countryData.value.newDeaths = currentValue.newDeaths
            countryData.value.totalDeaths = currentValue.totalDeaths

            countryData.value.newRecovered = currentValue.newRecovered
            countryData.value.totalRecovered = currentValue.totalRecovered
        }
        else{
            clearForm()
        }
    })


    const handleCountryFormSubmit = ()=>{
        // if there is an id then we are updating
        if(countryData.value.id){
            axios.patch(route('country.update' ,countryData.value.id ) , countryData.value)
                .then((res)=>{
                    emit('updateTable')
                    props.closeModal()
                    clearForm()

                })
                .catch((err)=>{
                    console.log(err.response)
            })
        }else{
            axios.post(route('country.store') , countryData.value)
                .then((res)=>{
                    emit('updateTable')
                    props.closeModal()
                    clearForm()
                })
                .catch((err)=>{
                    console.log(err.response)
                })
        }
    }
</script>

<template>
    <Modal :show="showModal" @close="closeModal">
        <div>
            <form @submit.prevent="handleCountryFormSubmit">
                <div class="overflow-hidden sm:rounded-md">
                    <div class="bg-white px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium text-gray-700">Country name</label>
                                <input type="text" v-model="countryData.name" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="last-name" class="block text-sm font-medium text-gray-700">Country Code</label>
                                <input type="text" v-model="countryData.code" name="last-name" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium text-gray-700">Today Confirmed</label>
                                <input type="number" v-model="countryData.newConfirmed" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="last-name" class="block text-sm font-medium text-gray-700">Total Confirmed</label>
                                <input type="number" v-model="countryData.totalConfirmed" name="last-name" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium text-gray-700">Today Recovered</label>
                                <input type="number" v-model="countryData.newRecovered" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="last-name" class="block text-sm font-medium text-gray-700">Total Recovered</label>
                                <input type="number" v-model="countryData.totalRecovered" name="last-name" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium text-gray-700">Today Deaths</label>
                                <input type="number" v-model="countryData.newDeaths" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="last-name" class="block text-sm font-medium text-gray-700">Total Deaths</label>
                                <input type="number" v-model="countryData.totalDeaths" name="last-name" id="last-name" autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>


<style scoped>

</style>
