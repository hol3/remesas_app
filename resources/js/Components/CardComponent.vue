<template>
    <!--User Card-->
    <div class="bg-white border p-6 rounded-lg hover:shadow-2xl transition-all ease-in-out duration-300">
        <!--Profile Photo-->
        <div class="flex items-center justify-center">
            <img class="w-16 h-16 rounded-full" src="/img/user-profile.jpg" alt="">
        </div>
        <!--Profile data-->
        <div class="mt-4 p-1">
            <h3 class="font-semibold text-gray-500">{{ profile.nombre }}</h3>
            <p class="text-slate-500">Tel: <a :href=profile.telefono class="text-slate-500 font-semibold">{{ profile.telefono }}</a></p>
            <p class="text-slate-600">Entregas pendientes: <small class="font-bold">{{ profile.totalPendientes }}</small></p>
        </div>
        <div class="flex w-full items-end justify-end mt-2">
            <Link :href="route('mensajeros.show', profile.id)" class="text-blue-500 text-sm font-semibold underline">detalles</Link> 
        </div>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
const props = defineProps({
    profile: {
        type: Object,
        default: () => ({})
    }
})

</script>