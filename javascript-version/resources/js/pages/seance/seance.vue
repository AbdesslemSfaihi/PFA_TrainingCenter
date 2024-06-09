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
          <VDataTable :headers="headers" :items="seances" :items-per-page="10" class="text-no-wrap">
            <template #item.trainingcourse_id="{ item }">
              <div>{{ getTrainingCourseName(item.trainingcourse_id) }}</div>
            </template>
            <template #item.date="{ item }">
              <div>{{ item.date }}</div>
            </template>
            <template #item.startH="{ item }">
              <div>{{ item.startH }}</div>
            </template>
            <template #item.endH="{ item }">
              <div>{{ item.endH }}</div>
            </template>
            <template #item.sess_id="{ item }">
              <div>{{ getSessionName(item.sess_id) }}</div>
            </template>
            <template #item.trainer_id="{ item }">
              <div>{{ getTrainerName(item.trainer_id) }}</div>
            </template>
            <template #item.subject_id="{ item }">
              <div>{{ getSubjectName(item.subject_id) }}</div>
            </template>
            <template #item.id="{ item }">
              <div class="d-flex gap-1">
                <IconBtn size="small" @click="viewItem(item)">
                  <VIcon icon="ri-eye-line" />
                </IconBtn>
                <IconBtn size="small" @click="editItem(item)">
                  <VIcon icon="ri-pencil-line" />
                </IconBtn>
                <IconBtn size="small" @click="deleteItem(item)">
                  <VIcon icon="ri-delete-bin-line" />
                </IconBtn>
              </div>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>
    </div>

    <VDialog v-model="viewDialog" max-width="600px">
      <VCard>
        <VCardTitle>
          <span class="headline">View Seance</span>
        </VCardTitle>
        <VContainer>
          <VRow>
            <VCol cols="12" class="mt-4">
              <VTypography variant="subtitle1" class="attribute-name">Training Course :</VTypography>
              <VTypography class="mt-1 attribute-value">{{ getTrainingCourseName(viewedItem.trainingcourse_id) }}</VTypography>
            </VCol>
            <VCol cols="12" class="mt-2">
              <VTypography variant="subtitle1" class="attribute-name">Date :</VTypography>
              <VTypography class="mt-1 attribute-value">{{ viewedItem.date }}</VTypography>
            </VCol>
            <VCol cols="12" class="mt-2">
              <VTypography variant="subtitle1" class="attribute-name">Start Hour :</VTypography>
              <VTypography class="mt-1 attribute-value">{{ viewedItem.startH }}</VTypography>
            </VCol>
            <VCol cols="12" class="mt-2">
              <VTypography variant="subtitle1" class="attribute-name">End Hour :</VTypography>
              <VTypography class="mt-1 attribute-value">{{ viewedItem.endH }}</VTypography>
            </VCol>
            <VCol cols="12" class="mt-2">
              <VTypography variant="subtitle1" class="attribute-name">Session :</VTypography>
              <VTypography class="mt-1 attribute-value">{{ getSessionName(viewedItem.sess_id) }}</VTypography>
            </VCol>
            <VCol cols="12" class="mt-2">
              <VTypography variant="subtitle1" class="attribute-name">Trainer :</VTypography>
              <VTypography class="mt-1 attribute-value">{{ getTrainerName(viewedItem.trainer_id) }}</VTypography>
            </VCol>
            <VCol cols="12" class="mt-2">
              <VTypography variant="subtitle1" class="attribute-name">Subject :</VTypography>
              <VTypography class="mt-1 attribute-value">{{ getSubjectName(viewedItem.subject_id) }}</VTypography>
            </VCol>
          </VRow>
        </VContainer>
        <VCardActions>
          <VSpacer />
          <VBtn color="primary" variant="elevated" @click="closeView">Close</VBtn>
          <VSpacer />
        </VCardActions>
      </VCard>
    </VDialog>

    <VDialog v-model="editDialog" max-width="600px">
      <VCard>
        <VCardTitle>
          <span class="headline">Edit Seance</span>
        </VCardTitle>
        <VCardText>
          <VContainer>
            <VRow>
              <VCol cols="12">
                <v-select prepend-icon="ri-artboard-line" :items="trainCourses" v-model="editedItem.trainingcourse_id" item-title="name" item-value="id" label="Training Course" placeholder="Select Training Course" />
              </VCol>
              <VCol cols="12">
                <VTextField v-model="editedItem.date" prepend-inner-icon="ri-calendar-line" label="Date" placeholder="YYYY-MM-DD" />
              </VCol>
              <VCol cols="12">
                <VTextField v-model="editedItem.startH" prepend-inner-icon="ri-time-line" label="Start Hour" placeholder="HH:MM" />
              </VCol>
              <VCol cols="12">
                <VTextField v-model="editedItem.endH" prepend-inner-icon="ri-time-line" label="End Hour" placeholder="HH:MM" />
              </VCol>
              <VCol cols="12">
                <v-select prepend-icon="ri-presentation-line" :items="sessions" v-model="editedItem.sess_id" item-title="name" item-value="id" label="Session" placeholder="Select Session" />
              </VCol>
              <VCol cols="12">
                <v-select prepend-icon="ri-user-line" :items="trainers" v-model="editedItem.trainer_id" item-title="name" item-value="id" label="Trainer" placeholder="Select Trainer" />
              </VCol>
              <VCol cols="12">
                <v-select prepend-icon="ri-book-line" :items="subjects" v-model="editedItem.subject_id" item-title="Name" item-value="id" label="Subject" placeholder="Select Subject" />
              </VCol>
            </VRow>
          </VContainer>
        </VCardText>
        <VCardActions>
          <VSpacer />
          <VBtn color="error" variant="outlined" @click="closeEdit">Cancel</VBtn>
          <VBtn color="success" variant="elevated" @click="saveEdit">Save</VBtn>
        </VCardActions>
      </VCard>
    </VDialog>

    <VDialog v-model="deleteDialog" max-width="500px">
      <VCard>
        <VCardTitle>Are you sure you want to delete this item?</VCardTitle>
        <VCardActions>
          <VSpacer />
          <VBtn color="error" variant="outlined" @click="closeDelete">Cancel</VBtn>
          <VBtn color="success" variant="elevated" @click="confirmDelete">OK</VBtn>
          <VSpacer />
        </VCardActions>
      </VCard>
    </VDialog>
  </div>
