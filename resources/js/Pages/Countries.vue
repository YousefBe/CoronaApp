<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import {VueGoodTable} from 'vue-good-table-next';
import {onMounted, ref , toRaw} from "vue";
import axios from "axios";
import CountryFormModal from "@/components/CountryFormModal.vue";

const columns = ref([
    {
        label: 'Name',
        field: 'name',
        sortable: false,

    },
    {
        label: 'Total Confirmed Cases',
        field: 'totalConfirmed',
        type: 'number',
        sortable: true,
    },
    {
        label: 'New Cases',
        field: 'newConfirmed',
        type: 'number',
        sortable: false,

    },
    {
        label: 'Updated At',
        sortable: false,
        field: 'updatedAt',
    },
    {
        label: 'Actions',
        field: 'actions',
        sortable: false,

    },
])
const rows = ref([])
const totalCountriesCount = ref(0)
const showModal = ref(false)
const page = ref(1)
const isLoading = ref(false)
const sortBy = ref('')
const sortOrder = ref('asc')
const searchTerm = ref('')

const getCountries = ()=>{
    axios.get(route('countries'), {
        params:{
            page:page.value,
            sortBy:sortBy.value,
            sortOrder:sortOrder.value,
            searchTerm:searchTerm.value
        }
    })
        .then(res=>{
            totalCountriesCount.value =res.data.meta.total
            rows.value =res.data.data
        })
        .catch((err)=>{
            console.log(err.response)
        })
}
onMounted(()=>{
  getCountries()
})
const onPageChange = (params)=>{
    page.value = params.currentPage
    getCountries()
}
const onSortChange = (sort)=>{
    //from proxy to array
    const sortRaw = toRaw(sort)
    if(sortRaw[0].type == 'desc'){
        sortOrder.value = sortRaw[0].type
        getCountries()
        return
    }
    sortOrder.value = 'asc'
    getCountries()
}
function lockupCountry(query){
    page.value = 1
    searchTerm.value = query.searchTerm
    getCountries()
}

const closeModal = ()=>{
    selectedCountry.value = null
    showModal.value = false
}

const addCountry = (data)=>{
    selectedCountry.value = null
    showModal.value = true
}
const updateTable = ()=>{
    selectedCountry.value = null
    getCountries()
}


const selectedCountry = ref(null)
const editCountry = (data)=>{
    const clickedRowData = toRaw(data)
    axios.get('/countries/' + clickedRowData.id)
        .then((res)=>{
            console.log(res)
            selectedCountry.value = res.data
            showModal.value = true
        })
        .catch((err)=>{
            console.log(err.response)
        })
}



</script>
<template>
    <Head title="Counties"/>
    <div
        class="relative flex flex-col  p-6 items-top justify-start min-h-screen bg-gray-900  sm:items-center sm:pt-0">
        <p class="text-white text-2xl my-4">Corona Virus Tracker</p>
        <country-form-modal :closeModal="closeModal" :showModal="showModal" :selectedCountry="selectedCountry" @updateTable="updateTable"/>
        <div class="w-full">
            <div class="w-full flex justify-end items-center mb-4">
                <button @click="addCountry" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                    Add
                </button>
            </div>
            <vue-good-table
                mode="remote"
                :columns="columns"
                :rows="rows"
                :totalRows="totalCountriesCount"
                v-on:search='lockupCountry'
                :isLoading.sync="isLoading"
                v-on:page-change="onPageChange"
                v-on:sort-change="onSortChange"
                :search-options="{
                    enabled: true
                  }"
                :pagination-options="{
                enabled: true,
                perPageDropdownEnabled: false,
              }">
                <template #table-row="props">
                 <span v-if="props.column.label =='Actions'">
                   <button @click="editCountry(props.row)" class="inline-flex items-center justify-center w-10 h-10 mr-2 text-gray-700 transition-colors duration-150 bg-white rounded-full focus:shadow-outline hover:bg-gray-200">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                    </button>
                 </span>
                </template>
            </vue-good-table>
        </div>
    </div>
</template>

<style scoped>

</style>
