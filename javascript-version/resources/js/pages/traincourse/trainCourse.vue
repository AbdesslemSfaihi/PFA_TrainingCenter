<template>
    <div>
        <!-- <div v-if="isLoading">Loading...</div> -->
        <div v-if="isLoading" class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else>
            <h1>Training Course</h1>
            <VCol cols="12">
                <VBtn class="me-4">
                    <router-link to="/trainingCourses/add" class="router-link-custom">
                        <IconBtn size="small">
                            <VIcon icon="ri-add-circle-fill" />
                        </IconBtn>
                        Add a new training course
                    </router-link>
                </VBtn>
            </VCol>
            <VCard>
                <VDataTable :headers="headers" :items="trainCourses" :items-per-page="10" class="text-no-wrap">
                    <!-- eslint-disable-next-line vue/valid-v-slot -->
                    <template #item.name="{ item }">
                        <div>{{ item.name }}</div>
                    </template>
                    <!-- eslint-disable-next-line vue/valid-v-slot -->
                    <template #item.period="{ item }">
                        <div>{{ item.period }}</div>
                    </template>
                    <!-- eslint-disable-next-line vue/valid-v-slot -->
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

        <!-- 👉 Edit Dialog  -->
        <VDialog v-model="editDialog" max-width="600px">
            <VCard>
                <VCardTitle>
                    <span class="headline">Edit Training Course</span>
                </VCardTitle>

                <VCardText>
                    <VContainer>
                        <VRow>
                            <!-- name -->
                            <VCol cols="12">
                                <VTextField prepend-inner-icon="ri-artboard-line" v-model="editedItem.name"
                                    label="Training Course Name" />
                            </VCol>

                            <!-- period -->
                            <VCol cols="12">
                                <VTextField prepend-inner-icon="ri-timer-line" v-model="editedItem.period"
                                    label="Period" />
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
        <!-- 👉 Delete Dialog  -->
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
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';
import Swal from 'sweetalert2';


const defaultItem = ref({
    responsiveId: '',
    id: -1,
    name: '',
    period: '',
})
const headers = [
    {
        title: 'NAME',
        key: 'name',
    },
    {
        title: 'PERIOD',
        key: 'period',
    },
    {
        title: 'ACTIONS',
        key: 'id',
    },
];

const isLoading = ref(true)
const router = useRouter();
const route = useRoute();
const editedItem = ref(defaultItem.value);
const editedIndex = ref(-1);

const editDialog = ref(false);
const deleteDialog = ref(false);


const trainCourses = ref([]);

const getTrainingCourses = async () => {
    try {
        await axios.get('http://localhost:8000/api/trainingcourses').then((response) => {
            console.log(response.data);
            trainCourses.value = response.data;
            isLoading.value = false;
        });
    } catch (error) {
        console.error(error);
    }
};

// Edit methods 
const editItem = item => {
    // console.log(item);
    // console.log(item.id);
    // console.log(editedIndex.value);
    // console.log(editedItem.value);
    editedIndex.value = item.id
    editedItem.value = { ...item }
    editDialog.value = true

    // console.log("-------------" + editedIndex.value);
    // console.log("-------------" + editedItem.value);
}

const close = () => {
    editDialog.value = false
    editedIndex.value = -1
    editedItem.value = { ...defaultItem.value }
}

const edit = () => {
    if (editedIndex.value > -1) {
        // console.log(editedItem.value);
        // console.log(editedIndex.value);
        axios.put(`http://localhost:8000/api/trainingcourses/${editedIndex.value}`, editedItem.value).then(() => {
            editDialog.value = false
            getTrainingCourses();
            Swal.fire({
                title: "Good job!",
                text: "This training course has been successfully changed!",
                icon: "success"
            });
        })
            .catch(error => {
                console.error("There was an error!", error);
            });
    }
    else {
        console.log("No item to edit")
        close()
    }
}

const deleteItem = async (item) => {

    editedIndex.value = item.id
    editedItem.value = { ...item }
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
                axios.delete(`http://localhost:8000/api/trainingcourses/${editedIndex.value}`).then(() => {
                    getTrainingCourses();
                    Swal.fire({
                        title: "Deleted!",
                        text: "This training course has been deleted.",
                        icon: "success"
                    });
                })
            } catch (error) {
                console.log(error)
            }
        }
    });
}



onMounted(() => {
    getTrainingCourses();
});

</script>

<style>
.router-link-custom {
    color: white;
    /* Set the desired text color */
}
</style>
