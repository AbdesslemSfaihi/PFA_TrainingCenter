<template>
    <div>
     <!-- <div v-if="isLoading">Loading...</div> -->
        <div v-if="isLoading" class="text-center">
            <VProgressCircular :size="30" width="3" color="primary" indeterminate />
      </div>
      <div v-else>
        <h1>Subject</h1>
        <VCol cols="12">
          <VBtn class="me-4" color="primary">
          <router-link to="/addsubject" class="router-link-custom">
            <IconBtn size="small">
              <VIcon icon="ri-add-circle-fill" />
            </IconBtn>
            Add a new subject
          </router-link>
        </VBtn>
            </VCol>
        <br />
        <VCard>
          <!-- Datatable -->
          <VDataTable
            :headers="headers"
            :items="subjects"
            :items-per-page="5"
            class="text-no-wrap"
          >
            <!-- Name -->
            <template #item.Name="{ item }">
              <span>{{ item.Name }}</span>
            </template>
  
            <!-- Actions -->
            <template #item.actions="{ item }">
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
            <span class="headline">Edit Subject</span>
          </VCardTitle>
          <VCardText>
            <VContainer>
              <VRow>
                <!-- name -->
                <VCol cols="12">
                  <VTextField
                    prepend-inner-icon="ri-artboard-line"
                    v-model="editedItem.Name"
                    label="Subject Name"
                  />
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
import { useRouter } from 'vue-router';

  
  const subjects = ref([]);
  const isLoading = ref(true);
  const router = useRouter();
  const editedItem = ref({ Name: '' });
  const editedIndex = ref(-1);
  const editDialog = ref(false);
  const deleteDialog = ref(false);
  
  const headers = [
    {
      title: 'Name',
      key: 'Name',
    },
    {
      title: 'Actions',
      key: 'actions',
    },
  ];
  
  const getSubjects = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/subjects");
      subjects.value = response.data;
      isLoading.value = false; // Set loading to false after data is fetched
    } catch (error) {
      console.error(error);
    }
  };
  
  const editItem = (item) => {
    editedIndex.value = item.id;
    editedItem.value = { ...item };
    editDialog.value = true;
  };
  
  const close = () => {
    editDialog.value = false;
    editedIndex.value = -1;
    editedItem.value = { Name: '' }; // Reset editedItem
  };
  
  const edit = () => {
    if (editedIndex.value > -1) {
      axios.put(`http://localhost:8000/api/subjects/${editedIndex.value}`, editedItem.value)
        .then(() => {
          editDialog.value = false;
          getSubjects(); // Fetch subjects again after editing
          Swal.fire({
            title: "Good job!",
            text: "This Subject has been successfully changed!",
            icon: "success"
          });
        })
        .catch(error => {
          console.error("There was an error!", error);
        });
    } else {
      console.log("No item to edit");
      close();
    }
  };
  
  const deleteItem = async (item) => {
    editedIndex.value = item.id;
    editedItem.value = { ...item };
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        try {
          axios.delete(`http://localhost:8000/api/subjects/${editedIndex.value}`)
            .then(() => {
              getSubjects();
              Swal.fire({
                title: "Deleted!",
                text: "This subject course has been deleted.",
                icon: "success"
              });
            })
            .catch(error => {
              console.error("There was an error!", error);
            });
        } catch (error) {
          console.error(error);
        }
      }
    });
  };
  
  onMounted(() => {
    getSubjects();
  });
  </script>
  <style lang="scss">
  .router-link-custom {
  color: white; /* Set text color */
  
}
  </style>
  