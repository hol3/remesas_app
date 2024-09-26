<template>
    <!--User Card-->
    <div class="p-6 transition-all duration-300 ease-in-out bg-white border rounded-lg dark:bg-slate-700 hover:shadow-2xl">
        <!--Profile Photo-->
        <div class="flex items-center justify-center">
            <img class="w-16 h-16 rounded-full" src="/img/user-profile.jpg" alt="">
        </div>
        <!--Profile data-->
        <div class="p-1 mt-4">
            <h3 class="font-semibold text-gray-500 dark:text-gray-300">{{ profile.nombre }}</h3>
            <p class="text-slate-500 dark:text-gray-300">Tel: <a :href=profile.telefono class="font-semibold text-slate-500 dark:text-gray-300">{{ profile.telefono }}</a></p>
            <p class="text-slate-600 dark:text-gray-300">Entregas pendientes: <small class="font-bold">{{ profile.totalPendientes }}</small></p>
        </div>
        <div class="flex items-center justify-between w-full mt-2">
            <Link :href="route('mensajeros.show', profile.id)" class="inline-flex items-center px-4 py-2 my-2 ml-2 text-xs font-semibold tracking-widest text-white uppercase bg-green-600 border border-transparent rounded-md hover:bg-green-800 active:bg-green-900"><IconFileDescription color="white" :size="24" stroke-width="2"/></Link>
            <Link class="inline-flex items-center px-4 py-2 my-2 ml-2 text-xs font-semibold tracking-widest text-white uppercase bg-red-600 border border-transparent rounded-md hover:bg-red-800 active:bg-red-900"><IconTrash color="white" :size="24" stroke-width="2"/></Link>
        </div>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { IconEdit, IconFileDescription, IconTrash } from '@tabler/icons-vue';
const props = defineProps({
    profile: {
        type: Object,
        default: () => ({})
    }
})

</script>