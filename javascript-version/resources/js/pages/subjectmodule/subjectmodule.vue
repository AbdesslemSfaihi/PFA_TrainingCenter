<template>
    <div>
        <div v-if="isLoading" class="text-center">
            <VProgressCircular :size="30" width="3" color="primary" indeterminate />
        </div>
        <div v-else>
            <h1>Assign a Subject to a Module</h1>
            <VCol cols="12">
                <VBtn class="me-4">
                    <router-link to="subjectmodule/add" class="router-link-custom">
                        <IconBtn size="small">
                            <VIcon icon="ri-add-circle-fill" />
                        </IconBtn>
                        Add a Subject to a Module
                    </router-link>
                </VBtn>
            </VCol>
            <VCard>
                <VDataTable :headers="headers" :items="subject_modules" :items-per-page="10" class="text-no-wrap">
                    <!-- eslint-disable-next-line vue/valid-v-slot -->
                    <template #item.subject_id="{ item }">
                        <div>{{ getSubjectName(item.subject_id) }}</div>
                    </template>
                    <template #item.module_id="{ item }">
                        <div>{{ getModuleName(item.module_id) }}</div>
                    </template>
                    <!-- eslint-disable-next-line vue/valid-v-slot -->
                    <template #item.nbHours="{ item }">
                        <div>{{ item.nbHours }}</div>
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

        <!-- Edit Dialog -->
        <VDialog v-model="editDialog" max-width="600px">
            <VCard>
                <VCardTitle>
                    <span class="headline">Edit module</span>
                </VCardTitle>

                <VCardText>
                    <VContainer>
                        <VRow>
                            <!-- name -->
                            <VCol cols="12">
                                <VTextField prepend-inner-icon="ri-artboard-line" v-model="editedItem.name"
                                    label="Module Name" />
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
    responsiveId: '',
    id: -1,
    nbHours: '',
});
const headers = [
    {
        title: 'SUBJECT NAME',
        key: 'subject_id',
    },
    {
        title: 'MODULE NAME',
        key: 'module_id',
    },
    {
        title: 'NB HOURS',
        key: 'nbHours',
    },
    {
        title: 'ACTIONS',
        key: 'id',
    },
];

const isLoading = ref(true);
const router = useRouter();
const route = useRoute();
const editedItem = ref(defaultItem.value);
const editedIndex = ref(-1);

const editDialog = ref(false);
const deleteDialog = ref(false);

const subjects = ref([]);
const modules = ref([]);
const subject_modules = ref([]);

const getSubjectModules = async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/subjectmodule');
        console.log(response.data);
        subject_modules.value = response.data;
        isLoading.value = false;
    } catch (error) {
        console.error(error);
    }
};

const getModules = async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/modules');
        console.log(response.data);
        modules.value = response.data;
        isLoading.value = false;
    } catch (error) {
        console.error(error);
    }
};

const getSubjects = async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/subjects');
        console.log(response.data);
        subjects.value = response.data;
    } catch (error) {
        console.error(error);
    }
};

const getModuleName = (moduleId) => {
    const module = modules.value.find((module) => module.id === moduleId);
    return module ? module.name : '';
};

const getSubjectName = (subjectId) => {
    const subject = subjects.value.find((subject) => subject.id === subjectId);
    return subject ? subject.Name : '';
};

// Edit methods 
const editItem = (item) => {
    editedIndex.value = item.id;
    editedItem.value = { ...item };
    editDialog.value = true;
};

const close = () => {
    editDialog.value = false;
    editedIndex.value = -1;
    editedItem.value = { ...defaultItem.value };
};

const edit = () => {
    if (editedIndex.value > -1) {
        axios.put(`http://localhost:8000/api/subjectmodule/${editedIndex.value}`, editedItem.value)
            .then(() => {
                editDialog.value = false;
                getSubjectModules();
                Swal.fire({
                    title: "Good job!",
                    text: "This module has been successfully changed!",
                    icon: "success"
                });
            })
            .catch((error) => {
                console.error("There was an error!", error);
            });
    } else {
        console.log("No item to edit");
        close();
    }
};

const deleteItem = (item) => {
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
            axios.delete(`http://localhost:8000/api/subjectmodule/${editedIndex.value}`)
                .then(() => {
                    getSubjectModules();
                    Swal.fire({
                        title: "Deleted!",
                        text: "This module has been deleted.",
                        icon: "success"
                    });
                })
                .catch((error) => {
                    console.error("There was an error!", error);
                });
        }
    });
};

onMounted(() => {
    getModules();
    getSubjects();
    getSubjectModules();
});
</script>

<style>
.router-link-custom {
    color: white;
    /* Set the desired text color */
}
</style>
