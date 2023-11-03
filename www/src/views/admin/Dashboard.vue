<script setup>
import Block from '@/components/Block.vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { useAuthStore, useStaffStore } from '@/stores';
const auth = useAuthStore();
const staff = useStaffStore();
await staff.index();
</script>

<template>
    <article class="prose">
        <h2 class="text-gray-800 dark:text-gray-300 hidden sm:block">Welcome, {{ auth?.user?.name }}.</h2>
    </article>
    <DashboardLayout>
        <Block @click="$router.push('/admin/staff')">
            <p class="text-lg mb-4 font-bold leading-relaxed text-gray-800 dark:text-gray-300 truncate">
                Staffs
            </p>
            <small class="leading-5 text-gray-500 dark:text-gray-400 truncate">
                Total staffs available is: {{ staff.staffs.length }} <!-- TODO -->
            </small>
        </Block>
        <Block @click="$router.push('/admin/staff/attendance')">
            <p class="text-lg mb-4 font-bold leading-relaxed text-gray-800 dark:text-gray-300 truncate">
                Check staffs attendance report
            </p>
        </Block>
    </DashboardLayout>
</template>