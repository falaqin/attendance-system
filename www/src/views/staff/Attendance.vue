<script setup>
import { ref, onMounted } from 'vue';
import { useStaffDashboardStore } from '@/stores';
import { useAuthStore } from '@/stores';
import Table from '@/components/Table.vue'
import DefaultBadge from '@/components/DefaultBadge.vue';
import DangerBadge from '@/components/DangerBadge.vue';

const staffStore = useStaffDashboardStore();
const auth = useAuthStore();
const getData = async () => {
    await staffStore.getAll();
}

let data = ref([]);
onMounted(async () => {
    await getData();
    data.value = staffStore.record;
})
</script>

<template>
    <Table :data="data" :headers="[
        {
            key: 'id',
            value: 'ID'
        },
        {
            key: 'name',
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