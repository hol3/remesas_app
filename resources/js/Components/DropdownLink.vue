<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Link class="block w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 transition duration-150 ease-in-out dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-900 focus:outline-none focus:bg-gray-100">
        <slot />
    </Link>
</template>
