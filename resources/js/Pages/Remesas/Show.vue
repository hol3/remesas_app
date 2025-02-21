<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    factura: Object,
});

console.log(props.factura);
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 uppercase dark:text-gray-200">
                    {{ factura.data.codigo }}
                </h2>
                <div class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    <Link :href="route('remesas.index')" class="text-blue-400 underline hover:text-blue-300">Remesas</Link>
                    <span> / </span>
                    <Link :href="route('mensajeros.show', factura.data.mensajero.id)
                        " class="text-blue-400 underline hover:text-blue-300">{{ factura.data.mensajero.nombre }}</Link>
                </div>
            </div>
        </template>
        <div class="py-12">
        <!-- card -->
        <div class="max-w-md mx-auto overflow-hidden bg-white border shadow-lg shadow-teal-300 dark:bg-gray-700 dark:text-gray-300 rounded-xl md:max-w-2xl">
            <div class="md:flex">
                <div class="md:shrink-0">
                    <img class="object-cover w-full h-48 md:h-full md:w-48" src="/img/client-image.jpg"
                        alt="User profile picture" />
                </div>
                <div class="p-8">
                    <p class="mt-2 text-slate-500 dark:text-gray-100">
                        <span class="font-semibold uppercase text-slate-800 dark:text-gray-300">Cliente: </span>{{ factura.data.nombre_cliente }}
                    </p>
                    <p class="mt-2 text-slate-500 dark:text-gray-100">
                        <span class="font-semibold uppercase text-slate-800 dark:text-gray-300">Telefono: </span>{{ factura.data.telefono }}
                    </p>
                    <p class="mt-2 text-slate-500 dark:text-gray-100">
                        <span class="font-semibold uppercase text-slate-800 dark:text-gray-300">Cantidad: </span>{{ factura.data.cantidad }} {{ factura.data.moneda.nombre }}
                    </p>
                    <p class="mt-2 text-slate-500 dark:text-gray-100">
                        <span class="font-semibold uppercase text-slate-800 dark:text-gray-300">Localidad: </span>{{ factura.data.localidad }}
                    </p>
                    <p class="mt-2 text-slate-500 dark:text-gray-100">
                        <span class="font-semibold uppercase text-slate-800 dark:text-gray-300">Direccion: </span>{{ factura.data.direccion }}
                    </p>
                    <p class="mt-2 text-slate-500 dark:text-gray-100">
                        <span class="font-semibold uppercase text-slate-800 dark:text-gray-300">Referencia: </span>{{ factura.data.referencia }}
                    </p>
                    <p class="mt-2 uppercase text-slate-500 dark:text-gray-100">
                        <span class="font-semibold text-slate-800 dark:text-gray-300">Estado: </span>{{ factura.data.estado }}
                    </p>
                    <div class="flex items-center mt-4"></div>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
