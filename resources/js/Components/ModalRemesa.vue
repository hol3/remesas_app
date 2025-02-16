<template>
    <div v-show="modalActive" class="fixed inset-0 flex items-center self-center justify-center bg-gray-700 bg-opacity-50 backdrop-blur-sm">
        <div class="w-[640px] max-w-2xl p-6 bg-white rounded-md shadow-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl uppercase">{{ remesa.codigo }}</h3>
                <IconX :size="24" @click="close"/>
            </div>
            <div class="mt-4">
                <div class="p-2 border rounded-md">
                    <p><span class="font-bold">Factura: </span>{{ remesa.codigo }}</p>
                    <p><span class="font-bold">Cliente: </span>{{ remesa.nombre }}</p>
                    <p><span class="font-bold">Telefono: </span>{{ remesa.telefono }}</p>
                    <p><span class="font-bold">Cantidad: </span>{{ remesa.cantidad }} {{ remesa.moneda.nombre }}</p>
                    <p><span class="font-bold">Provincia/Municipio: </span>{{ remesa.municipio.provincia?.nombre }}/{{ remesa.municipio?.nombre }}</p>
                    <p><span class="font-bold">Direccion: </span>{{ remesa.direccion }}</p>
                    <p><span class="font-bold">Mensajero: </span>{{ remesa.mensajero.nombre }}</p>
                </div>
            </div>
            <div class="flex justify-end p-2 mt-4">
                <PrimaryButton v-if="remesa.estado === 0" @click="copyFunc(remesa)" class="my-2 bg-blue-700 hover:bg-blue-800 active:bg-blue-900"><IconCopy :size="24" :stroke="2" /></PrimaryButton>
                <Link :href="route('remesas.edit', remesa.id)" class="inline-flex items-center px-4 py-2 my-2 ml-2 text-xs font-semibold tracking-widest text-white uppercase bg-blue-600 border border-transparent rounded-md hover:bg-blue-800 active:bg-blue-900"><IconEdit :size="24" :stroke="2" /></Link>
                <PrimaryButton v-if="remesa.estado === 0" @click="eliminarFactura(remesa.id)" class="my-2 ml-2 bg-red-700 hover:bg-red-800 active:bg-red-900"><IconTrash :size="24" :stroke="2" /></PrimaryButton>
                <PrimaryButton v-if="remesa.estado === 0" @click="cerrarFactura(remesa.id)" class="my-2 ml-2 bg-green-600 hover:bg-green-800 active:bg-green-900"><IconCheck :size="24" :stroke="2" /></PrimaryButton>
            </div>
        </div>
    </div>
</template>
<script setup>
import PrimaryButton from './PrimaryButton.vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import relativeTime from "dayjs/plugin/relativeTime";
import { IconCheck, IconEdit, IconTrash, IconX, IconCopy } from '@tabler/icons-vue';
// import { computed } from 'vue';
dayjs.extend(relativeTime)

const emit = defineEmits(['close'])

const props = defineProps({
    modalActive: {
        type: Boolean,
        default: false
    },
    remesa: {
        type: Object,
        default: () => ({})
    }
})

const factura = useForm({
    id: ''
})

const copyFunc = (data) => {
    let fecha = dayjs(data.fecha).format('DD/MM/YYYY')
    let text = 'Factura: ' + data.codigo + '\nFecha: ' + fecha +'\nCliente: ' + data.nombre + '\nTeléfono: ' + data.telefono + '\nCantidad: $' + data.cantidad + ' ' + data.moneda + '\nProvincia/Municipio: ' + data.provincia + '/' + data.municipio + '\nDirección: ' + data.direccion
    navigator.clipboard.writeText(text).then(function (){
        console.log('Async: Copying to clipboard was successful!')
    }, function(err){
        console.error('Async: Could not copy text: ', err)
    })
}

const cerrarFactura = (id) => {
    console.log(id)
    if(confirm("Está seguro de cerrar esta entrega?"))
    {
        factura.id = id
        factura.put(route('remesas.close', id))
        close()
    }
}

const eliminarFactura = (id) => {
    console.log(id)
    if(confirm("Está seguro de eliminar la factura?"))
    {
        factura.id = id
        factura.delete(route('remesas.destroy', id))
        close()
    }
}

const close = () => {
    emit('close')
}

const edit = (id) => {
    route('remesas.edit', id)
}

</script>
