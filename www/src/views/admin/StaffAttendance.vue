<script setup>
import Table from '@/components/Table.vue';
import { useAttendanceStore } from '@/stores';
let attendanceStore = useAttendanceStore();
await attendanceStore.index();

</script>
<template>
    <Table :data="attendanceStore.record" :headers="[
        {
            key: 'id',
            value: 'ID'
        },
        {
            key: 'staff',
            value: 'Name'
        },
        {
            key: 'time_clocked_in',
            value: 'Clocked in at'
        },
        {
            key: 'time_clocked_out',
            value: 'Clocked out at'
        },
        {
            key: 'status',
            value: 'Status'
        }
    ]"/>
</template>