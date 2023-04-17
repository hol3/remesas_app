<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="sm:py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid sm:grid-cols-3 gap-4">                    
                    <h1 class="sm:col-span-3 font-bold text-2xl text-gray-600">Entregas</h1>
                    <div
                        class="bg-white p-4 rounded-lg shadow-lg hover:shadow-none transition-all ease-in-out duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="bg-violet-500 text-white rounded-full p-1 w-10 h-10" width="24" height="24"
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
                                <h3 class="text-lg text-gray-600 font-semibold mt-4 mb-2">Entregas Totales</h3>
                                <h1 class="text-2xl text-gray-600 font-bold">{{ total }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-none transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="bg-lime-500 text-white rounded-full p-1 w-10 h-10" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2">
                            </path>
                            <path d="M12 3v3m0 12v3"></path>
                        </svg>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg text-gray-600 font-semibold mt-4 mb-2">Entregadas</h3>
                                <h1 class="text-2xl text-gray-600 font-bold">{{ entregadas }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-none transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="bg-pink-500 text-white rounded-full p-1 w-10 h-10" width="24" height="24"
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
                                <h3 class="text-lg text-gray-600 font-semibold mt-4 mb-2">Pendientes</h3>
                                <h1 class="text-2xl text-gray-600 font-bold">{{ pendientes }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <h1 class="font-bold text-2xl text-gray-600">Entregas pendientes</h1>
                        <div
                            class="bg-white mt-4 p-4 rounded-lg shadow-lg hover:shadow-none transition-all duration-300">
                            
                            <table class="w-full text-sm text-left text-gray-500 my-4">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-center">Factura</th>
                                        <th class="px-6 py-3 text-center hidden md:table-cell">Nombre</th>
                                        <th class="px-6 py-3 text-center hidden lg:table-cell">Cantidad</th>
                                        <th class="px-6 py-3 text-center hidden xl:table-cell">Moneda</th>
                                        <th class="px-6 py-3 text-center hidden xl:table-cell">Fecha</th>
                                        <th class="px-6 py-3 text-center">Cerrar factura</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="remesa in props.remesas" :key="remesa.id"
                                        class="border-b hover:bg-gray-100">
                                        <td class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap">{{
                                            remesa.codigo
                                        }}</td>
                                        <td class="px-6 py-1 hidden md:table-cell">{{ remesa.nombre_cliente }}</td>
                                        <td class="px-6 py-1 text-center hidden lg:table-cell">{{ remesa.cantidad }}
                                        </td>
                                        <td class="px-6 py-1 text-center hidden xl:table-cell">{{ remesa.moneda }}</td>
                                        <td class="px-6 py-1 text-center hidden xl:table-cell">{{
                                            dayjs(remesa.created_at).format('DD/MM/YYYY')
                                        }}</td>
                                        <td class="px-6 py-1 text-center">
                                            <button
                                                class="text-center bg-green-600 hover:bg-green-800 active:bg-green-900 rounded-full p-1 transition-all duration-300"
                                                @click="close(remesa.id)">
                                                <IconCheck class="text-white font-semibold" />
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination :data="pagination" />
                        </div>
                    </div>
                    <div>
                        <h1 class="font-bold text-2xl text-gray-600">Resumen</h1>
                        <div class="bg-white p-4 mt-4 rounded-lg shadow-lg hover:shadow-none transition-all ease-in-out duration-300">
                            <table class="w-full">
                                <tr v-for="totalMoneda in totalencaja" class="border-b">
                                    <td class="py-4 font-semibold">{{ totalMoneda.nombre }}</td>
                                    <td class="py-4 text-right">{{ totalMoneda.cantidad }}</td>
                                </tr>
                            </table>
                            <div class="w-full my-4">
                                <h2 class="font-semibold text-lg text-gray-800">Dinero pendiente por entregar</h2>
                                <table class="w-full">
                                    <tr v-for="dinero in dineroPendiente" class="border-b">
                                        <td class="py-4 font-semibold">{{ dinero.nombre }}</td>
                                        <td class="py-4 text-right">{{ dinero.cantidad }}</td>
                                    </tr>
                                </table>
                            </div>                      
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
// console.log(remesas)

// const init = () => {
//     console.log(props.remesas)
//     console.log(props.total)
// }

// init()

</script>