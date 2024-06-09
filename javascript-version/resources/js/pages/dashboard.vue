<template>
  <div>
    <div class="statistics-cards">
      <div class="card card1">
        <h3>Training Courses</h3>
        <p>{{ trainingCourses.length }}</p>
      </div>
      <div class="card card2">
        <h3>Subjects</h3>
        <p>{{ subjects.length }}</p>
      </div>
      <div class="card card4">
        <h3>Trainees</h3>
        <p>{{ trainees.length }}</p>
      </div>
      <div class="card card3">
        <h3>Trainers</h3>
        <p>{{ trainers.length }}</p>
      </div>
      
    </div>

    <div class="chart-container">
      <VCard class="chart-card">
        <Chart v-if="loaded" :data="barChartData" :options="barChartOptions" chartType="bar" />
      </VCard>

      <VCard class="chart-card">
        <Chart v-if="loaded" :data="pieChartData" :options="chartOptions" />
      </VCard>

      
    </div>
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
    const subjects = ref([]);
    const trainingCourses = ref([]);
    const loaded = ref(false);

    const fetchData = async () => {
      try {
        const [trainersRes, traineesRes, subjectsRes, trainingCoursesRes, sessionsRes] = await Promise.all([
          axios.get("http://localhost:8000/api/trainers"),
          axios.get("http://localhost:8000/api/trainees"),
          axios.get("http://localhost:8000/api/subjects"),
          axios.get("http://localhost:8000/api/trainingcourses"),
          axios.get("http://localhost:8000/api/sesssions")
        ]);

        trainers.value = trainersRes.data;
        trainees.value = traineesRes.data;
        subjects.value = subjectsRes.data;
        trainingCourses.value = trainingCoursesRes.data;

        updatePieChartData();
        if (Array.isArray(sessionsRes.data)) {
          updateBarChartData(sessionsRes.data);
        } else {
          console.error('Sessions data is not an array:', sessionsRes.data);
        }
        loaded.value = true;
      } catch (error) {
        console.error(error);
      }
    };

    onMounted(fetchData);

    // Pie Chart Data
    const pieChartData = ref({
      labels: ['Trainers', 'Trainees'],
      datasets: [{
        label: 'Number of People',
        data: [0, 0],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)', 
          'rgba(54, 162, 235, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)'
        ],
        borderWidth: 1
      }]
    });

    // Bar Chart Data
    const barChartData = ref({
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Number of Sessions per month',
        data: [20, 25, 30, 35, 40, 30, 20, 15, 25, 35, 45, 40 ], // Initialize with 0 for each month
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    });

    const chartOptions = ref({
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      }
    });

    const barChartOptions = ref({
      scales: {
        y: {
          beginAtZero: true, // Start y-axis from 1
          ticks: {
            stepSize: 1 // Set step size to 1
          }
        }
      },
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      }
    });

    const updatePieChartData = () => {
      pieChartData.value.datasets[0].data = [trainers.value.length, trainees.value.length];
    };

    const updateBarChartData = (sessions) => {
      const monthlySessions = {};

      sessions.forEach(session => {
        const sessionDate = new Date(session.date);
        const month = sessionDate.getMonth(); // Get month index (0-11)
        monthlySessions[month] = (monthlySessions[month] || 0) + 1;
      });

      barChartData.value.datasets[0].data = barChartData.value.labels.map((month, index) => monthlySessions[index] || 0);
    };

    return {
      trainers,
      trainees,
      subjects,
      trainingCourses,
      loaded,
      pieChartData,
      barChartData,
      chartOptions,
      barChartOptions,
    };
  }
};
</script>



<style lang="scss">
.chart-container {
  display: flex; /* Use flexbox to align items in a row */
}

.statistics-cards {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.card {
  width: calc(25% - 10px);
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.card1 {
  background-color: #43e258; /* Example color for training courses */
}

.card2 {
  background-color: #c8e65c; /* Example color for subjects */
}

.card3 {
  background-color: #ff9999; /* Example color for trainers */
}

.card4 {
  background-color: #99ccff; /* Example color for trainees */
}

.card h3 {
  margin-bottom: 5px;
  font-size: 16px;
}

.card p {
  font-size: 24px;
  font-weight: bold;
}

.chart-card {
  width: 515px; /* Set your desired width */
  height: 350px; /* Set your desired height */
  padding: 20px; /* Add some padding if needed */
 
  flex: 1; /* Each chart card takes up equal space */
  margin-right: 5px; /* Add some spacing between charts */
  margin-left: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.chart-card .chart-container {
  width: 100%;
  height: 100%;
}
</style>
