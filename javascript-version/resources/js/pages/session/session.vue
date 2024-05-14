<template>
    <div>
        <div v-if="isLoading" class="text-center">
            <VProgressCircular :size="30" width="3" color="primary" indeterminate />
        </div>
        <div v-else>
            <h1>Session</h1>
            <VCol cols="12">
                <VBtn class="me-4">
                    <router-link to="/sessions/add" class="router-link-custom">
                        <IconBtn size="small">
                            <VIcon icon="ri-add-circle-fill" />
                        </IconBtn>
                        Add a new session
                    </router-link>
                </VBtn>
            </VCol>
            <VCard>
                <VDataTable :headers="headers" :items="sessions" :items-per-page="10" class="text-no-wrap">
                    <!-- eslint-disable-next-line vue/valid-v-slot -->
                    <template #item.trainingcourse_id="{ item }">
                        <div>{{ getTrainingCourseName(item.trainingcourse_id) }}</div>
                    </template>
                    <!-- eslint-disable-next-line vue/valid-v-slot -->
                    <template #item.name="{ item }">
                        <div>{{ item.name }}</div>
                    </template>
                    <!-- eslint-disable-next-line vue/valid-v-slot -->
                    <template #item.date="{ item }">
                        <div>{{ item.date }}</div>
                    </template>
                    <!-- eslint-disable-next-line vue/valid-v-slot -->
                    <template #item.price="{ item }">
                        <div>{{ item.price }}</div>
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
                            <VCol cols="12">
                                    <v-select prepend-icon="ri-artboard-line" :items="trainCourses"
                                        v-model="editedItem.trainingcourse_id" item-title="name" item-value="id"
                                        label="Training Course" placeholder="Select Training Course" />
                                </VCol>
                            <!-- name -->
                            <VCol cols="12">
                                    <VTextField v-model="editedItem.name" prepend-inner-icon="ri-presentation-line"
                                        label="Session Name" placeholder="Summer Session" />
                            </VCol>

                            <VCol cols="12">
                                    <VTextField prepend-inner-icon="ri-calendar-line" placeholder="YYYY-MM-DD"
                                        label="Starting Date" v-model="editedItem.startingDate" />
                            </VCol>

                            <VCol cols="12">
                                    <VTextField v-model="editedItem.initialPrice" label="Price" prefix="DT" type="number"
                                        prepend-inner-icon="ri-money-dollar-circle-line" placeholder="2000" min="0" />
                            </VCol>

                            <VCol cols="2" sm="1">
                                    <VCheckbox v-model="isInputEnabled" />
                                </VCol>
                                <VCol cols="10" sm="11">
                                    <VTextField :disabled="!isInputEnabled" label="Discount %" type="number" min="0"
                                        max="100" placeholder="Discount" prepend-inner-icon="ri-discount-percent-line"
                                        v-model="editedItem.discount" default="0" />
                                </VCol>
                                <VCol cols="12" v-if="isInputEnabled">
                                    Price With Discount
                                    <VTextField prepend-inner-icon="ri-price-tag-2-line" prefix="DT" v-model="editedItem.priceWD"  readonly >                      
                                    {{ editedItem.priceWD = editedItem.initialPrice - (editedItem.initialPrice*editedItem.discount / 100) }}
                                    </VTextField>
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
import axios from 'axios';
import Swal from 'sweetalert2';
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';


const defaultItem = ref({
    responsiveId: '',
    id: -1,
    name: '',
    startingDate: '', 
    initialPrice: '', 
    discount: 0, 
    priceWD: "", 
    trainingcourse_id: ""
})
const headers = [
    {
        title: 'TRAINING COURSE NAME',
        key: 'trainingcourse_id',
    },
    {
        title: 'SESSION NAME',
        key: 'name',
    },
    {
        title: 'DATE',
        key: 'startingDate',
    },
    {
        title: 'PRICE (DT)',
        key: 'initialPrice',
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

const isInputEnabled = ref(true)

const trainCourses = ref([]);
const sessions = ref([]);

const getSessions = async () => {
    try {
        await axios.get('http://localhost:8000/api/sesses').then((response) => {
            console.log(response.data);
            sessions.value = response.data;
            isLoading.value = false;
        });
    } catch (error) {
        console.error(error);
    }
};

const getTrainingCourses = async () => {
    try {
        await axios.get('http://localhost:8000/api/trainingcourses').then((response) => {
            console.log(response.data);
            trainCourses.value = response.data;
        });
    } catch (error) {
        console.error(error);
    }
};

const getTrainingCourseName = (trainingCourseId) => {
    const trainingCourse = trainCourses.value.find(course => course.id === trainingCourseId);
    return trainingCourse ? trainingCourse.name : '';
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
    console.log(editedItem.value.discount)
    isInputEnabled.value = editedItem.value.discount !== 0
    console.log(isInputEnabled.value)
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
        axios.put(`http://localhost:8000/api/sesses/${editedIndex.value}`, editedItem.value).then(() => {
            editDialog.value = false
            getSessions();
            Swal.fire({
                title: "Good job!",
                text: "This session has been successfully changed!",
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
                axios.delete(`http://localhost:8000/api/sesses/${editedIndex.value}`).then(() => {
                    getSessions();
                    Swal.fire({
                        title: "Deleted!",
                        text: "This session course has been deleted.",
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
    getSessions();
    getTrainingCourses();
});

</script>

<style>
.router-link-custom {
    color: white;
    /* Set the desired text color */
}
</style>
