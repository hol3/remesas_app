<template>
    <div :class="classes">
        <div class="p-4 self-center">
            <span class="text-sm text-center text-gray-500 font-semibold">{{ remesa.codigo }}</span>
        </div>
        <div class="grow p-2 self-center">
            <h2 class="text-lg text-gray-700 font-semibold">{{ remesa.nombre_cliente }}</h2>
            <h3 class="text-sm font-medium text-gray-400">{{ remesa.direccion }}</h3>
            <a :href="phone" class="text-cyan-500 underline">{{ remesa.telefono }}</a>
        </div>
        <div class="grid grid-cols-2 md:w-[25%] gap-2 p-2">
            <div class="flex flex-col p-2 bg-gray-200 rounded-lg shadow-md">
                <span class="text-gray-500 text-sm font-semibold">USD: {{ remesa.USD }}</span>
                <span class="text-gray-500 text-sm font-semibold">CUP: {{ remesa.CUP }}</span>
                <span class="text-gray-500 text-sm font-semibold">EUR: {{ remesa.EUR }}</span>
            </div>
            <div class="flex flex-col p-2 bg-violet-500 rounded-lg shadow-md">
                <span class="text-center text-gray-200 font-semibold">Comisión</span>
                <span class="text-center text-white font-semibold">{{ remesa.comision }}</span>
            </div>
        </div>
        
        <div class="flex flex-col p-2 gap-1">
            <Link href="#" class="inline-flex bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                    <path d="M16 5l3 3"></path>
                </svg>
                <span>Editar</span>
            </Link>
            <button @click="entregarFunc" class="inline-flex bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-truck-delivery" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                    <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5"></path>
                    <line x1="3" y1="9" x2="7" y2="9"></line>
                </svg>
                <span>Entregar</span>
            </button>            
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

const props = defineProps({    
    remesa: {
        type: Object,
        default: () => ({})
    },
    active: {
        type: Boolean,
        default: true
    }
})

const classes = computed(() => props.active
    ? 'flex flex-col md:flex-row px-4 justify-between border border-gray-300 rounded-md'
    : 'flex flex-col md:flex-row px-4 justify-between border-l-8 border border-green-300 rounded-md'     
)

const phone = "tel:" + props.remesa.telefono

const entregar = useForm({
    id: props.remesa.id,
    codigo: props.remesa.codigo,
    nombre_cliente: props.remesa.nombre_cliente,
    direccion: props.remesa.direccion,
    telefono: props.remesa.telefono,
    USD: props.remesa.USD,
    CUP: props.remesa.CUP,
    EUR: props.remesa.EUR,
    comision: props.remesa.comision,
    estado: 1,
    mensajero_id: props.remesa.mensajero_id
})

function entregarFunc()
{
    if(confirm("Está seguro de cerrar esta entrega?"))
    {
        console.log(entregar)
        console.log(props.remesa.id)
        entregar.put(route('remesas.update', props.remesa.id))
    }
}
</script>
