<script setup>
import { ref, onBeforeUnmount, onMounted } from 'vue';
import moment from 'moment';
import Block from '@/components/Block.vue';
import { useStaffDashboardStore } from '@/stores';

let currentTime = ref(moment().format('hh:mm:ss A'));

const updateClock = () => {
    currentTime.value = moment().format('hh:mm:ss A');
};

const interval = setInterval(updateClock, 1000);

onBeforeUnmount(() => {
    clearInterval(interval);
});

let dashboardStore = useStaffDashboardStore();
const getDashboard = async () => {
    await dashboardStore.fetch();
}

let status = ref(null);
onMounted( async () => {
    await getDashboard();
    status.value = dashboardStore.dashboard.latest_attendance.status;
})

const clocked = async (state) => {
    await dashboardStore.store(state)
    await getDashboard();
}

</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-3" style="height: 89vh" v-if="dashboardStore.dashboard">
        <!-- Left Column -->
        <div class="col-span-1 bg-slate-300 flex items-center justify-center rounded">
            <div class="grid grid-cols-1 gap-4">
                <Block class="col-span-1" v-if="dashboardStore.dashboard.is_today">
                    <article class="prose">
                        <h3
                            :class="[status == 'Early' || status == 'On-time' ? 'text-slate-300' : 'text-red-300']"
                            > You're {{ dashboardStore.dashboard.latest_attendance.status }} today. 
                        </h3>
                    </article>
                </Block>
                <Block class="col-span-1">
                    <article class="prose">
                        <h1 class="text-green-500"> {{ currentTime }} </h1>
                    </article>
                    <blockquote>
                        {{ moment().format('MMMM Do YYYY') }}
                    </blockquote>
                </Block>
                <Block class="col-span-1">
                    Working Hour Starts at:
                    {{ moment(dashboardStore.dashboard.start_time).format('h:mm a') }}
                </Block>
                <Block class="col-span-1"   >
                    Working Hour Ends at:
                    {{ moment(dashboardStore.dashboard.end_time).format('h:mm a') }}
                </Block>
            </div>
        </div>

        <!-- Right Column (Bigger) -->
        <div class="col-span-2 flex items-center justify-center">
            <div>
                <template v-if="dashboardStore.dashboard.can_clock_in">
                    <primary-button @click="clocked(true)">Clock in</primary-button>
                </template>
                <template v-else-if="dashboardStore.dashboard.can_clock_out">
                    <danger-button @click="clocked(false)">Clock out</danger-button>
                </template>
                <template v-else>
                    <span>You have clocked in and out for the day. See you tomorrow!</span>
                </template>
                <!-- Other content for the right column -->
            </div>
        </div>
    </div>
</template>