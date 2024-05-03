<template>
    <div>
        <div style="display: flex; align-items: center;">
            <IconBtn size="medium" style="margin-right: 8px;" class="red-icon">
                <VIcon icon="ri-arrow-left-circle-line" />
            </IconBtn>
            <h1>
                Add a new Training Course
            </h1>
        </div>

        <br />
        <VCard>
            <VCardText>
                <VForm @submit.prevent="addTrainCourse">
                    <VRow>
                        <VCol cols="12">
                            <VTextField v-model="trainCourse.name" prepend-inner-icon=" ri-artboard-line"
                                label="Training Course Name" placeholder="Front end Full Course" required />
                        </VCol>

                        <VCol cols="12">
                            <VTextField v-model="trainCourse.period" prepend-inner-icon="ri-timer-line"
                                label="Training Course Period" placeholder="ex. 5 months" required />
                        </VCol>

                        <VCol cols="12">
                            <VBtn type="submit" class="me-4">
                                Add new
                            </VBtn>
                            <VBtn color="secondary">
                                <router-link to="/trainingCourses" class="router-link-cancel">
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
const trainCourse = ref({
    name: "", period: ""
});
const router = useRouter();
const addTrainCourse = async () => {
    console.log(trainCourse.value)
    if (trainCourse.value.name == "" || trainCourse.value.period == "") {
        Swal.fire({
            title: "Error!",
            text: "Please fill all the fields",
            icon: "error"
        });
        return;
    }
    else {
        await axios.post("http://localhost:8000/api/trainingcourses", trainCourse.value)
            .then(res => {
                // console.log("Training course added successfully")
                Swal.fire({
                    title: "Good job!",
                    text: "a training course was added successfully!",
                    icon: "success"
                });
                router.push('/trainingCourses');
            })
            .catch(erreur => {
                console.log(error)
            })
    }

}

onMounted(() => {

});
</script>
<style>
.router-link-cancel {
    color: white;
}

.red-icon {
    color: red;
}
</style>