<template>
  <VCard>
  <div>
    <!-- 👉 VTabs -->
    <VTabs v-model="currentTab" class="d-flex">
        <VTab>Trainer</VTab>
        <VTab>Trainee</VTab>

        <div class="flex-grow-1"></div> <router-link to="/personnes/add">
          <div class="icon-wrapper">
            <VBtn
              variant="text"
              icon="ri-user-add-line"
              color="secondary"
              class="bigger-icon"
            />
          </div>
        </router-link>
      </VTabs>

    <!-- 👉 Datatable -->
    <VDataTable
      :headers="headers"
      :items="currentTab === 0 ? trainers : trainees"
      :items-per-page="5"
      class="text-no-wrap"
    >

    <!-- Image -->
    <template #item.image="{ item }">
        <img :src="item.image" width="70" height="70" />
      </template>


    
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
        @click="deleteItem(item)">
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
</VCard>
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
    title: 'Image',
    key: 'image',
  },
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

const editItem = (item) => {
  editedIndex.value = currentTab.value === 0 ? trainers.value.indexOf(item) : trainees.value.indexOf(item);
  editedItem.value = { ...item };
  editDialog.value = true;
};

const deleteItem = item => {
  editedIndex.value = currentTab === 0 ? trainers.value.indexOf(item) : trainees.value.indexOf(item);
  editedItem.value = { ...item };
  deleteDialog.value = true;
};


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

const save = async () => {
  if (editedIndex.value > -1) {
    if (currentTab.value === 0) {
      // Update trainer on server
      try {
        await axios.put(`http://localhost:8000/api/trainers/${editedItem.value.id}`, editedItem.value);
        Object.assign(trainers.value[editedIndex.value], editedItem.value);
      } catch (error) {
        console.error(error);
        // Handle update error (e.g., show error message)
      }
    } else {
      // Update trainee on server
      try {
        await axios.put(`http://localhost:8000/api/trainees/${editedItem.value.id}`, editedItem.value);
        Object.assign(trainees.value[editedIndex.value], editedItem.value);
      } catch (error) {
        console.error(error);
        // Handle update error
      }
    }
  } else {
    
  }
  close();
};

const deleteItemConfirm = async () => {
  if (currentTab.value === 0) {
    try {
      await axios.delete(`http://localhost:8000/api/trainers/${editedItem.value.id}`);
      trainers.value.splice(editedIndex.value, 1);
      closeDelete(); 
    } catch (error) {
      console.error(error);
    }
  } else {
    try {
      await axios.delete(`http://localhost:8000/api/trainees/${editedItem.value.id}`);
      trainees.value.splice(editedIndex.value, 1);
      closeDelete(); 
    } catch (error) {
      console.error(error);
    }
  }
};

onMounted(() => {
  getTrainers();
  getTrainees();
});
</script>
<style scoped>
  .icon-wrapper {
    display: flex;
    justify-content: flex-end;
    
    margin-right: 30px;
    font-size: large;
  }

  .bigger-icon {
    font-size: 21px;
  }

  .d-flex {
    display: flex;
  }

  .flex-grow-1 {
    flex-grow: 1;
  }
</style>
