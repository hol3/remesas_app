<template>
    <Bar :data="data" :options="options" />
</template>
<script setup>
// import {Chart as ChartJS,
//     Title,
//     Tooltip,
//     Legend,
//     BarElement,
//     CategoryScale,
//     LinearScale,
//     ChartData
// } from 'chart.js';
import { Chart, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
import { Bar } from 'vue-chartjs';
import { ref } from 'vue';

Chart.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const options = {
    responsive: true,
    maintainAspectRatio: false,
}

const data = {
    labels: [
        'Enenro',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre',
    ],
    datasets: [{
        label: 'Remesas',
        backgroundColor: 'blue',
        data: [1,20,35,50,45,25,23,45,65,35,65,78,89]
    },
    {
        label: 'Entregas Dafni',
        backgroundColor: 'red',
        data: [1,20,35,40,45,43,23,20,40,35,65,78,89]
    }
    ]
}
</script>