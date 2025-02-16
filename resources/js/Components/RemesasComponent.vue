<template>
    <div class="p-6">
        <table class="w-full my-4 text-sm text-left text-gray-500 dark:text-gray-200">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-200 bg-gray-50 dark:bg-slate-700">
                <tr>
                    <th class="px-6 py-3 text-center">Factura</th>
                    <th class="px-6 py-3 text-center">Detalles</th>
                    <th class="hidden px-6 py-3 text-center md:table-cell">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="remesa in props.remesas.data" :key="remesa.id"
                    class="border-b dark:border-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <td :class="(estado =
                        remesa.estado == 1
                            ? 'px-6 py-4 border-l-4 w-4/12 border-green-300 table-cell'
                            : 'px-6 py-4 table-cell w-4/12')
                        " @click="showRemesa(remesa)">
                        <p>
                            <span class="font-bold">Factura: </span><span class="uppercase">{{ remesa.codigo }}</span>
                        </p>
                        <p>
                            <span class="font-bold">Fecha: </span>{{
                                dayjs(remesa.created_at).format("DD MMM YYYY")
                            }}
                        </p>
                        <p>
                            <span class="font-bold">Nombre: </span>{{ remesa.nombre_cliente }}
                        </p>
                    </td>
                    <td class="w-6/12">
                        <p>
                            <span class="font-bold">Cantidad: </span>{{ remesa.cantidad + " " + remesa.moneda.nombre }}
                        </p>
                        <p>
                            <span class="font-bold">Comisión: </span>{{
                                (comision =
                                    remesa.mensajero.comision <= 0 ? remesa.comision : remesa.mensajero.comision) }} </p>
                                <p>
                                    <span class="font-bold">Mensajero: </span>{{ remesa.mensajero.nombre }}
                                </p>
                    </td>
                    <td class="hidden px-6 py-4 text-center sm:table-cell">
                        <Dropdown>
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                                        Acción

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </template>
                            <template #content>
                                <DropdownLink @click.prevent="showRemesa(remesa)" as="button" preserve-state preserve-scroll>
                                    Ver Factura
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :data="pagination" />
    </div>
    <ModalRemesa @close="showModal" :modal-active="modalActive" :remesa="remesa" />
</template>
<script setup>
import { ref } from "vue";
import dayjs from "dayjs";
import ModalRemesa from "./ModalRemesa.vue";
import Pagination from "./Pagination.vue";
import Dropdown from "./Dropdown.vue";
import DropdownLink from "./DropdownLink.vue";
import { IconEye, IconTrash } from "@tabler/icons-vue";

const props = defineProps({
    remesas: {
        type: Object,
        default: () => ({}),
    },
    pagination: {
        type: Object,
        default: () => ({}),
    },
});

const remesa = {
    id: "",
    fecha: "",
    codigo: "",
    nombre: "",
    telefono: "",
    direccion: "",
    provincia: "",
    municipio: "",
    cantidad: "",
    moneda: "",
    mensajero: "",
    estado: "",
};

const modalActive = ref(false);
const comision = ref(0);

const showRemesa = (data) => {
    remesa.id = data.id;
    remesa.fecha = data.created_at;
    remesa.codigo = data.codigo;
    remesa.nombre = data.nombre_cliente;
    remesa.telefono = data.telefono;
    remesa.provincia = data.provincia;
    remesa.municipio = data.municipio;
    remesa.direccion = data.direccion;
    remesa.cantidad = data.cantidad;
    remesa.moneda = data.moneda;
    remesa.mensajero = data.mensajero;
    remesa.estado = data.estado;

    console.log(data);
    showModal();
};

const showModal = () => {
    // remesa = data
    modalActive.value = !modalActive.value;
    // console.log(remesa)
};
</script>
