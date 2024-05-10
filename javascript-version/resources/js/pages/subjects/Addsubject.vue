<template>
  <div>
      <div style="display: flex; align-items: center;">
          <router-link to="/subjects" class="router-link-cancel">
              <IconBtn size="medium" style="margin-right: 8px;" class="red-icon">
                  <VIcon icon="ri-arrow-left-circle-line" />
              </IconBtn>
          </router-link>
          <h1>
              Add a new Subject
          </h1>
      </div>

      <br />
      <VCard>
          <VCardText>
              <VForm @submit.prevent="addSubject">
                  <VRow>
                      <VCol cols="12">
                          <VTextField v-model="subject.name" prepend-inner-icon=" ri-artboard-line"
                              label="Subject Name" placeholder="Front end Full subject" required />
                      </VCol>

                    

                      <VCol cols="12">
                          <VBtn type="submit" class="me-4">
                              Add new
                          </VBtn>
                          <VBtn color="secondary">
                              <router-link to="/subjects" class="router-link-cancel">
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
const subject = ref({
  name: ""
});
const router = useRouter();
const addSubject = async () => {
  console.log(subject.value)
  if (subject.value.name == "" ) {
      Swal.fire({
          title: "Error!",
          text: "Please fill all the fields",
          icon: "error"
      });
      return;
  }
  else {
      await axios.post("http://localhost:8000/api/subjects", subject.value)
          .then(res => {
              // console.log("Subject added successfully")
              Swal.fire({
                  title: "Good job!",
                  text: "a subject was added successfully!",
                  icon: "success"
              });
              router.push('/subjects');
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
