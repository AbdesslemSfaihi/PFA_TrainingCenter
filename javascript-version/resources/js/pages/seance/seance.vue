<template>
  <div>
      <div v-if="isLoading" class="text-center">
          <VProgressCircular :size="30" width="3" color="primary" indeterminate />
      </div>
      <div v-else>
          <h1>Seance</h1>
          <VCol cols="12">
              <VBtn class="me-4">
                  <router-link to="/seance/add" class="router-link-custom">
                      <IconBtn size="small">
                          <VIcon icon="ri-add-circle-fill" />
                      </IconBtn>
                      Add a new seance
                  </router-link>
              </VBtn>
          </VCol>
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
    </div>
</template>
  
  <script setup>
  import axios from 'axios';
import { onMounted, ref } from 'vue';
  
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
  <style>
  .router-link-custom {
      color: white;
      /* Set the desired text color */
  }
  </style>
  