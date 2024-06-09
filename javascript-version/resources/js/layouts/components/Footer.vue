<template>
  <div class="h-100 d-flex align-center justify-space-between">
    <!-- 👉 Footer: left content -->
    <span class="d-flex align-center">
      &copy;
      {{ new Date().getFullYear() }}
      Copyright
      <VIcon
        icon="ri-heart-line"
        color="error"
        size="1.25rem"
        class="mx-1"
      />
      By <a
        href="https://github.com/AbdesslemSfaihi/PFA_TrainingCenter"
        target="_blank"
       
        class="text-primary ms-1"
      >MY ACADEMY.</a>
    </span>
    
  </div>
</template>
