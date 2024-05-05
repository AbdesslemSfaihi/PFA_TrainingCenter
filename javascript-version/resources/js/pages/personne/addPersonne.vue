<template>
    <VForm @submit.prevent>
      <VRow>
        <VCol cols="12">
          <div class="">
            <VRadioGroup v-model="radioGroup">
              <VRadio :label="'Trainer'" value="trainer" />
              <VRadio :label="'Trainee'" value="trainee" />
            </VRadioGroup>
          </div>
        </VCol>
        <VCol cols="4">
          <VTextField v-model="name" prepend-inner-icon="ri-user-line" label="Name" />
        </VCol>
        <VCol cols="4">
          <VTextField v-model="birthdate" prepend-inner-icon="ri-user-line" label="Birthdate" />
        </VCol>
        <VCol cols="4">
          <VTextField v-model="email" prepend-inner-icon="ri-user-line" label="Email" />
        </VCol>
        <VCol cols="4">
          <VTextField v-model="password" prepend-inner-icon="ri-user-line" label="Password" />
        </VCol>
        <VCol cols="4">
          <VTextField v-model="phone" prepend-inner-icon="ri-mail-line" label="Phone" />
        </VCol>
        <VCol cols="4">
          <VTextField v-model="image" prepend-inner-icon="ri-image-line" label="Image" />
        </VCol>
        <VCol cols="4">
          <VBtn @click="addItem" class="me-4">
            Add
          </VBtn>
        </VCol>
      </VRow>
    </VForm>
  </template>
  
  <script setup>
  import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter(); 
  const radioGroup = ref('');
  const name = ref('');
  const birthdate = ref('');
  const email = ref('');
  const password = ref('');
  const phone = ref('');
  const image = ref('');
  
  // Function to add a new person to the database
  const addPerson = async (personData, personType) => {
    let endpoint = '';
  
    if (personType === 'trainer') {
      endpoint = 'http://localhost:8000/api/trainers';
    } else if (personType === 'trainee') {
      endpoint = 'http://localhost:8000/api/trainees';
    } else {
      console.error('Invalid person type:', personType);
      return;
    }
  
    try {
      const response = await axios.post(endpoint, personData);
  
      if (response.status === 200 || response.status === 201) {
        console.log('Person added successfully:', response.data);
        router.push('/personnes');
      } else {
        console.error('Error adding person:', response.statusText);
      }
    } catch (error) {
      console.error('Error adding person:', error);
    }
  };
  
  const addItem = async () => {
    const newItem = {
      name: name.value,
      birthdate: birthdate.value,
      email: email.value,
      password: password.value,
      phone: phone.value,
      image: image.value,
    };
  
    await addPerson(newItem, radioGroup.value);
  };
  </script>
  