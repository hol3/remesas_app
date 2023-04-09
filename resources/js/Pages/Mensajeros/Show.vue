<template>
    <Head :title="mensajero.nombre" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ mensajero.nombre }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between p-4 mb-2 text-gray-600">
                    <p class="text-2xl font-semibold">Entregas pedientes: {{ pendientes }}</p>
                    <p class="text-2xl font-semibold">Pendiente por cobrar: ${{ pendientes * mensajero.comision }}</p>
                    <p class="text-2xl font-semibold">Comisión de hoy: ${{ cobroHoy }}</p>
                </div>
                <RemesasComponent :remesas="remesas" :pagination="pagination" />
            </div>
        </div>        
    </AuthenticatedLayout>
</template>
<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RemesasComponent from '@/Components/RemesasComponent.vue';

const props = defineProps({
    mensajero: {
        type: Object,
        default: () => ({})
    },
    remesas: {
        type: Object,
        default: () => ({})
    },
    pagination: {
        type: Object,
        default: () => ({})
    },
    pendientes: null,
    cobroHoy: null,
})

console.log(props.remesas)
</script>