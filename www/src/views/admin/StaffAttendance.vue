<script setup>
import Table from '@/components/Table.vue';
import { useAttendanceStore } from '@/stores';
import DefaultBadge from '@/components/DefaultBadge.vue'
import DangerBadge from '@/components/DangerBadge.vue';
let attendanceStore = useAttendanceStore();

const staff = async () => {
    await attendanceStore.index();
}
staff()

</script>
<template>
    <template v-if="attendanceStore.record">
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
        ]">
            <template v-slot:status="{ item }">
                <template v-if="item.status == 'Late'">
                    <danger-badge>
                        <span>{{ item.status }}</span>
                    </danger-badge>
                </template>
                <template v-else>
                    <default-badge>
                        <span>{{ item.status }}</span>
                    </default-badge>
                </template>
            </template>
        </Table>
    </template>
</template>