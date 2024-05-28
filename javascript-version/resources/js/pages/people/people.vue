<template>
  <div v-if="isLoading" class="text-center">
            <VProgressCircular :size="30" width="3" color="primary" indeterminate />
        </div>
        <div v-else>
          <h1>People</h1>
            <VCol cols="12">
              <VBtn class="move-left me-4">
                    <router-link to="/people/add" class="router-link-custom">
                        <IconBtn size="small">
                            <VIcon icon="ri-add-circle-fill" />
                        </IconBtn>
                        Add a new people 
                    </router-link>
                </VBtn>
            </VCol>

            <VTextField v-model="searchTerm" label="Search" class="mb-4 custom-width" />
  <VCard>
  <div>
    <!-- 👉 VTabs -->
    <VTabs v-model="currentTab" class="d-flex">
        <VTab>Trainer</VTab>
        <VTab>Trainee</VTab>

        
      </VTabs>

    <!-- 👉 Datatable -->
    <VDataTable
      :headers="headers"
      :items="filteredItems" 
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
      <IconBtn size="small" @click="viewItem(item)">
      <VIcon icon="ri-eye-line" />
    </IconBtn>
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

<!-- 👉 View Dialog  -->
<VDialog v-model="viewDialog" max-width="600px">
  <VCard>
    <VCardTitle>
      <span class="headline">View User</span>
    </VCardTitle>

    <VContainer>
      <VRow>
        <!-- Image -->
        <VCol cols="12" class="text-center">
          <div class="image-container">
            <VImg :src="viewedItem.image" height="200" contain class="image-border" />
          </div>
        </VCol>

        <!-- Name -->
        <VCol cols="12" class="mt-4">
          <VTypography variant="subtitle1" class="attribute-name">Name:</VTypography>
          <VTypography class="mt-1 attribute-value">{{ viewedItem.name }}</VTypography>
        </VCol>

        <!-- Birthdate -->
        <VCol cols="12" class="mt-2">
          <VTypography variant="subtitle1" class="attribute-name">Birthdate:</VTypography>
          <VTypography class="mt-1 attribute-value">{{ viewedItem.birthdate }}</VTypography>
        </VCol>

        <!-- Email -->
        <VCol cols="12" class="mt-2">
          <VTypography variant="subtitle1" class="attribute-name">Email:</VTypography>
          <VTypography class="mt-1 attribute-value">{{ viewedItem.email }}</VTypography>
        </VCol>

        <!-- Password -->
        <VCol cols="12" class="mt-2">
          <VTypography variant="subtitle1" class="attribute-name">Password:</VTypography>
          <VTypography class="mt-1 attribute-value">{{ viewedItem.password }}</VTypography>
        </VCol>

        <!-- Phone -->
        <VCol cols="12" class="mt-2">
          <VTypography variant="subtitle1" class="attribute-name">Phone:</VTypography>
          <VTypography class="mt-1 attribute-value">{{ viewedItem.phone }}</VTypography>
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
</div>
</template>

<script setup>
import axios from 'axios';
import { computed, onMounted, ref } from 'vue'; // Add computed import

const editDialog = ref(false);
const deleteDialog = ref(false);

const trainers = ref([]);
const trainees = ref([]);
const currentTab = ref(0);
const isLoading = ref(true);
const searchTerm = ref('');

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
});

// Initialize viewedItem with a clone of defaultItem
const viewedItem = ref({ ...defaultItem.value });
const viewDialog = ref(false);

const viewItem = item => {
  viewedItem.value = { ...item };
  viewDialog.value = true;
};

const closeView = () => {
  viewDialog.value = false;
};

const editedItem = ref({ ...defaultItem.value }); // Initialize with a clone of defaultItem
const editedIndex = ref(-1);

const getTrainers = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/trainers");
    trainers.value = response.data;
    isLoading.value = false;
  } catch (error) {
    console.error(error);
  }
};

const getTrainees = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/trainees");
    trainees.value = response.data;
    isLoading.value = false;
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
  editDialog.value = false;
  editedIndex.value = -1;
  editedItem.value = { ...defaultItem.value };
};

const closeDelete = () => {
  deleteDialog.value = false;
  editedIndex.value = -1;
  editedItem.value = { ...defaultItem.value };
};

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
    // Handle if editedIndex is not greater than -1
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

const filteredItems = computed(() => {
  const items = currentTab.value === 0 ? trainers.value : trainees.value;
  if (!searchTerm.value) {
    return items;
  }
  return items.filter(item =>
    Object.values(item).some(value =>
      String(value).toLowerCase().includes(searchTerm.value.toLowerCase())
    )
  );
});
</script>

<style scoped>
.custom-width {
  max-width: 1050px; /* Adjust the value as needed */
}

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
  .router-link-custom {
  color: white; /* Set text color */
  }
  .move-left {
  transform: translateX(-10px); /* Adjust the value as needed */
}

.image-container {
    border: 2px solid #ddd; /* Adjust border style and color as needed */
    padding: 10px;
    border-radius: 10px; /* Adjust border radius as needed */
  }

  .image-border {
    border-radius: 5px; /* Adjust border radius as needed */
  }

  .attribute-name {
    text-align: left;
    font-weight: bold;
    display: inline-block;
    width: 100px; /* Adjust the width as needed */
  }

  .attribute-value {
    text-align: center;
    display: inline-block;
    width: calc(100% - 120px); /* Adjust the width as needed */
  }

</style>
