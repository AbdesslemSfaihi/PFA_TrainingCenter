<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import {
  VCardItem
} from 'vuetify/lib/components/index.mjs';

const headersTrainers = [{
        title: 'IMAGE',
        key: 'image',
    },
    {
        title: 'NAME',
        key: 'name',
    },
    {
        title: 'EMAIL',
        key: 'email',
    },

];


//get trainers
const isLoading = ref(true)
const trainers = ref([]);
const getTrainers = async () => {
    try {
        await axios.get('http://localhost:8000/api/trainers').then((response) => {
            console.log(response.data);
            trainers.value = response.data;
            isLoading.value = false;
            console.log(trainers.value);
        });
    } catch (error) {
        console.error(error);
    }
};

onMounted(() => {
    getTrainers();
});
</script>

<template>
<VRow class="match-height">
    <VCol cols="12" sm="6">
        <VCard>
            <VCardItem>
                <VCardTitle>Our Trainers</VCardTitle>
            </VCardItem>
            <VCardItem v-for="t in trainers" :key="t.id">
                test
            </VCardItem>
        </VCard>
    </VCol>
</VRow>
</template>
