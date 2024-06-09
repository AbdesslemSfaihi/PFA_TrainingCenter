<template>
  <canvas ref="chart"></canvas>
</template>

<script>
import Chart from 'chart.js/auto';

export default {
  name: 'Chart',
  props: {
    data: Object,
    options: Object,
    chartType: {
      type: String,
      default: 'pie' // Default chart type is set to pie
    }
  },
  mounted() {
    this.renderChart();
  },
  methods: {
    renderChart() {
      const ctx = this.$refs.chart.getContext('2d');
      new Chart(ctx, {
        type: this.chartType,
        data: this.data,
        options: this.options,
      });
    },
  },
};
</script>
