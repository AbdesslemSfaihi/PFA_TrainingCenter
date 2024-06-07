<template>
  <div v-if="isLoading" class="center-container">
    <VProgressCircular :size="30" width="3" color="primary" indeterminate />
  </div>
  <div v-else>
    <div style="display: flex; align-items: center;">
      <router-link to="/subjectmodule">
        <IconBtn size="medium" style="margin-right: 8px;" class="red-icon">
          <VIcon icon="ri-arrow-left-circle-line" />
        </IconBtn>
      </router-link>
      <h1>Add a new Module</h1>
    </div>

    <br />
    <VCard>
      <VCardText>
        <VForm @submit.prevent="addSubjectmodule">
          <VRow>
            <VCol cols="12">
              <VSelect 
                prepend-icon="ri-artboard-line" 
                :items="subjects" 
                v-model="subjectModule.subject_id" 
                item-title="Name" 
                item-value="id" 
                label="Subject" 
                placeholder="Select Subject" 
              />
            </VCol>

            <VCol cols="12">
              <VSelect 
                prepend-icon="ri-artboard-line" 
                :items="modules" 
                v-model="subjectModule.module_id" 
                item-title="name" 
                item-value="id" 
                label="Module" 
                placeholder="Select Module" 
              />
            </VCol>

            <VCol cols="12">
              <VTextField 
                v-model="subjectModule.nbHours" 
                prepend-inner-icon="ri-presentation-line" 
                label="Nb hours" 
                placeholder="Nb hours" 
              />
            </VCol>

            <VCol cols="12">
              <VBtn type="submit" class="me-4">Add new</VBtn>
              <VBtn color="secondary">
                <router-link to="/subjectmodule" class="router-link-cancel">
                  Cancel
                </router-link>
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
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const isLoading = ref(true);
const subjectModule = ref({
  nbHours: "",
  subject_id: "",
  module_id: ""
});
const subjects = ref([]);
const modules = ref([]);
const router = useRouter();

const getSubjects = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/subjects');
    subjects.value = response.data;
  } catch (error) {
    console.error('Error fetching subjects:', error);
  }
};

const getModules = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/modules');
    modules.value = response.data;
  } catch (error) {
    console.error('Error fetching modules:', error);
  }
};

const addSubjectmodule = async () => {
  if (!subjectModule.value.nbHours || !subjectModule.value.subject_id || !subjectModule.value.module_id) {
    Swal.fire({
      title: "Error!",
      text: "Please fill all the required fields",
      icon: "error"
    });
    return;
  }

  try {
    await axios.post("http://localhost:8000/api/subjectmodule", subjectModule.value);
    Swal.fire({
      title: "Good job!",
      text: "A new module was added successfully!",
      icon: "success"
    });
    router.push('/subjectmodule');
  } catch (error) {
    console.error('Error adding subject module:', error);
  }
};

onMounted(async () => {
  await Promise.all([getSubjects(), getModules()]);
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
