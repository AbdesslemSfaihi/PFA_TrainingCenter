<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';
</script>

<template>
  <!-- 👉 Dashboard -->
  <VerticalNavLink :item="{
    title: 'Dashboard',
    icon: 'ri-bar-chart-box-line',
    to: '/dashboard',
  }" />
  <VerticalNavLink :item="{
    title: 'Calendar',
    icon: 'ri-calendar-line',
    to: '/calendar',
  }" />
  <!--👉 Trainings-->
  <VerticalNavSectionTitle :item="{
    heading: 'Trainings',
  }" />
  <VerticalNavLink :item="{
    title: 'Training Courses',
    icon: 'ri-artboard-line',
    to: '/trainingCourses',
  }" />
  <VerticalNavLink :item="{
    title: 'Sessions',
    icon: 'ri-presentation-line',
    to: '/sessions',
  }" />
  <VerticalNavLink :item="{
    title: 'Modules',
    icon: 'ri-book-line',
    to: '/modules',
  }" />
  <VerticalNavLink :item="{
    title: 'Subjects',
    icon: 'ri-book-open-line',
    to: '/subjects',
  }" />
  <VerticalNavLink :item="{
    title: 'Subject to Module',
    icon: 'ri-book-2-line',
    to: '/subjectmodule',
  }" />

<VerticalNavLink :item="{
    title: 'Seances',
    icon: 'ri-book-2-line',
    to: '/seance',
  }" />

  <!--👉 People-->
  <VerticalNavSectionTitle :item="{
    heading: 'People',
  }" />
  <VerticalNavLink :item="{
    title: 'People',
    icon: 'ri-group-line',
    to: '/people',
  }" />
  <!--👉 Trainers-->
  <VerticalNavSectionTitle :item="{
    heading: 'Trainers',
  }" />
  <VerticalNavLink :item="{
    title: 'Add New Trainer',
    icon: 'ri-user-line',
    to: '/people/add',
  }" />
  <VerticalNavLink :item="{
    title: 'Assign Subject',
    icon: 'ri-contacts-book-2-line',
    to: '/subjectmodule',
  }" />
  <!--👉 Payment-->
  <VerticalNavSectionTitle :item="{
    heading: 'Payment',
  }" />
  <VerticalNavLink :item="{
    title: 'Session Payment',
    icon: 'ri-money-dollar-circle-line',
    // to: '/personnes',
  }" />

</template>
