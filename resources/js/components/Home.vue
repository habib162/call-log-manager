<!-- <canvas id="acquisitions" width="640" height="480"></canvas> -->
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Chart from 'chart.js/auto';


const phoneData = ref({});
const phoneCount = ref({});
const loading = ref(true);
const statusFilter = ref(null);
const startDateFilter = ref(null);
const endDateFilter = ref(null);

const data = {
    labels: [],
    datasets: [
        {
            label: 'total phone number',
            data: []
        }
    ]
}
const config = {
    type: 'bar',
    data: data,
    options: {}
}

const updateChart = () => {
    const existingChart = Chart.getChart('callChart');

    if (existingChart) {
        existingChart.destroy();
    }
    const myChart = new Chart(
        document.getElementById('callChart'),
        config
    );
};

onMounted(async () => {
    try {
        await getPhoneLog();
        updateChart();
    } catch (error) {
        console.error('Error in onMounted:', error);
    }
});

const getPhoneLog = async (page = 1) => {
    try {
        const response = await axios.get(`/api/phonelogs?page=${page}`,
            {
                params: {
                    status: statusFilter.value,
                    start_date: startDateFilter.value,
                    end_date: endDateFilter.value,
                },
            }
        );
        phoneData.value = response.data.phoneLogs;
        phoneCount.value = response.data.phoneCount;
        loading.value = false;
        data.labels = phoneCount.value.data.map((item) => item.date);
        data.datasets[0].data = phoneCount.value.data.map((item) => item.phone_count);
        updateChart();
    } catch (error) {
        console.error('Error fetching phone logs:', error);
    }
};

</script>

<template>
    <div class="text-center justify-center">
        <div class="row">
            <div class="col-md-3">
                <label for="startDate">Select Status</label>
                <select class="form-select" width="30%" v-model="statusFilter" @change="getPhoneLog">
                    <option value="" selected>Select Status</option>
                    <option value="Incoming">Incoming</option>
                    <option value="Outgoing">Outgoing</option>
                    <option value="Missed">Missed</option>
                </select>
            </div><br>
            <div class="col-md-3">
                <label for="startDate">Start Date:</label>
                <input v-model="startDateFilter" class="form-control" type="date" id="startDate">
            </div>
            <div class="col-md-3">
                <label for="endDate">End Date:</label>
                <input v-model="endDateFilter" type="date" class="form-control" id="endDate">
            </div>
            <div class="col-md-3">
                <button @click="getPhoneLog" class="btn btn-info mt-4 float-right">Filter</button>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-4">
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
                            <td class="badge badge-success">
                                {{ data.status }}
                            </td>
                        </tr>

                    </tbody>
                </table>
                <Bootstrap5Pagination :data="phoneData" :show-disabled="true" @pagination-change-page="getPhoneLog" />
            </div>

            <div class="col-md-8">
                <canvas id="callChart"></canvas>
            </div>
        </div>
    </div>
</template>