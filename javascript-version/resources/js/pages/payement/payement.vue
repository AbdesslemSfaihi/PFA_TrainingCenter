<template>
    <div>
      <div v-if="isLoading" class="text-center">
        <VProgressCircular :size="30" width="3" color="primary" indeterminate />
      </div>
      <div v-else>
        <h1>Payments</h1>
        <VCol cols="12">
          <VBtn class="me-4">
            <router-link to="/payements/add" class="router-link-custom">
              <IconBtn size="small">
                <VIcon icon="ri-add-circle-fill" />
              </IconBtn>
              Add a new payment
            </router-link>
          </VBtn>
        </VCol>
        <VCard>
          <VDataTable :headers="headers" :items="payments" :items-per-page="10" class="text-no-wrap">
            <template #item.trainingcourse_id="{ item }">
              <div>{{ getTrainingCourseName(item.trainingcourse_id) }}</div>
            </template>
            <template #item.session_id="{ item }">
              <div>{{ getSessionName(item.session_id) }}</div>
            </template>
            <template #item.trainee_id="{ item }">
              <div>{{ getTraineeName(item.trainee_id) }}</div>
            </template>
            <template #item.paymentDate="{ item }">
              <div>{{ item.paymentDate }}</div>
            </template>
            <template #item.paidAmount="{ item }">
              <div>{{ item.paidAmount }}</div>
            </template>
            <template #item.paymentStatus="{ item }">
              <div>{{ getPaymentStatus(item.paymentStatus) }}</div>
            </template>
            <template #item.id="{ item }">
              <div class="d-flex gap-1">
                <IconBtn size="small" @click="editItem(item)">
                  <VIcon icon="ri-pencil-line" />
                </IconBtn>
                <IconBtn size="small" @click="deleteItem(item)">
                  <VIcon icon="ri-delete-bin-line" />
                </IconBtn>
              </div>
            </template>
          </VDataTable>
        </VCard>
      </div>
      <!-- Edit Dialog -->
      <VDialog v-model="editDialog" max-width="600px">
        <VCard>
          <VCardTitle>
            <span class="headline">Edit Payment</span>
          </VCardTitle>
          <VCardText>
            <VContainer>
              <VRow>
                <VCol cols="12">
                  <v-select prepend-icon="ri-artboard-line" :items="trainingCourses" v-model="editedItem.trainingcourse_id" item-title="name" item-value="id" label="Training Course" placeholder="Select Training Course" />
                </VCol>
                <VCol cols="12">
                  <VTextField v-model="editedItem.session_id" prepend-inner-icon="ri-presentation-line" label="Session ID" placeholder="Session" />
                </VCol>
                <VCol cols="12">
                  <VTextField v-model="editedItem.trainee_id" prepend-inner-icon="ri-user-line" label="Trainee ID" placeholder="Trainee" />
                </VCol>
                <VCol cols="12">
                  <VTextField v-model="editedItem.paymentDate" prepend-inner-icon="ri-calendar-line" type="date" label="Payment Date" />
                </VCol>
                <VCol cols="12">
                  <VTextField v-model="editedItem.paidAmount" prepend-inner-icon="ri-money-dollar-box-line" type="number" label="Paid Amount" />
                </VCol>
                <VCol cols="12">
                  <v-select prepend-icon="ri-book-2-line" :items="paymentStatuses" v-model="editedItem.paymentStatus" item-title="name" item-value="id" label="Payment Status" placeholder="Select Payment Status" />
                </VCol>
              </VRow>
            </VContainer>
          </VCardText>
          <VCardActions>
            <VSpacer />
            <VBtn color="error" variant="outlined" @click="close">
              Cancel
            </VBtn>
            <VBtn color="success" variant="elevated" @click="edit">
              Save
            </VBtn>
          </VCardActions>
        </VCard>
      </VDialog>
      <!-- Delete Dialog -->
      <VDialog v-model="deleteDialog" max-width="500px">
        <VCard>
          <VCardTitle>
            Are you sure you want to delete this item?
          </VCardTitle>
          <VCardActions>
            <VSpacer />
            <VBtn color="error" variant="outlined" @click="close">
              Cancel
            </VBtn>
            <VBtn color="success" variant="elevated" @click="deleteItemConfirm">
              OK
            </VBtn>
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
import { useRoute, useRouter } from 'vue-router';
  
  const defaultItem = ref({
    trainingcourse_id: null,
    session_id: null,
    trainee_id: null,
    paymentDate: '',
    paidAmount: null,
    paymentStatus: null,
  });
  
  const headers = [
    { title: 'Training Course', key: 'trainingcourse_id' },
    { title: 'Session', key: 'session_id' },
    { title: 'Trainee', key: 'trainee_id' },
    { title: 'Payment Date', key: 'paymentDate' },
    { title: 'Paid Amount', key: 'paidAmount' },
    { title: 'Payment Status', key: 'paymentStatus' },
    { title: 'Actions', key: 'id' },
  ];
  
  const isLoading = ref(true);
  const router = useRouter();
  const route = useRoute();
  const editedItem = ref(defaultItem.value);
  const editedIndex = ref(-1);
  const editDialog = ref(false);
  const deleteDialog = ref(false);
  
  const payments = ref([]);
  const trainingCourses = ref([]);
  const sessions = ref([]);
  const trainees = ref([]);
  const paymentStatuses = ref([
    { id: 1, name: 'Pending' },
    { id: 2, name: 'Completed' },
  ]);
  
  const getPayments = async () => {
    try {
      const response = await axios.get('/api/payments');
      payments.value = response.data;
    } catch (error) {
      console.error('Error fetching payments:', error);
      Swal.fire('Error', 'Failed to fetch payments', 'error');
    } finally {
      isLoading.value = false;
    }
  };
  
  const getTrainingCourses = async () => {
    try {
      const response = await axios.get('/api/trainingcourses');
      trainingCourses.value = response.data;
    } catch (error) {
      console.error('Error fetching training courses:', error);
    }
  };
  
  const getSessions = async () => {
    try {
      const response = await axios.get('/api/sessions');
      sessions.value = response.data;
    } catch (error) {
      console.error('Error fetching sessions:', error);
    }
  };
  
  const getTrainees = async () => {
    try {
      const response = await axios.get('/api/trainees');
      trainees.value = response.data;
    } catch (error) {
      console.error('Error fetching trainees:', error);
    }
  };
  
  const getPaymentStatus = (paymentStatusId) => {
    const status = paymentStatuses.value.find(status => status.id === paymentStatusId);
    return status ? status.name : '';
  };
  
  const getSessionName = (sessionId) => {
    const session = sessions.value.find(session => session.id === sessionId);
    return session ? session.name : '';
  };
  
  const getTraineeName = (traineeId) => {
    const trainee = trainees.value.find(trainee => trainee.id === traineeId);
    return trainee ? trainee.name : '';
  };
  
  // Edit methods
  const editItem = item => {
    editedIndex.value = item.id;
    editedItem.value = { ...item };
    editDialog.value = true;
  };
  
  const close = () => {
    editDialog.value = false;
    deleteDialog.value = false;
    editedIndex.value = -1;
    editedItem.value = { ...defaultItem.value };
  };
  
  const edit = async () => {
    try {
      await axios.put(`/api/payments/${editedIndex.value}`, editedItem.value);
      editDialog.value = false;
      getPayments();
      Swal.fire('Success', 'Payment updated successfully', 'success');
    } catch (error) {
      console.error('Error updating payment:', error);
      Swal.fire('Error', 'Failed to update payment', 'error');
    }
  };
  
  const deleteItem = item => {
    editedIndex.value = item.id;
    editedItem.value = { ...item };
    deleteDialog.value = true;
  };
  
  const deleteItemConfirm = async () => {
    try {
      await axios.delete(`/api/payments/${editedIndex.value}`);
      deleteDialog.value = false;
      getPayments();
      Swal.fire('Success', 'Payment deleted successfully', 'success');
    } catch (error) {
      console.error('Error deleting payment:', error);
      Swal.fire('Error', 'Failed to delete payment', 'error');
    }
  };
  
  onMounted(() => {
    getPayments();
    getTrainingCourses();
    getSessions();
    getTrainees();
  });
  </script>
  
  <style>
  .router-link-custom {
    color: white;
  }
  </style>
  