</template>

<script setup>
import axios from 'axios';
import Swal from 'sweetalert2';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const defaultItem = ref({
  trainingcourse_id: null,
  date: '',
  startH: '',
  endH: '',
  sess_id: null,
  trainer_id: null,
  subject_id: null,
});

const headers = [
  { text: 'Training Course', value: 'trainingcourse_id' },
  { text: 'Date', value: 'date' },
  { text: 'Start Hour', value: 'startH' },
  { text: 'End Hour', value: 'endH' },
  { text: 'Session', value: 'sess_id' },
  { text: 'Trainer', value: 'trainer_id' },
  { text: 'Subject', value: 'subject_id' },
  { text: 'Actions', value: 'actions' },
];

const seances = ref([]);
const trainCourses = ref([]);
const sessions = ref([]);
const subjects = ref([]);
const trainers = ref([]);

const isLoading = ref(true);

const viewDialog = ref(false);
const editDialog = ref(false);
const deleteDialog = ref(false);

const viewedItem = ref({ ...defaultItem.value });
const editedIndex = ref(-1);
const editedItem = ref({ ...defaultItem.value });

const router = useRouter();

const fetchSeances = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/seances');
    seances.value = response.data;
  } catch (error) {
    console.error('Error fetching seances:', error);
  } finally {
    isLoading.value = false;
  }
};

const fetchTrainingCourses = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/trainingcourses');
    trainCourses.value = response.data;
  } catch (error) {
    console.error('Error fetching training courses:', error);
  }
};

const fetchSessions = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/sesses');
    sessions.value = response.data;
  } catch (error) {
    console.error('Error fetching sessions:', error);
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

const fetchTrainers = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/trainers');
    trainers.value = response.data;
  } catch (error) {
    console.error('Error fetching trainers:', error);
  }
};

const getTrainingCourseName = (id) => {
  const course = trainCourses.value.find(item => item.id === id);
  return course ? course.name : 'Unknown';
};

const getSessionName = (id) => {
  const session = sessions.value.find(item => item.id === id);
  return session ? session.name : 'Unknown';
};

const getSubjectName = (id) => {
  const subject = subjects.value.find(item => item.id === id);
  return subject ? subject.Name : 'Unknown';
};

const getTrainerName = (id) => {
  const trainer = trainers.value.find(item => item.id === id);
  return trainer ? trainer.name : 'Unknown';
};

const viewItem = (item) => {
  viewedItem.value = { ...item };
  viewDialog.value = true;
};

const closeView = () => {
  viewDialog.value = false;
};

const editItem = (item) => {
  editedIndex.value = item.id;
  editedItem.value = { ...item };
  editDialog.value = true;
};

const closeEdit = () => {
  editDialog.value = false;
  editedItem.value = { ...defaultItem.value };
};

const saveEdit = async () => {
  try {
    if (editedIndex.value !== -1) {
      await axios.put(`http://localhost:8000/api/seances/${editedIndex.value}`, editedItem.value);
      Swal.fire('Success', 'Seance updated successfully', 'success');
    }
  } catch (error) {
    console.error('Error saving seance:', error);
    Swal.fire('Error', 'Error saving seance', 'error');
  } finally {
    fetchSeances();
    closeEdit();
  }
};

const deleteItem = (item) => {
  editedIndex.value = item.id;
  editedItem.value = { ...item };
  deleteDialog.value = true;
};

const closeDelete = () => {
  deleteDialog.value = false;
};

const confirmDelete = async () => {
  try {
    await axios.delete(`http://localhost:8000/api/seances/${editedIndex.value}`);
    Swal.fire('Deleted', 'Seance deleted successfully', 'success');
  } catch (error) {
    console.error('Error deleting seance:', error);
    Swal.fire('Error', 'Error deleting seance', 'error');
  } finally {
    fetchSeances();
    closeDelete();
  }
};

onMounted(() => {
  fetchSeances();
  fetchTrainingCourses();
  fetchSessions();
  fetchSubjects();
  fetchTrainers();
});
</script>

<style>
.router-link-custom {
  color: white;
}
</style>
