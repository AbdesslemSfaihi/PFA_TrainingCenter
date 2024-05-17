<template>
  <div>
    <Chart v-if="loaded" :data="chartData" :options="chartOptions" />
  </div>
</template>

<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import Chart from '../components/Chart.vue';

export default {
  name: 'ChartContainer',
  components: {
    Chart,
  },
  setup() {
    const trainers = ref([]);
    const trainees = ref([]);
    const loaded = ref(false); // Add a reactive variable to track data loading

    const getTrainers = async () => {
      try {
        const response = await axios.get("http://localhost:8000/api/trainers");
        console.log(response.data); // Log the response data
        trainers.value = response.data;
        updateChartData(); // Update chart data after fetching trainers
      } catch (error) {
        console.error(error);
        // Handle error
      }
    };

    const getTrainees = async () => {
      try {
        const response = await axios.get("http://localhost:8000/api/trainees");
        console.log(response.data); // Log the response data
        trainees.value = response.data;
        updateChartData(); // Update chart data after fetching trainees
      } catch (error) {
        console.error(error);
        // Handle error
      }
    };

    onMounted(async () => {
      await getTrainers();
      await getTrainees();
      loaded.value = true; // Set loaded to true after data is fetched
    });

    // Data for your chart (initialize with empty data)
    const chartData = ref({
      labels: ['Trainers', 'Trainees'],
      datasets: [{
        label: 'Number of People',
        data: [0, 0], // Initially set data to 0 for both trainers and trainees
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)', // Color for trainers
          'rgba(54, 162, 235, 0.2)',  // Color for trainees
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
        ],
        borderWidth: 1
      }]
    });

    // Options for your chart
    const chartOptions = ref({
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      }
    });

    // Function to update chart data
    const updateChartData = () => {
      chartData.value.datasets[0].data = [trainers.value.length, trainees.value.length];
    };

    return {
      trainers,
      trainees,
      chartData,
      chartOptions,
      loaded, // Expose loaded variable to template
    };
  }
};
</script>
