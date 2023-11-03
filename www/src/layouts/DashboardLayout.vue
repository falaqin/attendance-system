<template>
    <div class="py-2 sm:py-8 bg-gray-100 dark:bg-gray-900 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <slot name="header"></slot>
        <div class="grid gap-2 px-2 sm:px-0 sm:gap-8 text-neutral-600 grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
            <slot></slot>
        </div>
    </div>
</template>