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
            <h1>Add a new Session</h1>
        </div>
        <br />
        <VCard>
            <VCardText>
                <VForm @submit.prevent="addSession">
                    <VRow>
                        <VCol cols="6">
                            <VRow>
                                <VCol cols="12">
                                    <v-select prepend-icon="ri-artboard-line" :items="trainCourses"
                                        v-model="session.trainingcourse_id" item-title="name" item-value="id"
                                        label="Training Course" placeholder="Select Training Course" />
                                </VCol>
                            </VRow>
                            <VRow>
                                <VCol cols="12">
                                    <VTextField v-model="session.name" prepend-inner-icon="ri-presentation-line"
                                        label="Session Name" placeholder="Summer Session" />
                                </VCol>
                            </VRow>
                            <VRow>
                                <VCol cols="12">
                                    <VTextField v-model="session.startingDate" type="date" label="Starting Date" prepend-inner-icon="ri-calendar-line" />
                                    <!--<VTextField prepend-inner-icon="ri-calendar-line" placeholder="YYYY-MM-DD"
                                        label="Starting Date" v-model="session.startingDate" readonly />-->
                                </VCol>

                            </VRow>
                            <VRow>
                                <VCol cols="12">
                                    <VTextField v-model="session.initialPrice" label="Price" prefix="DT" type="number"
                                        prepend-inner-icon="ri-money-dollar-circle-line" placeholder="2000" min="0" />
                                </VCol>
                            </VRow>
                            <VRow>
                                <VCol cols="2" sm="1">
                                    <VCheckbox v-model="isInputEnabled" />
                                </VCol>
                                <VCol cols="10" sm="11">
                                    <VTextField :disabled="!isInputEnabled" label="Discount %" type="number" min="0"
                                        max="100" placeholder="Discount" prepend-inner-icon="ri-discount-percent-line"
                                        v-model="session.discount" default="0" />
                                </VCol>
                            </VRow>
                            <VRow v-if="isInputEnabled">

                                <VCol cols="12">
                                    Price With Discount
                                    <VTextField prepend-inner-icon="ri-price-tag-2-line"
        prefix="DT"
                                        v-model="session.priceWD" readonly >
                                    
                                    {{ session.initialPrice - (session.initialPrice*session.discount / 100) }}
                                    </VTextField>
                                </VCol>
                            </VRow>
                            <VCol cols="12">
                                <VBtn type="submit" class="me-4">Add new</VBtn>
                                <VBtn color="secondary">
                                    <router-link to="/sessions" class="router-link-cancel">Cancel</router-link>
                                </VBtn>
                            </VCol>
                        </VCol>
                       <!-- <VCol cols="6">
                            <VRow>
                                <v-date-picker title="Starting date" :min="currentDate" elevation="15"
                                    :value="session.startingDate" format="yyyy-MM-dd"
                                    @input="fixDate($event, 'startingDate')"></v-date-picker>
                            </VRow>
                        </VCol>-->
                    </VRow>
                </VForm>
            </VCardText>
        </VCard>
    </div>
</template>
<script setup>
import axios from "axios";
//import moment from 'moment';
import Swal from 'sweetalert2';
import { onMounted, ref } from "vue";
import { useRouter } from 'vue-router';
import { useDate } from 'vuetify';

const currentDate = new Date().toISOString().slice(0, 10);
const isInputEnabled = ref(false)
const isLoading = ref(true)
const session = ref({
    name: "", startingDate: "", initialPrice: "", discount: "0", priceWD: "", trainingcourse_id: ""
});
const trainCourses = ref([])
const trainCoursesNames = ref([])
const router = useRouter();

const date = useDate()


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

const fixDate = (event) => {
    // Format the date and update the session startingDate
    // session.startingDate = format('YYYY-MM-DD');
    // const startingDate = moment(event).format(startingDate, 'keyboardDate')
    session.startingDate = moment(event).format('YYYY-MM-DD');
    console.log(session.startingDate);
};

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
