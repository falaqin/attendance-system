<script setup>
import Block from '@/components/Block.vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { useAuthStore } from '@/stores';
const auth = useAuthStore();
</script>

<template>
    <article class="prose">
        <h2 class="text-gray-800 dark:text-gray-300">Welcome, {{ auth.user.name }}.</h2>
    </article>
    <DashboardLayout>
        <Block>
            <p class="text-lg mb-4 font-bold leading-relaxed text-gray-800 dark:text-gray-300 truncate">
                Create new staff
            </p>
            <small class="leading-5 text-gray-500 dark:text-gray-400 truncate">
                Total staffs available is: 0 <!-- TODO -->
            </small>
        </Block>
        <Block>
            <p class="text-lg mb-4 font-bold leading-relaxed text-gray-800 dark:text-gray-300 truncate">
                Check staffs attendance report
            </p>
            <small class="leading-5 text-gray-500 dark:text-gray-400 truncate">
                Total staffs late today is: 0
            </small>
        </Block>
    </DashboardLayout>
</template>