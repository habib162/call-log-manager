<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import DataTable from 'datatables.net-dt';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const phoneData = ref({'data':[]});
const loading = ref(true);
new DataTable('#datatableRow');
const getPhoneLog = ( page = 1) => {
    axios.get(`/api/phonelogs?page=${page}`)
        .then(response => {
            phoneData.value = response.data;
            loading.value = false;
        }).catch(error => {
            console.error('Error fetching phone logs:', error);
        });
}
let table = new DataTable('#myTable', {
  "paging": true    
});
onMounted(() => {
    getPhoneLog();
});
</script>

<template>
    <div class="text-center justify-center">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">call date</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Call Duration</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <div class="spinner-border text-center text-info" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </tr>
                    <tr v-else v-for="(data, index) in phoneData.data" :key="index + 1">
                        <th scope="row">{{ index + 1 }}</th>
                        <th scope="row">{{ data.call_date }}</th>
                        <td>{{ data.phone_number }}</td>
                        <td>{{ data.call_duration }}</td>
                        <td class="badge badge-success"><div ></div>{{ data.status }}</td>
                    </tr>

                </tbody>
            </table>
            <Bootstrap5Pagination
      :data="phoneData"
      :show-disabled="true"
      :align="left"
      @pagination-change-page="getPhoneLog"
  />
        </div>
    </div>
</template>