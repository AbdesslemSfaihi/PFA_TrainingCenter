<template>
  <div v-if="isLoading" class="center-container">
    <VProgressCircular :size="30" width="3" color="primary" indeterminate />
  </div>
  <div v-else>
    <div style="display: flex; align-items: center;">
      <router-link to="/seance">
        <IconBtn size="medium" style="margin-right: 8px;" class="red-icon">
          <VIcon icon="ri-arrow-left-circle-line" />
        </IconBtn>
      </router-link>
      <h1>Add a new Seance</h1>
    </div>
    <br />
    <VCard>
      <VCardText>
        <VForm @submit.prevent="addSeance">
          <VRow>
            <!-- Training course -->
            <VCol cols="12">
              <v-select
                prepend-icon="ri-artboard-line"
                :items="trainingCourses"
                v-model="seance.trainingcourse_id"
                item-title="name"
                item-value="id"
                label="Training Course"
                placeholder="Select Training Course"
              />
            </VCol>

            <!-- Session -->
            <VCol cols="12">
              <v-select
                prepend-icon="ri-calendar-line"
                :items="sessions"
                v-model="seance.sess_id"
                item-title="name"
                item-value="id"
                label="Session"
                placeholder="Select Session"
              />
            </VCol>

            <!-- Module -->
            <VCol cols="12">
              <v-select
                prepend-icon="ri-calendar-line"
                :items="modules"
                v-model="selectedModule"
                item-title="name"
                item-value="id"
                label="Module"
                placeholder="Select Module"
              />
            </VCol>

            <!-- Subject -->
            <VCol cols="12">
              <v-select
                prepend-icon="ri-bookmark-line"
                :items="subjects"
                v-model="seance.subject_id"
                item-title="Name"
                item-value="id"
                label="Subject"
                placeholder="Select Subject"
              />
            </VCol>

            <!-- Trainer -->
            <VCol cols="12">
              <v-select
                prepend-icon="ri-user-line"
                :items="trainers"
                v-model="seance.trainer_id"
                item-title="name"
                item-value="id"
                label="Trainer"
                placeholder="Select Trainer"
              />
            </VCol>

            <!-- Date, Start Hour, End Hour -->
            <VCol cols="4">
              <VTextField v-model="seance.date" type="date" label="Date" />
            </VCol>
            <VCol cols="4">
              <VTextField v-model="seance.startH" type="time" label="Start Hour" />
            </VCol>
            <VCol cols="4">
              <VTextField v-model="seance.endH" type="time" label="End Hour" />
            </VCol>

            <VCol cols="12">
              <VBtn type="submit" class="me-4">Add Seance</VBtn>
              <VBtn color="secondary">
                <router-link to="/seance" class="router-link-cancel">Cancel</router-link>
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </div>
</template>

<script setup>
import axios from 'axios';
import Swal from 'sweetalert2';
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const isLoading = ref(true);
const seance = ref({
  trainingcourse_id: null,
  date: '',
  startH: '',
  endH: '',
  sess_id: null,
  trainer_id: null,
  subject_id: null,
});
const selectedModule = ref(null);
const trainingCourses = ref([]);
const sessions = ref([]);
const trainers = ref([]);
const subjects = ref([]);
const modules = ref([]);
const router = useRouter();

// Fetch data functions
const getTrainingCourses = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/trainingcourses');
    trainingCourses.value = response.data;
  } catch (error) {
    console.error('Error fetching training courses:', error);
  }
};

const getSessions = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/sesses');
    sessions.value = response.data.map(session => ({
      id: session.id,
      name: session.name,
    }));
  } catch (error) {
    console.error('Error fetching sessions:', error);
  }
};


const getModules = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/modules');
    modules.value = response.data.map(module => ({
      id: module.id,
      name: module.name,
    }));
  } catch (error) {
    console.error('Error fetching modules:', error);
  }
};

const getTrainers = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/trainers');
    trainers.value = response.data.map(trainer => ({
      id: trainer.id,
      name: trainer.name,
    }));
  } catch (error) {
    console.error('Error fetching trainers:', error);
  }
};

const getSubjects = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/subjects');
    subjects.value = response.data.map(subject => ({
      id: subject.id,
      Name: subject.Name,
 // Assuming each subject has a module_id
    }));
  } catch (error) {
    console.error('Error fetching subjects:', error);
  }
};

// Computed property to filter subjects based on selected module
const filteredSubjects = computed(() => {
  if (!selectedModule.value) {
    return [];
  }
  return subjects.value.filter(subject => subject.module_id === selectedModule.value);
});

// Add seance function
const addSeance = async () => {
  if (!seance.value.trainingcourse_id || !seance.value.date || !seance.value.startH || !seance.value.endH || !seance.value.sess_id || !seance.value.trainer_id || !seance.value.subject_id) {
    Swal.fire({
      title: 'Error!',
      text: 'Please fill all the required fields',
      icon: 'error'
    });
    return;
  }
  try {
    await axios.post('http://localhost:8000/api/seances', seance.value);
    Swal.fire({
      title: 'Good job!',
      text: 'A new seance was added successfully!',
      icon: 'success'
    });
    router.push('/seance');
  } catch (error) {
    console.error('Error adding seance:', error.response || error.message);
    Swal.fire({
      title: 'Error!',
      text: error.response ? error.response.data.message : 'An error occurred while adding the seance.',
      icon: 'error'
    });
  }
};

onMounted(async () => {
  await getTrainingCourses();
  await getSessions();
  await getTrainers();
  await getSubjects();
  await getModules();
  isLoading.value = false;
});
</script>

<style>
.center-container {
  display: flex;
  justify-content: center;
  align-items: center;
}

.router-link-cancel {
  color: white;
}

.red-icon {
  color: red;
}
</style>
