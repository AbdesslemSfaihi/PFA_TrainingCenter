<template>
    <div>
      <VCard>
        <VCardTitle>Seances List</VCardTitle>
        <VCardText>
          <VDataTable
            :headers="headers"
            :items="seances"
            class="elevation-1"
          ></VDataTable>
        </VCardText>
      </VCard>
    </div>
  </template>
  
  <script setup>
  import axios from 'axios';
  import { ref, onMounted } from 'vue';
  
  const seances = ref([]);
  
  const headers = [
    { text: 'Training Course', value: 'training_courses' },
    { text: 'Session', value: 'session' },
    { text: 'Seance Name', value: 'name' },
    { text: 'Start Hour', value: 'startH' },
    { text: 'Duration', value: 'duration' },
    { text: 'Subject Name', value: 'subjectname' },
    { text: 'Trainer Name', value: 'trainername' },
  ];
  
  const fetchSeances = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/seances');
      seances.value = response.data;
    } catch (error) {
      console.error('Error fetching seances:', error);
    }
  };
  
  onMounted(fetchSeances);
  </script>
  
  