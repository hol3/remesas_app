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
                        (remesa.estado == 'completado')
                            ? 'px-6 py-4 border-l-4 border-green-300 table-cell' :
                            (remesa.estado == 'enviado')
                            ? 'px-6 py-4 border-l-4 border-orange-300 table-cell'
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
                            <Link :href="route('remesas.show', remesa.id)"><EyeIcon class="size-6 hover:text-blue-500" /></Link>
                            <button v-if="remesa.estado !== 'completado'" @click="copyFunc(remesa)"><DocumentDuplicateIcon class="size-6 hover:text-blue-500" /></button>
                            <button v-if="remesa.estado == 'pendiente' || remesa.estado == 'enviado'" @click="completarFactura(remesa)"><CheckIcon class="size-6 hover:text-blue-500" /></button>
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
// import { ref } from "vue";
import dayjs from "dayjs";
import { Link, useForm } from "@inertiajs/inertia-vue3";
// import ModalRemesa from "./ModalRemesa.vue";
import Pagination from "./Pagination.vue";
import { CheckIcon, DocumentDuplicateIcon, EyeIcon } from "@heroicons/vue/24/outline";

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

const copyFunc = (data) => {
    let fecha = dayjs(data.fecha).format('DD/MM/YYYY')
    let text = 'Factura: ' + data.codigo + '\nFecha: ' + fecha +'\nCliente: ' + data.nombre_cliente +
                '\nTeléfono: ' + data.telefono + '\nCantidad: $' + data.cantidad + ' ' + data.moneda.nombre +
                '\nLocalidad: ' + data.localidad + '\nDirección: ' + data.direccion + '\nReferancia: ' + data.referencia;
    navigator.clipboard.writeText(text).then(function (){
        console.log('Async: Copying to clipboard was successful!');
        factura.id = data.id;
        factura.put(route('remesas.enviar', data.id), { preserveScroll: true});
    }, function(err){
        console.error('Async: Could not copy text: ', err);
    });
}

const factura = useForm({
    id: ''
});

const completarFactura = (remesa) => {
    if(confirm("Está seguro de cerrar la factura?"))
    {
        factura.id = remesa.id;
        factura.put(route('remesas.close', remesa), {preserveScroll: true});
    }
}

const borrarFactura = (remesa) => {
    if(confirm("Está seguro de eliminar la factura?"))
    {
        // console.log(remesa);
        factura.id = remesa.id;
        factura.delete(route('remesas.destroy', remesa));
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
