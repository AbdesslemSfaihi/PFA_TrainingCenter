<template>
    <VForm @submit.prevent="addSeance">
      <VRow>
        <VCol cols="12">
          <VSelect
            v-model="selectedTrainingCourse"
            :items="trainingCourses"
            item-text="name"
            item-value="id"
            label="Training Course"
            prepend-inner-icon="ri-book-line"
          />
        </VCol>
        <VCol cols="12">
        <VSelect 
          :items="trainingCourses"
          v-model="seance.trainingCoursesid" 
          item-text="name" 
          item-value="id"
          label="Training Course" 
          placeholder="Select Training Course" 
        />
      </VCol>

        <VCol cols="6">
          <VTextField v-model="startDate" type="date" label="Start Date" />
        </VCol>
        <VCol cols="6">
          <VTextField v-model="endDate" type="date" label="End Date" />
        </VCol>
        <VCol cols="12">
          <VSelect
            v-model="selectedSession"
            :items="sessions"
            item-text="name"
            item-value="id"
            label="Session"
            prepend-inner-icon="ri-calendar-line"
          />
        </VCol>
        <VCol cols="12">
          <VSelect
            v-model="selectedTrainer"
            :items="trainers"
            item-text="name"
            item-value="id"
            label="Trainer"
            prepend-inner-icon="ri-user-line"
          />
        </VCol>
    

        <VCol cols="12">
          <VSelect
            v-model="selectedSubject"
            :items="subjects"
            item-text="name"
            item-value="id"
            label="Subject"
            prepend-inner-icon="ri-bookmark-line"
          />
        </VCol>
        <VCol cols="12">
          <VBtn @click="addSeance" class="me-4">
            Add Seance
          </VBtn>
        </VCol>
      </VRow>
    </VForm>
  </template>
  
  <script setup>
  import axios from 'axios';
  import { ref, onMounted } from 'vue';
  
  const selectedTrainingCourse = ref(null);
  const startDate = ref('');
  const endDate = ref('');
  const selectedSession = ref(null);
  const selectedTrainer = ref(null);
  const selectedSubject = ref(null);
  const trainingCourses = ref([]);
  const sessions = ref([]);
  const trainers = ref([]);
  const subjects = ref([]);
  
  // Fetch the list of training courses, sessions, trainers, and subjects when the component is mounted
  onMounted(async () => {
    await fetchTrainingCourses();
    await fetchSessions();
    await fetchTrainers();
    await fetchSubjects();
  });
  
  const fetchTrainingCourses = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/trainingcourses');
      trainingCourses.value = response.data;
    } catch (error) {
      console.error('Error fetching training courses:', error);
    }
  };
  
  const fetchSessions = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/sesses');
      sessions.value = response.data.map(sessions => ({
        id: sessions.id,
        name: sessions.name // Assuming your session object has a 'name' property
      }));
    } catch (error) {
      console.error('Error fetching sessions:', error);
    }
  };
  
  const fetchTrainers = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/trainers');
      trainers.value = response.data;
    } catch (error) {
      console.error('Error fetching trainers:', error);
    }
  };
  
  const fetchSubjects = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/subjects');
      subjects.value = response.data;
    } catch (error) {
      console.error('Error fetching subjects:', error);
    }
  };
  
  // Function to add a new seance to the database
  const addSeance = async () => {
    // Your code to add a seance
  };
  </script>
