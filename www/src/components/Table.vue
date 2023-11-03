<script setup>
import { defineComponent, computed } from 'vue'
const props = defineProps({
    data: {
        default: [{
            n: '4',
            c: '3',
            p: '2',
            k: '1',
            id: 1,
        }],
    },
    headers: {
        default: [
            {
                value: 'H',
                key: 'k'
            },
            {
                value: 'A',
                key: 'n'
            },
            {
                value: 'S',
                key: 'c'
            },
            {
                value: 'O',
                key: 'p'
            },
        ],
    },
    enableAction: {
        default: false
    }
})

// Create a computed property
const orderedHeaders = computed(() => {
    // Sort headers based on their order in the 'headers' prop
    return props.headers.slice().sort((a, b) => {
        return props.headers.findIndex((header) => header.key === a.key) -
            props.headers.findIndex((header) => header.key === b.key);
    });
});

// if (props.enableAction) {
//     props.headers.push({
//         value: 'Actions',
//         key: 'actions' // A key that doesn't correspond to any data property
//     },)
// }

</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th v-for="header in orderedHeaders" :key="header" scope="col" class="px-6 py-3">
                        {{ header.value }}
                    </th>
                    <template v-if="enableAction">
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </template>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item, index in data" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td v-for="header in orderedHeaders" :key="header.key" class="px-6 py-4">
                        {{ item[header.key] }}
                    </td>
                    <template v-if="enableAction">
                        <td class="px-6 py-4">
                            <slot name="actions" :item="item" :index="index"></slot>
                        </td>
                    </template>
                </tr>
            </tbody>
        </table>
    </div>
</template>