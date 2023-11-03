<template>
    <div
        class="rounded shadow-lg shadow-gray-200 dark:shadow-gray-900 bg-white dark:bg-gray-800">
        <div>
            <figure>
                <figcaption class="p-4 overflow-ellipsis overflow-hidden">
                    <slot />
                </figcaption>
            </figure>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: 'Block',

    setup(props) {
    },
};
</script>
