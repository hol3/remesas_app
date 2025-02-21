<template>
    <div class="p-6">
        <table class="w-full my-4 text-sm text-left text-gray-500 dark:text-gray-200">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-200 bg-gray-50 dark:bg-slate-700">
                <tr>
                    <th class="px-6 py-3 text-center">Factura</th>
                    <th class="px-6 py-3 text-center">Nombre</th>
                    <th class="hidden px-6 py-3 text-center sm:table-cell">Cantidad</th>
                    <th class="hidden px-6 py-3 text-center sm:table-cell">Mensajero</th>
                    <th class="hidden px-6 py-3 text-center sm:table-cell">Fecha</th>
                    <th class="table-cell px-6 py-3 text-center ">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="remesa in props.remesas.data" :key="remesa.id"
                    class="border-b dark:border-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <td :class="(estado =
                        remesa.estado == 1
                            ? 'px-6 py-4 border-l-4 border-green-300 table-cell'
                            : 'px-6 py-4 table-cell')
                        ">
                        <span class="font-bold uppercase">{{ remesa.codigo }}</span>
                    </td>
                    <td class="table-cell">
                        {{ remesa.nombre_cliente }}
                    </td>
                    <td class="hidden px-6 py-4 text-center sm:table-cell">
                        {{ remesa.cantidad + " " + remesa.moneda.nombre }}
                    </td>
                    <td class="hidden px-6 py-4 text-center sm:table-cell">
                        {{ remesa.mensajero.nombre }}
                    </td>
                    <td class="hidden px-6 py-4 text-center sm:table-cell">
                        {{ dayjs(remesa.created_at).format("DD MMM YYYY") }}
                    </td>
                    <td class="px-6 py-4 text-center sm:table-cell">
                        <div class="flex justify-center gap-1">
                            <Link :href="route('remesas.show', remesa.id)"><EyeIcon class="size-6" /></Link>
                            <Link><DocumentDuplicateIcon class="size-6" /></Link>
                            <Link><PencilSquareIcon class="size-6" /></Link>
                            <button @click="borrarFactura(remesa.id)"><TrashIcon class="size-6" /></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :data="pagination" />
    </div>
    <!-- <ModalRemesa @close="showModal" :modal-active="modalActive" :remesa="remesa" /> -->
</template>
<script setup>
import { ref } from "vue";
import dayjs from "dayjs";
import { Link, useForm } from "@inertiajs/inertia-vue3";
// import ModalRemesa from "./ModalRemesa.vue";
import Pagination from "./Pagination.vue";
import { DocumentDuplicateIcon, EyeIcon, PencilSquareIcon, TrashIcon } from "@heroicons/vue/24/outline";

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

const factura = useForm({
    id: ''
})

const borrarFactura = (id) => {
    if(confirm("Está seguro de eliminar la factura?"))
    {
        console.log(id);
        factura.id = id
        factura.delete(route('remesas.destroy', id));
    }
}

// const remesa = {
//     id: "",
//     fecha: "",
//     codigo: "",
//     nombre: "",
//     telefono: "",
//     localidad: "",
//     direccion: "",
//     cantidad: "",
//     moneda: "",
//     mensajero: "",
//     estado: "",
// };

// const modalActive = ref(false);
// const comision = ref(0);

// const showRemesa = (data) => {
//     remesa.id = data.id;
//     remesa.fecha = data.created_at;
//     remesa.codigo = data.codigo;
//     remesa.nombre = data.nombre_cliente;
//     remesa.telefono = data.telefono;
//     remesa.provincia = data.provincia;
//     remesa.municipio = data.municipio;
//     remesa.direccion = data.direccion;
//     remesa.cantidad = data.cantidad;
//     remesa.moneda = data.moneda;
//     remesa.mensajero = data.mensajero;
//     remesa.estado = data.estado;

//     console.log(data);
//     showModal();
// };

// const showModal = () => {
//     // remesa = data
//     modalActive.value = !modalActive.value;
//     // console.log(remesa)
// };
</script>
