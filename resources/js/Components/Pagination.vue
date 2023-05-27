<template>
    <div v-if="data.links.length > 3" class="flex justify-center mt-4 space-x-4">
        <Link
            v-for="(link, k) in data.links"
            :key="k"
            class="px-4 py-3 text-sm leading-4 bg-white dark:bg-slate-600 dark:text-gray-200 rounded hover:bg-white dark:hover:bg-slate-700 focus:text-indigo-500 hover:shadow"
            :class="{'bg-indigo-400 text-white': link.active}"
            :href="link.url"
            v-html="link.label"
        />
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    data: {
        type: Object,
        defaul: () => ({})
    }
})
</script>