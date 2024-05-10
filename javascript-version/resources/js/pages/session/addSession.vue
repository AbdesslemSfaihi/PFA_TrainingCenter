<template>
    <div v-if="isLoading" class="center-container">
        <VProgressCircular :size="30" width="3" color="primary" indeterminate />
    </div>
    <div v-else>
        <div style="display: flex; align-items: center;">
            <router-link to="/sessions">
                <IconBtn size="medium" style="margin-right: 8px;" class="red-icon">
                    <VIcon icon="ri-arrow-left-circle-line" />
                </IconBtn>
            </router-link>
            <h1>
                Add a new Session
            </h1>
        </div>

        <br />
        <VCard>
            <VCardText>
                <VForm @submit.prevent="addSession">
                    <VRow>

                        <!-- Training course -->
                        <VCol cols="12">
                            <v-select prepend-icon="ri-artboard-line" :items="trainCourses"
                                v-model="session.trainingcourse_id" item-title="name" item-value="id"
                                label="Training Course" placeholder="Select Training Course" />
                        </VCol>

                        <!-- Session name  -->
                        <VCol cols="12">
                            <VTextField v-model="session.name" prepend-inner-icon="ri-presentation-line"
                                label="Session Name" placeholder="Summer Session" />
                        </VCol>

                        <!-- Session starting date -->
                        <AppDateTimePicker v-model="session.startingDate" label="Select a starting date"
                            placeholder="Select date" />

                        <VCol cols="12">
                            <VTextField v-model="session.startingDate" prepend-inner-icon="ri-calendar-line"
                                label="Starting Date" placeholder="2021-12-31" />
                        </VCol>

                        <!-- Initial price -->
                        <VCol cols="12">
                            <VTextField v-model="session.initialPrice" label="Price" prefix="DT" type="number"
                                prepend-inner-icon="ri-money-dollar-circle-line" placeholder="2000" min="0" />
                        </VCol>
                        <!-- Discount -->
                        <VCol cols="2" sm="1">
                            <VCheckbox v-model="isInputEnabled" />
                        </VCol>

                        <VCol cols="10" sm="11">
                            <VTextField :disabled="!isInputEnabled" label="Discount %" type="number" min="0" max="100"
                                placeholder="Discount" prepend-inner-icon="ri-discount-percent-line"
                                v-model="session.discount" default="0" />
                        </VCol>
                        <VCol cols="12" v-if="isInputEnabled">
                            <VIcon icon="ri-price-tag-2-line" />

                            Price after discount: DT {{ session.initialPrice - (session.initialPrice * session.discount
                                /
                                100) }}
                        </VCol>
                        <VCol cols="12">
                            <VBtn type="submit" class="me-4">
                                Add new
                            </VBtn>
                            <VBtn color="secondary">
                                <router-link to="/sessions" class="router-link-cancel">
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
import axios from "axios";
import { ref, onMounted } from "vue";
import Swal from 'sweetalert2';
import { useRouter } from 'vue-router';

const now = new Date();
const currentMonth = now.toLocaleString('default', { month: '2-digit' })
const currentYear = now.getFullYear()
const currentDay = now.toLocaleString('default', { day: '2-digit' })
const isInputEnabled = ref(false)
const isLoading = ref(true)
const session = ref({
    name: "", startingDate: "", initialPrice: "", discount: "", priceWD: "", trainingcourse_id: ""
});
const trainCourses = ref([])
const trainCoursesNames = ref([])
const router = useRouter();

// const getTrainingCourseName = (id) => {
//     return trainCourses.value.find((course) => course.id == id).name;
// }
// const getTrainingCourseName = (id) => {
//     const numericId = Number(id); // Convert id to number type
//     console.log('id: ' + numericId);
//     console.log('trainCourse name : ' + trainCourses.value.find((course) => course.id === numericId)?.name);
//     return trainCourses.value.find((course) => course.id === numericId)?.name;
// }

const getTrainingCourses = async () => {
    try {
        await axios.get('http://localhost:8000/api/trainingcourses').then((response) => {
            console.log(response.data);
            trainCourses.value = response.data;
            // trainCoursesNames.value = response.data.map((course) => course.name);
            // console.log('liste des noms: ' + trainCoursesNames.value);
            isLoading.value = false;
        });
    } catch (error) {
        console.error(error);
    }
};

const addSession = async () => {
    console.log(session.value)
    if (session.value.name == "" || session.value.startingDate == "" || session.value.initialPrice == "" || session.value.trainingcourse_id == "") {
        Swal.fire({
            title: "Error!",
            text: "Please fill all the required fields",
            icon: "error"
        });
        return;
    }
    else {
        await axios.post("http://localhost:8000/api/sesses", session.value)
            .then(res => {
                Swal.fire({
                    title: "Good job!",
                    text: "a new session was added successfully!",
                    icon: "success"
                });
                router.push('/sessions');
            })
            .catch(erreur => {
                console.log(error)
            })
    }

}

onMounted(() => {
    getTrainingCourses();
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