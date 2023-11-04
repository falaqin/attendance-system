<script setup>
import Block from '@/components/Block.vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import { useAuthStore, useStaffStore } from '@/stores';
const auth = useAuthStore();
const staff = useStaffStore();

const getStaffs = async () => {
    await staff.index();
}

getStaffs()

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
            <small v-if="staff.staffs.length > 0" class="leading-5 text-gray-500 dark:text-gray-400 truncate">
                Total staffs available is: {{ staff.staffs.length }}
            </small>
        </Block>
        <Block @click="$router.push('/admin/staff/attendance')">
            <p class="text-lg mb-4 font-bold leading-relaxed text-gray-800 dark:text-gray-300 truncate">
                Check staffs attendance report
            </p>
            <small class="leading-5 text-gray-500 dark:text-gray-400 truncate">
                Early/late staffs
            </small>
        </Block>
    </DashboardLayout>
</template>