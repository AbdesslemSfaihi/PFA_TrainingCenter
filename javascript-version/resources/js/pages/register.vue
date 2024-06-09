<template>
  <div class="container">
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard class="auth-card pa-4 pt-7" max-width="448">
      <VCardItem class="justify-center">
        <template #prepend>
          <div class="d-flex">
            <div v-html="logo" />
          </div>
        </template>
        <VCardTitle class="font-weight-semibold text-2xl text-uppercase">
          My Academy
        </VCardTitle>
      </VCardItem>
      <VCardText class="pt-2">
        <h5 class="text-h5 font-weight-semibold mb-1">
          Adventure starts here 🚀
        </h5>
        <p class="mb-0"></p>
      </VCardText>
      <VCardText>
        <VForm @submit.prevent="handleSubmit">
          <VRow>
            <VCol cols="12">
              <VTextField v-model="user.name" label="Name" placeholder="Johndoe" required autofocus autocomplete="off" />
            </VCol>
            <VCol cols="12">
              <VTextField v-model="user.email" label="Email" placeholder="johndoe@email.com" type="email" required autofocus autocomplete="off" />
            </VCol>
            <VCol cols="12">
              <VTextField v-model="user.password" label="Password" placeholder="············" type="password" required autocomplete="off" />
            </VCol>
            <VCol cols="12">
              <VTextField v-model="user.password_confirmation" label="Password Confirmation" placeholder="············" type="password" required autocomplete="off" />
            </VCol>
            <VCol cols="12" class="text-center text-base">
              <VBtn block type="submit">Register</VBtn>
            </VCol>
            <VCol cols="12" class="text-center text-base">
              <span>Already have an account?</span>
              <RouterLink class="text-primary ms-2" to="login">Sign in instead</RouterLink>
            </VCol>
            <VCol cols="12" class="d-flex align-center">
              <VDivider />
              <span class="mx-4">or</span>
              <VDivider />
            </VCol>
            <VCol cols="12" class="text-center">
              <AuthProvider />
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
    <VImg class="auth-footer-start-tree d-none d-md-block" :src="authV1Tree" :width="250" />
    <VImg :src="authV1Tree2" class="auth-footer-end-tree d-none d-md-block" :width="350" />
    <VImg class="auth-footer-mask d-none d-md-block" :src="authThemeMask" />
  </div>
</div>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const user = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});
const router = useRouter();

const handleSubmit = async () => {
  try {
    const response = await axios.post('http://localhost:8000/api/register/', user.value);
    console.log(response);
    router.push({ name: 'login' });
  } catch (err) {
    console.error(err);

    // Check if err.response and err.response.data are defined
    if (err.response && err.response.data) {
      alert('Registration failed: ' + JSON.stringify(err.response.data.errors));
    } else {
      alert('Registration failed: An unexpected error occurred.');
    }
  }
};
</script>

<style scoped>
.marge {
  position: fixed;
  width: 100%;
  height: 300px;
  margin: 5% auto;
  padding: 20px;
  border: 5px solid #ccc;
  background-color: #fff;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 30%;
  height: 100vh; /* Adjust if needed */
}
</style>
