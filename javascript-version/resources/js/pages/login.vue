<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard class="auth-card pa-4 pt-7 marge" max-width="448">
      <VCardItem class="justify-center">
        <template #prepend>
          <div class="d-flex">
            <div v-html="logo" ></div>
          </div>
        </template>
        <VCardTitle class="font-weight-semibold text-2xl text-uppercase">
          My Academy
        </VCardTitle>
      </VCardItem>
      <VCardText class="pt-2">
        <h5 class="text-h5 font-weight-semibold mb-1">
          Welcome to My academy! 👋🏻
        </h5>
        <p class="mb-0">
          Please sign-in to your account and start the adventure
        </p>
      </VCardText>
      <VCardText>
        <VForm @submit.prevent="handleLogin">
          <VRow>
            <VCol cols="12">
              <VTextField v-model="user.email" label="Email" type="email" required autofocus autocomplete="off" />
            </VCol>
            <VCol cols="12">
              <VTextField v-model="user.password" label="Password" placeholder="············" type="password" required autocomplete="off" />
            </VCol>
            <VCol cols="12" class="d-flex align-center justify-space-between flex-wrap mt-1 mb-4">
              <VCheckbox v-model="user.remember" label="Remember me" />
              <a class="ms-2 mb-1" href="javascript:void(0)">Forgot Password?</a>
            </VCol>
            <VCol cols="12">
              <VBtn block type="submit">Login</VBtn>
            </VCol>
            <VCol cols="12" class="text-center text-base">
              <span>New on our platform?</span>
              <RouterLink class="text-primary ms-2" to="/register">Create an account</RouterLink>
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
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const user = ref({});
const router = useRouter();

const handleLogin = async () => {
  try {
    const response = await axios.post('http://localhost:8000/api/login/', user.value);
    router.push('/dashboard');
    localStorage.setItem('user', response.data.user.name);
    localStorage.setItem('token', response.data.token);
  } catch (err) {
    console.error(err);
    alert(err);
  }
};
</script>

<style scoped>
.auth-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh; /* Adjust if needed */
}

.marge {
  width: 100%;
  max-width: 448px; /* Max width of the form */
  padding: 20px;
  border: 5px solid #ccc;
  background-color: #fff;
}
</style>
