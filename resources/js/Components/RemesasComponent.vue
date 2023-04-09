<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <table class="w-full text-sm text-left text-gray-500 my-4">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center">Factura</th>
                        <th class="px-6 py-3 text-center hidden sm:table-cell">Nombre</th>
                        <th class="px-6 py-3 text-center hidden sm:table-cell">Cantidad</th>
                        <th class="px-6 py-3 text-center hidden sm:table-cell">Moneda</th>
                        <th class="px-6 py-3 text-center hidden sm:table-cell">Comisión</th>
                        <th class="px-6 py-3 text-center hidden md:table-cell">Mensajero</th>
                        <th class="px-6 py-3 text-center hidden lg:table-cell">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="remesa in props.remesas" :key="remesa.id" class="border-b hover:bg-gray-100"
                        @click="showRemesa(remesa)">
                        <td v-if="remesa.estado === 1"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap border-l-4 border-green-300">
                            {{ remesa.codigo }}
                        </td>
                        <td v-else class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ remesa.codigo }}
                        </td>
                        <td class="px-6 py-4 hidden sm:table-cell">{{ remesa.nombre_cliente }}</td>
                        <td class="px-6 py-4 text-center hidden sm:table-cell">{{ remesa.cantidad }}
                        </td>
                        <td class="px-6 py-4 text-center hidden sm:table-cell">{{ remesa.moneda }}</td>
                        <td class="px-6 py-4 text-center hidden sm:table-cell">{{ remesa.comision }}</td>
                        <td class="px-6 py-4 text-center hidden sm:table-cell">{{ remesa.mensajero }}</td>
                        <td class="px-6 py-4 text-center hidden lg:table-cell">{{
                            dayjs(remesa.updated_at).format('DD/MM/YYYY')
                        }}</td>
                    </tr>
                </tbody>
            </table>
            <Pagination :data="pagination" />
        </div>
    </div>
    <ModalRemesa @close="showModal" :modal-active="modalActive" :remesa="remesa"/>
</template>
<script setup>
import { ref } from 'vue';
import dayjs from 'dayjs';
import ModalRemesa from './ModalRemesa.vue';
import Pagination from './Pagination.vue';

const props = defineProps({
    remesas: {
        type: Object,
        default: () => ({})
    },    
    pagination: {
        type: Object,
        default: () => ({})
    },
})

const remesa = {
    id: '',
    fecha: '',
    codigo: '',
    nombre: '',
    telefono: '',
    direccion: '',
    provincia: '',
    municipio: '',
    cantidad: '',
    moneda: '',
    mensajero: '',
    estado: '',
}

const modalActive = ref(false)

const showRemesa = (data) => {
    remesa.id = data.id
    remesa.fecha = data.created_at
    remesa.codigo = data.codigo
    remesa.nombre = data.nombre_cliente
    remesa.telefono = data.telefono
    remesa.provincia = data.provincia
    remesa.municipio = data.municipio
    remesa.direccion = data.direccion
    remesa.cantidad = data.cantidad
    remesa.moneda = data.moneda
    remesa.mensajero = data.mensajero
    remesa.estado = data.estado  
    console.log(data)
    showModal()
}

const showModal = () => {
    // remesa = data
    modalActive.value = !modalActive.value
    // console.log(remesa)
}
</script>