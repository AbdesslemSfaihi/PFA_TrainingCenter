<template>
    <div v-if="isLoading" class="center-container">
        <VProgressCircular :size="30" width="3" color="primary" indeterminate />
    </div>
    <div v-else>
        <div style="display: flex; align-items: center;">
            <router-link to="/subjectmodule">
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
                <VForm @submit.prevent="addSubjectmodule">
                    <VRow>

                    
                        <VCol cols="12">
                            <v-select prepend-icon="ri-artboard-line" :items="subjects"
                                v-model="Module_Subjet.subject_id" item-title="name" item-value="id"
                                label="Subject" placeholder="Select Subject" />
                        </VCol>

                        <VCol cols="12">
                            <v-select prepend-icon="ri-artboard-line" :items="modules"
                                v-model="Module_Subjet.module_id" item-title="name" item-value="id"
                                label="module" placeholder="Select Module" />
                        </VCol>
                       
                        <VCol cols="12">
                            <VTextField v-model="Module_Subjet.nbHours" prepend-inner-icon="ri-presentation-line"
                                label="Nb hours" placeholder="nb hours" />
                        </VCol>

                        

                        <VCol cols="12">
                            <VBtn type="submit" class="me-4">
                                Add new
                            </VBtn>
                            <VBtn color="secondary">
                                <router-link to="/subjectmodule" class="router-link-cancel">
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
    nbHours: "",  subject_id: "",module_id:""
});
const subjects = ref([])
const subjectsNames = ref([])
const modules = ref([])
const modulesNames = ref([])
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

const getSubjects = async () => {
    try {
        await axios.get('http://localhost:8000/api/subjects').then((response) => {
            console.log(response.data);
           subjects.value = response.data;
            // trainCoursesNames.value = response.data.map((course) => course.name);
            // console.log('liste des noms: ' + trainCoursesNames.value);
            isLoading.value = false;
        });
    } catch (error) {
        console.error(error);
    }
};
const getModules = async () => {
    try {
        await axios.get('http://localhost:8000/api/modules').then((response) => {
            console.log(response.data);
           modus.value = response.data;
            // trainCoursesNames.value = response.data.map((course) => course.name);
            // console.log('liste des noms: ' + trainCoursesNames.value);
            isLoading.value = false;
        });
    } catch (error) {
        console.error(error);
    }
};

const addSubjectmodule = async () => {
    console.log(subject_module.value)
    if (subject_module.value.nbHours == "" || subject_module.value.subject_id == ""|| subject_module.value.module_id == "") {
        Swal.fire({
            title: "Error!",
            text: "Please fill all the required fields",
            icon: "error"
        });
        return;
    }
    else {
        await axios.post("http://localhost:8000/api/subjectmodule", subjetmodule.value)
            .then(res => {
                Swal.fire({
                    title: "Good job!",
                    text: "a new session was added successfully!",
                    icon: "success"
                });
                router.push('/subjectmodule');
            })
            .catch(erreur => {
                console.log(error)
            })
    }

}

onMounted(() => {
    getSubjects();
    getModules();
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

