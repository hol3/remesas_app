<template>
    <!--User Card-->
    <div class="bg-white border p-6 rounded-lg dark:bg-slate-700 hover:shadow-2xl transition-all ease-in-out duration-300">
        <!--Profile Photo-->
        <div class="flex items-center justify-center">
            <img class="w-16 h-16 rounded-full" src="/img/user-profile.jpg" alt="">
        </div>
        <!--Profile data-->
        <div class="mt-4 p-1">
            <h3 class="font-semibold text-gray-500 dark:text-gray-300">{{ profile.nombre }}</h3>
            <p class="text-slate-500 dark:text-gray-300">Tel: <a :href=profile.telefono class="text-slate-500 dark:text-gray-300 font-semibold">{{ profile.telefono }}</a></p>
            <p class="text-slate-600 dark:text-gray-300">Entregas pendientes: <small class="font-bold">{{ profile.totalPendientes }}</small></p>
        </div>
        <div class="flex w-full items-center justify-between mt-2">
            <Link :href="route('mensajeros.show', profile.id)" class="inline-flex items-center ml-2 px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest my-2 bg-green-600 hover:bg-green-800 active:bg-green-900"><IconFileDescription/></Link>
            <Link class="inline-flex items-center ml-2 px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest my-2 bg-red-600 hover:bg-red-800 active:bg-red-900"><IconTrash /></Link>
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