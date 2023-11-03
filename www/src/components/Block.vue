<template>
    <div class="rounded shadow-lg shadow-gray-200 dark:shadow-gray-900 bg-white dark:bg-gray-800 duration-300 lg:hover:-translate-y-1">
        <div class="cursor-pointer">
            <figure>
                <figcaption class="p-4 overflow-ellipsis overflow-hidden">
                    <!-- <p class="text-lg mb-4 font-bold leading-relaxed text-gray-800 dark:text-gray-300 truncate">
                        title
                    </p>
                    <small class="leading-5 text-gray-500 dark:text-gray-400 truncate">
                        body
                    </small> -->
                    <slot/>
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

<style scoped>
/* .card {
  width: 100%;
  max-height: 100px;
} */
</style>
