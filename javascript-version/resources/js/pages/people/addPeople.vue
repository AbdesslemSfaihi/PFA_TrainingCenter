<template>
  <VCard class="custom-card">
    <VForm @submit.prevent="addItem">
      <VRow>
        <VCol cols="12">
          <div>
            Select Type:
            <br /><br />
            <VRadioGroup v-model="radioGroup" inline>
              <VRadio :label="'Trainer'" value="trainer" />
              <VRadio :label="'Trainee'" value="trainee" />
            </VRadioGroup>
          </div>
        </VCol>
        <VCol cols="6">
          <VTextField v-model="name" prepend-inner-icon="ri-user-line" label="Name" />
        </VCol>
        <VCol cols="6">
          <VTextField v-model="email" prepend-inner-icon="ri-mail-line" label="Email" />
        </VCol>
        <VCol cols="6">
          <VTextField v-model="password" prepend-inner-icon="ri-lock-line" label="Password" />
        </VCol>
        <VCol cols="6">
          <VTextField v-model="phone" prepend-inner-icon="ri-phone-line" label="Phone" />
        </VCol>
        <VCol cols="6">
          <v-file-input
            v-model="image"
            @change="renderImg"
            chips
            prepend-inner-icon="ri-image-line"
            accept="image/*"
            label="Upload Image"
          ></v-file-input>
        </VCol>
        <VCol cols="6">
          <img :src="imgUrl" alt="Uploaded Image" v-if="imgUrl" style="max-width: 100px; max-height: 100px;" />
        </VCol>
        <VCol cols="6">
          <VTextField v-model="birthdate" type="date" label="Birthdate" prepend-inner-icon="ri-calendar-line" />
        </VCol>
        <VCol cols="12" class="d-flex justify-content-end">
          <VBtn type="submit" class="me-4">
            Add
          </VBtn>
        </VCol>
      </VRow>
    </VForm>
  </VCard>
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
const image = ref(null);
const imgUrl = ref('');

const renderImg = () => {
  if (!image.value || !(image.value instanceof File)) {
    imgUrl.value = '';
    return;
  }
  const file = image.value;
  const reader = new FileReader();
  reader.readAsDataURL(file);
  reader.addEventListener('load', () => {
    imgUrl.value = reader.result;
  });
};

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
      router.push('/people');
    } else {
      console.error('Error adding person:', response.statusText);
    }
  } catch (error) {
    console.error('Error adding person:', error);
  }
};

const addItem = async () => {
  const formData = new FormData();
  formData.append('name', name.value);
  formData.append('birthdate', birthdate.value);
  formData.append('email', email.value);
  formData.append('password', password.value);
  formData.append('phone', phone.value);
  if (image.value) {
    formData.append('image', image.value);
  }

  await addPerson(formData, radioGroup.value);
};

</script>

<style lang="scss">
.custom-card {
  padding: 20px;
}
</style>
