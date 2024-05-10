<template>
    <div v-if="isLoading" class="center-container">
        <VProgressCircular :size="30" width="3" color="primary" indeterminate />
    </div>
    <div v-else>
        <div style="display: flex; align-items: center;">
            <router-link to="/modules">
                <IconBtn size="medium" style="margin-right: 8px;" class="red-icon">
                    <VIcon icon="ri-arrow-left-circle-line" />
                </IconBtn>
            </router-link>
            <h1>
                Add a new Module
            </h1>
        </div>

        <br />
        <VCard>
            <VCardText>
                <VForm @submit.prevent="addModule">
                    <VRow>

                        <!-- Training course -->
                        <VCol cols="12">
                            <v-select prepend-icon="ri-artboard-line" :items="trainCourses"
                                v-model="module.trainingcourse_id" item-title="name" item-value="id"
                                label="Training Course" placeholder="Select Training Course" />
                        </VCol>

                        <!-- Session name  -->
                        <VCol cols="12">
                            <VTextField v-model="module.name" prepend-inner-icon="ri-presentation-line"
                                label="Module Name" placeholder="Module" />
                        </VCol>

                        

                        <VCol cols="12">
                            <VBtn type="submit" class="me-4">
                                Add new
                            </VBtn>
                            <VBtn color="secondary">
                                <router-link to="/modules" class="router-link-cancel">
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
import Swal from 'sweetalert2';
import { onMounted, ref } from "vue";
import { useRouter } from 'vue-router';
const isInputEnabled = ref(false)
const isLoading = ref(true)
const module = ref({
    name: "",  trainingcourse_id: ""
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

const addModule = async () => {
    console.log(module.value)
    if (module.value.name == "" || module.value.trainingcourse_id == "") {
        Swal.fire({
            title: "Error!",
            text: "Please fill all the required fields",
            icon: "error"
        });
        return;
    }
    else {
        await axios.post("http://localhost:8000/api/modules", module.value)
            .then(res => {
                Swal.fire({
                    title: "Good job!",
                    text: "a new session was added successfully!",
                    icon: "success"
                });
                router.push('/modules');
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
