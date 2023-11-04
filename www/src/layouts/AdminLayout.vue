<script setup>
import Navbar from '@/components/Navbar.vue';
</script>

<template>
    <div>
        <!-- Your layout header, navigation, or any other common UI elements here -->
        <Navbar/>
        <div class="py-2 sm:py-4 sm:px-6 lg:px-8 max-w-7xl mx-auto px-2">
            <RouterView />
            <!-- <Suspense>
                <template #default>
                </template>
                <template #fallback>
                    <div>Loading...</div>
                </template>
            </Suspense> -->
        </div>

        <!-- Your layout footer or other common UI elements here -->
    </div>
</template>