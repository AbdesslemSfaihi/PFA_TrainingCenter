<template>
  <canvas ref="chart"></canvas>
</template>

<script>
import Chart from 'chart.js/auto';

export default {
  name: 'Chart',
  props: {
    data: Object,
    options: Object
  },
  mounted() {
    this.renderChart();
  },
  methods: {
    renderChart() {
      const ctx = this.$refs.chart.getContext('2d');
      new Chart(ctx, {
        type: 'bar', // Change this to the type of chart you want
        data: this.data,
        options: this.options,
      });
    },
  },
};
</script>
