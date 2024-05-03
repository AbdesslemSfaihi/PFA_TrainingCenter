<template>
    <div v-if="isLoading" class="text-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div v-else>
        <div style="display: flex; align-items: center;">
            <IconBtn size="medium" style="margin-right: 8px;" class="red-icon">
                <VIcon icon="ri-arrow-left-circle-line" />
            </IconBtn>
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
                        <!-- eslint-disable-next-line vue/valid-v-slot -->
                        <!-- <VSelect :items="trainCourses" v-model="session.trainingcourse_id" label="Standard"
                            placeholder="Select Item" eager>
                            <template #default="{ item }">
                                {{ item.name }}
                            </template>
</VSelect> -->

                        <!-- Session name  -->
                        <VCol cols="12">
                            <VTextField v-model="session.name" prepend-inner-icon=" ri-artboard-line"
                                label="Session Name" placeholder="Summer Session" />
                        </VCol>

                        <!-- Session starting date -->
                        <!-- <template>
                            <AppDateTimePicker v-model="session.startingDate" label="Inline" placeholder="Select Date"
                                :config="{ inline: true }" />
                        </template> -->

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
                        <VCol cols="12">
                            <VIcon icon="ri-price-tag-2-line" />

                            Price with discount: {{ session.initialPrice - (session.initialPrice * session.discount /
                                100) }}
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

const isInputEnabled = ref(false)
const isLoading = ref(true)
const session = ref({
    name: "", startingDate: "", initialPrice: "", discount: "", priceWD: "", trainingcourse_id: ""
});
const trainCourses = ref([])
const router = useRouter();

const items = [
    'Foo',
    'Bar',
    'Fizz',
    'Buzz',
]

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
.router-link-cancel {
    color: white;
}

.red-icon {
    color: red;
}
</style>