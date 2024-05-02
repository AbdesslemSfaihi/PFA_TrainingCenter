<template>
    <VForm @submit.prevent>
        <VRow>
            <VCol cols="12">
                <VTextField v-model="name" prepend-inner-icon="ri-user-line" label="Training Course Name"
                    placeholder="John" />
            </VCol>

            <VCol cols="12">
                <VTextField v-model="period" prepend-inner-icon="ri-mail-line" label="Training Course Period"
                    placeholder="ex. 5 months" />
            </VCol>

            <VCol cols="12">
                <VBtn type="submit" class="me-4">
                    Add
                </VBtn>
            </VCol>
        </VRow>
    </VForm>
</template>
<script setup>
import { ref } from 'vue';
const name = ref('')
const period = ref('')
</script>
