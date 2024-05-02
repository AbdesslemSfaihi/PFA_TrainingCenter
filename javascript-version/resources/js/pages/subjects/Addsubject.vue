<template>
  <div class="col-md-6 offset-md-3 border rounded p-4 mt-2 shadow">
    <h4 align="center">Add Subject</h4>
    <form @submit.prevent="addSubject">

      <div class="row">
        <div class="col-md-6">
          <label for="id" class="form-label">ID</label>
          <input type="text" class="form-control" id="id" v-model="subject.id">
        </div>
        <div class="col-md-6 ms-auto">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" v-model="subject.Name">
        </div>
      </div>
      <br/>
      <button type="submit" class="btn btn-outline-primary">
        <i class="fa-solid fa-floppy-disk"></i> Enregister
      </button>
      <router-link to="/subjects" class="btn btn-outline-danger mx-2">
        <i class="fa-solid fa-xmark"></i> Cancel
      </router-link>
    </form>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref } from "vue";
import { useRouter } from 'vue-router';

const router = useRouter();
const subject = ref({
  id: "",
  Name: ""
});

const addSubject = async () => {
  try {
    await axios.post("http://localhost:8000/api/subjects/", subject.value);
    router.push({ name: 'subjects' });
  } catch (error) {
    console.error(error);
  }
};
</script>

<style scoped>
</style>
