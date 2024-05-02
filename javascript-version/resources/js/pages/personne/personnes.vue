<template>
    <div>
      <!-- 👉 VTabs -->
      <VTabs v-model="currentTab">
        <VTab>Trainer</VTab>
        <VTab>Trainee</VTab>
      </VTabs>
  
      <div class="icon-wrapper">
      <VBtn
      variant="text"
      icon="ri-user-add-line"
      color="secondary"
      class="bigger-icon"
    />
  </div>


      <!-- 👉 Datatable -->
      <VDataTable
        :headers="headers"
        :items="currentTab === 0 ? trainers : trainees"
        :items-per-page="5"
        class="text-no-wrap"
      >

      
        <!-- Name -->
        <template #item.name="{ item }">
          <span>{{ item.name }}</span>
        </template>
  
        <!-- Birthdate -->
        <template #item.birthdate="{ item }">
          <span>{{ item.birthdate }}</span>
        </template>
  
        <!-- Email -->
        <template #item.email="{ item }">
          <span>{{ item.email }}</span>
        </template>
  
        <!-- Password -->
        <template #item.password="{ item }">
          <span>{{ item.password }}</span>
        </template>
  
        <!-- Phone -->
        <template #item.phone="{ item }">
          <span>{{ item.phone }}</span>
        </template>
  
        <!-- Image -->
        <template #item.image="{ item }">
          <img :src="item.image" width="50" height="50" />
        </template>
  
        <!--Actions-->
        <template #item.actions="{ item }">
      <div class="d-flex gap-1">
        <IconBtn
          size="small"
          @click="editItem(item)"
        >
          <VIcon icon="ri-pencil-line" />
        </IconBtn>
        <IconBtn
          size="small"
          @click="deleteItem(item)"
        >
          <VIcon icon="ri-delete-bin-line" />
        </IconBtn>
      </div>
    </template>
  </VDataTable>

  <!-- 👉 Edit Dialog  -->
  <VDialog
    v-model="editDialog"
    max-width="600px"
  >
    <VCard>
      <VCardTitle>
        <span class="headline">Edit Item</span>
      </VCardTitle>

      <VCardText>
        <VContainer>
          <VRow>
            <!-- fullName -->
            <VCol
              cols="12"
              sm="6"
              md="4"
            >
              <VTextField
                v-model="editedItem.name"
                label="User name"
              />
            </VCol>

            <!-- email -->
            <VCol
              cols="12"
              sm="6"
              md="4"
            >
              <VTextField
                v-model="editedItem.birthdate"
                label="Birthdate"
              />
            </VCol>

            <!-- salary -->
            <VCol
              cols="12"
              sm="6"
              md="4"
            >
              <VTextField
                v-model="editedItem.email"
                label="Email"
              />
            </VCol>

            <!-- age -->
            <VCol
              cols="12"
              sm="6"
              md="4"
            >
              <VTextField
                v-model="editedItem.password"
                label="Password"
              />
            </VCol>

            <!-- start date -->
            <VCol
              cols="12"
              sm="6"
              md="4"
            >
              <VTextField
                v-model="editedItem.phone"
                label="Phone"
                type="number"
              />
            </VCol>

            <!-- age -->
            <VCol
              cols="12"
              sm="6"
              md="4"
            >
              <VTextField
                v-model="editedItem.image"
                label="Image"
              />
            </VCol>


            <!-- status -->
           
          </VRow>
        </VContainer>
      </VCardText>

      <VCardActions>
        <VSpacer />

        <VBtn
          color="error"
          variant="outlined"
          @click="close"
        >
          Cancel
        </VBtn>

        <VBtn
          color="success"
          variant="elevated"
          @click="save"
        >
          Save
        </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>

  <!-- 👉 Delete Dialog  -->
  <VDialog
    v-model="deleteDialog"
    max-width="500px"
  >
    <VCard>
      <VCardTitle>
        Are you sure you want to delete this item?
      </VCardTitle>

      <VCardActions>
        <VSpacer />

        <VBtn
          color="error"
          variant="outlined"
          @click="closeDelete"
        >
          Cancel
        </VBtn>

        <VBtn
          color="success"
          variant="elevated"
          @click="deleteItemConfirm"
        >
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
import { onMounted, ref } from 'vue';
  
const editDialog = ref(false)
const deleteDialog = ref(false)

  const trainers = ref([]);
  const trainees = ref([]);
  const currentTab = ref(0);
  
  const headers = [
    {
      title: 'Name',
      key: 'name',
    },
    {
      title: 'Birthdate',
      key: 'birthdate',
    },
    {
      title: 'Email',
      key: 'email',
    },
    {
      title: 'Password',
      key: 'password',
    },
    {
      title: 'Phone',
      key: 'phone',
    },
    {
      title: 'Image',
      key: 'image',
    },
    {
      title: 'Actions',
      key: 'actions',
    },
  ];


  const defaultItem = ref({
  responsiveId: '',
  id: -1,
  name: '',
  birthdate: '',
  email: '',
  password: '',
  phone: '',
  image: '',

})

  const editedItem = ref(defaultItem.value)
const editedIndex = ref(-1)
  
  const getTrainers = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/trainers");
      trainers.value = response.data;
    } catch (error) {
      console.error(error);
    }
  };
  
  const getTrainees = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/trainees");
      trainees.value = response.data;
    } catch (error) {
      console.error(error);
    }
  };

  const editItem = item => {
  editedIndex.value = currentTab === 0 ? trainers : trainees.value.indexOf(item)
  editedItem.value = { ...item }
  editDialog.value = true
}

const deleteItem = item => {
  editedIndex.value = currentTab === 0 ? trainers : trainees.value.indexOf(item)
  editedItem.value = { ...item }
  deleteDialog.value = true
}

const close = () => {
  editDialog.value = false
  editedIndex.value = -1
  editedItem.value = { ...defaultItem.value }
}

const closeDelete = () => {
  deleteDialog.value = false
  editedIndex.value = -1
  editedItem.value = { ...defaultItem.value }
}

const save = () => {
  if (editedIndex.value > -1)
    Object.assign(currentTab === 0 ? trainers : trainees.value[editedIndex.value], editedItem.value)
  else
  currentTab === 0 ? trainers : trainees.value.push(editedItem.value)
  close()
}

const deleteItemConfirm = () => {
    currentTab === 0 ? trainers : trainees.value.splice(editedIndex.value, 1)
  closeDelete()
}
  
  onMounted(() => {
    getTrainers();
    getTrainees();
  });
  </script>
  <style scoped>
 .icon-wrapper {
  display: flex;
  justify-content: flex-end;
  margin-top: 10px; 
  margin-right: 15px;
  font-size: large;
}
.bigger-icon {
  font-size: 21px; 
}
  </style>
  