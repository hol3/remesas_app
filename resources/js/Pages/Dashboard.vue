<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="sm:py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid gap-4 sm:grid-cols-3">
                    <h1 class="text-2xl font-bold text-gray-600 sm:col-span-3 dark:text-gray-200">Entregas</h1>
                    <div
                        class="p-4 transition-all duration-300 ease-in-out bg-white rounded-lg shadow-lg dark:bg-slate-600 hover:shadow-none">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-10 h-10 p-1 text-white rounded-full bg-violet-500" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12">
                            </path>
                            <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"></path>
                        </svg>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="mt-4 mb-2 text-lg font-semibold text-gray-600 dark:text-gray-200 ">Entregas Totales</h3>
                                <h1 class="text-2xl font-bold text-gray-600 dark:text-gray-200">{{ total }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 transition-all duration-300 bg-white rounded-lg shadow-lg dark:bg-slate-600 hover:shadow-none">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-10 h-10 p-1 text-white rounded-full bg-lime-500" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2">
                            </path>
                            <path d="M12 3v3m0 12v3"></path>
                        </svg>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="mt-4 mb-2 text-lg font-semibold text-gray-600 dark:text-gray-200">Entregadas</h3>
                                <h1 class="text-2xl font-bold text-gray-600 dark:text-gray-200">{{ entregadas }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 transition-all duration-300 bg-white rounded-lg shadow-lg dark:bg-slate-600 hover:shadow-none">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-10 h-10 p-1 text-white bg-pink-500 rounded-full" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M16.7 8a3 3 0 0 0 -2.7 -2h-4m-2.557 1.431a3 3 0 0 0 2.557 4.569h2m4.564 4.558a2.998 2.998 0 0 1 -2.564 1.442h-4a3 3 0 0 1 -2.7 -2">
                            </path>
                            <path d="M12 3v3m0 12v3"></path>
                            <path d="M3 3l18 18"></path>
                        </svg>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="mt-4 mb-2 text-lg font-semibold text-gray-600 dark:text-gray-200">Pendientes</h3>
                                <h1 class="text-2xl font-bold text-gray-600 dark:text-gray-200">{{ pendientes }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <h1 class="text-2xl font-bold text-gray-600 dark:text-gray-200">Entregas pendientes</h1>
                        <div
                            class="p-4 mt-4 transition-all duration-300 bg-white rounded-lg shadow-lg dark:bg-slate-600 hover:shadow-none">

                            <table class="w-full my-4 text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-800 dark:text-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-center">Factura</th>
                                        <th class="hidden px-6 py-3 text-center md:table-cell">Nombre</th>
                                        <th class="hidden px-6 py-3 text-center lg:table-cell">Cantidad</th>
                                        <th class="hidden px-6 py-3 text-center xl:table-cell">Moneda</th>
                                        <th class="hidden px-6 py-3 text-center xl:table-cell">Fecha</th>
                                        <th class="px-6 py-3 text-center">Cerrar factura</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="remesa in props.remesas" :key="remesa.id"
                                        class="border-b hover:bg-gray-100 dark:bg-slate-700 dark:border-gray-900 dark:hover:bg-gray-800">
                                        <td class="px-6 py-1 font-medium text-gray-900 dark:text-gray-200 whitespace-nowrap">{{
                                            remesa.codigo
                                        }}</td>
                                        <td class="hidden px-6 py-1 md:table-cell">{{ remesa.nombre_cliente }}</td>
                                        <td class="hidden px-6 py-1 text-center lg:table-cell">{{ remesa.cantidad }}
                                        </td>
                                        <td class="hidden px-6 py-1 text-center xl:table-cell">{{ remesa.moneda }}</td>
                                        <td class="hidden px-6 py-1 text-center xl:table-cell">{{
                                            dayjs(remesa.created_at).format('DD/MM/YYYY')
                                        }}</td>
                                        <td class="px-6 py-1 text-center">
                                            <button
                                                class="p-1 text-center transition-all duration-300 bg-green-600 rounded-full hover:bg-green-800 active:bg-green-900"
                                                @click="close(remesa.id)">
                                                <IconCheck color="white" :size="24" stroke-width="2" />
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- <Pagination :data="pagination" /> -->
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-600 dark:text-gray-200">Resumen</h1>
                        <div class="p-4 my-4 transition-all duration-300 ease-in-out bg-white rounded-lg shadow-lg dark:bg-slate-600 dark:text-gray-200 hover:shadow-none">
                            <table class="w-full">
                                <tr v-for="totalMoneda in totalencaja" class="border-b dark:border-gray-800">
                                    <td class="py-4 font-semibold">{{ totalMoneda.nombre }}</td>
                                    <td class="py-4 text-right">{{ totalMoneda.cantidad }}</td>
                                </tr>
                            </table>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-600 dark:text-gray-200">Dinero pendiente por entregar</h2>
                        <div class="p-4 mt-4 transition-all duration-300 ease-in-out bg-white rounded-lg shadow-lg dark:bg-slate-600 dark:text-gray-200 hover:shadow-none">
                            <table class="w-full">
                                <tr v-for="dinero in dineroPendiente" class="border-b dark:border-gray-800">
                                    <td class="py-4 font-semibold">{{ dinero.nombre }}</td>
                                    <td class="py-4 text-right">{{ dinero.cantidad }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime"
import { IconCheck } from "@tabler/icons-vue";
import DashboardComponent from "@/Components/DashboardComponent.vue";

import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    remesas: {
        type: Object,
        default: () => ({})
    },
    totalencaja: {
        type: Object,
        default: () => ({})
    },
    dineroPendiente: {
        type: Object,
        default: () => ({})
    },
    pagination: {
        type: Object,
        default: () => ({})
    },
    total: null,
    entregadas: 0,
    pendientes: 0,
})

dayjs.extend(relativeTime)

const entrega = useForm({
    id: ''
})

const close = (id) => {
    // console.log(id)

    // console.log(entrega)
    if(confirm("Está seguro de cerrar esta entrega?"))
    {
        entrega.id = id
        entrega.put(route('remesas.close', id))
    }
}
console.log(props.remesas)

// const init = () => {
//     console.log(props.remesas)
//     console.log(props.total)
// }

// init()

</script>
