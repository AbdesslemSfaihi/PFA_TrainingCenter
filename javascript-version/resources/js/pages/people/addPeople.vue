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
          <file-pond
            name="file"
            ref="pond"
            class-name="my-pond"
            label-idle="Drop files here..."
            accepted-file-types="image/jpeg, image/png"
            v-bind:files="myFiles"
            v-on:init="handleFilePondInit"
            :server="serverOptions()"
          />
        </VCol>
        <VCol cols="6">
          <VTextField v-model="birthdate" type="date" label="Birthdate" prepend-inner-icon="ri-calendar-line" />
        </VCol>
        
        
        <VCol cols="12" class="d-flex justify-content-end">
          <VBtn type="submit" class="me-4">
            Add
          </VBtn>
          <VBtn @click="cancel" class="me-4">Cancel</VBtn>
        </VCol>
      </VRow>
    </VForm>
  </VCard>
</template>

<script setup>
import axios from 'axios';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import 'filepond/dist/filepond.min.css';
import Swal from 'sweetalert2';
import { ref } from 'vue';
import vueFilePond from 'vue-filepond';
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
const myFiles = ref([]);

const FilePond = vueFilePond(FilePondPluginImagePreview);

const handleFilePondInit = () => {
  console.log('FilePond has initialized');
};

const serverOptions = () => {
  return {
    process: (fieldName, file, metadata, load, error, progress, abort) => {
      const data = new FormData();
      data.append('file', file);
      data.append('upload_preset', 'Ecommerce-Cloudinary'); 
      data.append('cloud_name', 'djgakeuop');

      axios.post('https://api.cloudinary.com/v1_1/dc5wcwmzq/upload', data)
        .then(response => {
          const { secure_url } = response.data;
          imgUrl.value = secure_url;
          load(response.data);
        })
        .catch(err => {
          console.error('Error uploading file:', err);
          error('Upload failed');
          abort();
        });
    },
  };
};

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
      Swal.fire({
        title: "Good job!",
        text: "A new person was added successfully!",
        icon: "success"
      });
      router.push('/people');
    } else {
      console.error('Error adding person:', response.statusText);
    }
  } catch (error) {
    console.error('Error adding person:', error);
  }
};

const addItem = async () => {
  if (!radioGroup.value || !name.value || !birthdate.value || !email.value || !password.value || !phone.value) {
    Swal.fire({
      title: "Error!",
      text: "Please fill all the required fields",
      icon: "error"
    });
    return;
  }

  const formData = {
    name: name.value,
    birthdate: birthdate.value,
    email: email.value,
    password: password.value,
    phone: phone.value,
    image: imgUrl.value,
  };

  await addPerson(formData, radioGroup.value);
};

const cancel = () => {
  router.push('/people');
};
</script>

<style lang="scss">
.custom-card {
  padding: 20px;
}
</style>


<style lang="scss">
.custom-card {
  padding: 20px;
}
</style>
