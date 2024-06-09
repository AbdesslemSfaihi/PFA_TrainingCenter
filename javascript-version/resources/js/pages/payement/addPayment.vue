<template>
    <div style="display: flex; align-items: center;">
      <router-link to="/dashboard">
        <IconBtn size="medium" style="margin-right: 8px;" class="red-icon">
          <VIcon icon="ri-arrow-left-circle-line" />
        </IconBtn>
      </router-link>
      <h1>Add Payment</h1>
    </div>
    <VCard>
      <VCardText>
        <VContainer>
          <VRow>
            <VCol cols="12">
              <v-select
                v-model="payment.trainingcourse_id"
                :items="trainingCourses"
                item-title="name"
                item-value="id"
                label="Training Course"
                placeholder="Select Training Course"
              />
            </VCol>
            <VCol cols="12">
              <v-select
                v-model="payment.sess_id"
                :items="sessions"
                item-title="name"
                item-value="id"
                label="Session"
                placeholder="Select Session"
              />
            </VCol>
            <VCol cols="12">
              <v-select
                v-model="payment.trainee_id"
                :items="trainees"
                item-title="name"
                item-value="id"
                label="Trainee"
                placeholder="Select Trainee"
              />
            </VCol>
            <VCol cols="12">
              <VTextField
                v-model="payment.paymentDate"
                label="Payment Date"
                prepend-inner-icon="ri-calendar-line"
                type="date"
              />
            </VCol>
            <VCol cols="12">
              <VTextField
                v-model="payment.paidAmount"
                label="Paid Amount"
                prepend-inner-icon="ri-money-dollar-box-line"
                type="number"
              />
            </VCol>
            <VCol cols="12">
              <v-select
                v-model="payment.paymentStatus"
                :items="paymentStatuses"
                item-title="name"
                item-value="id"
                label="Payment Status"
                placeholder="Select Payment Status"
              />
            </VCol>
          </VRow>
        </VContainer>
      </VCardText>
      <VCardActions>
        <VSpacer />
        <VBtn color="error" variant="outlined" @click="resetForm">Cancel</VBtn>
        <VBtn color="success" variant="elevated" @click="submitPayment">Submit</VBtn>
        <VSpacer />
      </VCardActions>
    </VCard>
  </template>
  
  <script setup>
import axios from 'axios';
import Swal from 'sweetalert2';
import { onMounted, ref } from 'vue';

const payment = ref({
  trainingcourse_id: null,
  sess_id: null,
  trainee_id: null,
  paymentDate: '',
  paidAmount: null,
  paymentStatus: null,
});

const trainingCourses = ref([]);
const sessions = ref([]);
const trainees = ref([]);
const paymentStatuses = ref([
  { id: 1, name: 'Pending' },
  { id: 2, name: 'Completed' },
]);

const getTrainingCourses = async () => {
  try {
    const response = await axios.get('/api/trainingcourses');
    trainingCourses.value = response.data;
  } catch (error) {
    handleError(error, 'Failed to fetch training courses');
  }
};

const getSessions = async () => {
  try {
    const response = await axios.get('/api/sesses');
    sessions.value = response.data;
  } catch (error) {
    handleError(error, 'Failed to fetch sessions');
  }
};

const getTrainees = async () => {
  try {
    const response = await axios.get('/api/trainees');
    trainees.value = response.data;
  } catch (error) {
    handleError(error, 'Failed to fetch trainees');
  }
};

const submitPayment = async () => {
  try {
    await axios.post('/api/payments', payment.value);
    Swal.fire('Success', 'Payment submitted successfully', 'success');
    resetForm();
  } catch (error) {
    handleError(error, 'Failed to submit payment');
  }
};

const resetForm = () => {
  payment.value = {
    trainingcourse_id: null,
    sess_id: null,
    trainee_id: null,
    paymentDate: '',
    paidAmount: null,
    paymentStatus: null,
  };
};

const handleError = (error, message) => {
  Swal.fire('Error', message, 'error');
  console.error(message + ':', error);
};

onMounted(() => {
  getTrainingCourses();
  getSessions();
  getTrainees();
});
</script>

  
  <style scoped>
  .router-link-cancel {
    color: white;
  }
  
  .red-icon {
    color: red;
  }
  </style>
  