<template>
    <div v-show="modalActive" class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
        <div class="w-[640px] max-w-2xl p-6 bg-white rounded-md shadow-xl">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl uppercase">{{ remesa.codigo }}</h3>
                <IconX @click="close"/>
            </div>
            <div class="mt-4">
                <div class="border rounded-md p-2">
                    <p><span class="font-bold">Factura: </span>{{ remesa.codigo }}</p>
                    <p><span class="font-bold">Cliente: </span>{{ remesa.nombre }}</p>
                    <p><span class="font-bold">Telefono: </span>{{ remesa.telefono }}</p>
                    <p><span class="font-bold">Cantidad: </span>{{ remesa.cantidad }} {{ remesa.moneda }}</p> 
                    <p><span class="font-bold">Provincia/Municipio: </span>{{ remesa.provincia }}/{{ remesa.municipio }}</p>
                    <p><span class="font-bold">Direccion: </span>{{ remesa.direccion }}</p>   
                    <p><span class="font-bold">Mensajero: </span>{{ remesa.mensajero }}</p>   
                </div>                                                            
            </div>
            <div class="mt-4 p-2 flex justify-end">
                <PrimaryButton v-if="remesa.estado === 0" @click="copyFunc(remesa)" class="bg-blue-700 hover:bg-blue-800 active:bg-blue-900 my-2"><IconCopy /></PrimaryButton>
                <Link :href="route('remesas.edit', remesa.id)" class="inline-flex items-center ml-2 px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest my-2 bg-blue-600 hover:bg-blue-800 active:bg-blue-900"><IconEdit /></Link>                
                <PrimaryButton v-if="remesa.estado === 0" class="bg-red-700 hover:bg-red-800 active:bg-red-900 ml-2 my-2"><IconTrash /></PrimaryButton>                
                <PrimaryButton v-if="remesa.estado === 0" @click="cerrarFactura(remesa.id)" class="bg-green-600 hover:bg-green-800 active:bg-green-900 ml-2 my-2"><IconCheck /></PrimaryButton>
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

const close = () => {
    emit('close')
}

const edit = (id) => {
    route('remesas.edit', id)
}

</script>