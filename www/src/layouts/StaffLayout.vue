<script setup>
import StaffNavbar from '../components/StaffNavbar.vue';

</script>
<template>
    <StaffNavbar/>
    <div class="py-2 sm:py-4 sm:px-6 lg:px-8 max-w-7xl mx-auto px-2">
        <RouterView />
    </div>
</template>