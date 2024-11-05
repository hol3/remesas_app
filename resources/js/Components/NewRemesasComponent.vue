<template>
    <div class="p-6">
        <table class="w-full my-4 text-sm text-left text-gray-500 dark:text-gray-200">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-200 bg-gray-50 dark:bg-slate-700">
                <tr>
                    <th class="px-6 py-3 text-center">Factura</th>
                    <th class="hidden px-6 py-3 text-center sm:table-cell">Nombre</th>
                    <th class="hidden px-6 py-3 text-center sm:table-cell">Cantidad</th>
                    <th class="hidden px-6 py-3 text-center sm:table-cell">Moneda</th>
                    <th class="hidden px-6 py-3 text-center sm:table-cell">Comisión</th>
                    <th class="hidden px-6 py-3 text-center md:table-cell">Mensajero</th>
                    <th class="hidden px-6 py-3 text-center lg:table-cell">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="remesa in remesas" :key="remesa.id"
                    class="border-b dark:border-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800"
                    @click="showRemesa(remesa)">
                    <td v-if="remesa.estado === 1"
                        class="px-6 py-4 font-medium text-gray-900 uppercase border-l-4 border-green-300 dark:text-gray-200 whitespace-nowrap">
                        {{ remesa.codigo }}
                    </td>
                    <td v-else class="px-6 py-4 font-medium text-gray-900 uppercase dark:text-gray-200 whitespace-nowrap">
                        {{ remesa.codigo }}
                    </td>
                    <td class="hidden px-6 py-4 sm:table-cell">{{ remesa.nombre_cliente }}</td>
                    <td class="hidden px-6 py-4 text-center sm:table-cell">{{ remesa.cantidad }}
                    </td>
                    <td class="hidden px-6 py-4 text-center sm:table-cell">{{ remesa.moneda }}</td>
                    <td class="hidden px-6 py-4 text-center sm:table-cell">{{ remesa.comision }}</td>
                    <td class="hidden px-6 py-4 text-center sm:table-cell">{{ remesa.mensajero }}</td>
                    <td class="hidden px-6 py-4 text-center lg:table-cell">{{
                        dayjs(remesa.created_at).format('DD/MM/YYYY')
                    }}</td>
                </tr>
            </tbody>
        </table>
        <div v-if="loading">
            Cargando mas facturas
        </div>
        <!-- <Pagination :data="pagination" /> -->
    </div>
    <ModalRemesa @close="showModal" :modal-active="modalActive" :remesa="remesa" />
</template>
<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import dayjs from 'dayjs';
import ModalRemesa from './ModalRemesa.vue';
import axios from 'axios';
// import Pagination from './Pagination.vue';
// import axios from 'axios';

const props = defineProps(['url'])

const remesas = ref([]);
const loading = ref(false);

let page = ref(1);
// let observer;

const fetchRemesas = async () => {
    loading.value = true;
    try {
        const response = await axios.get(`${props.url}?page=${page.value}`);
        if(response.data != null) {
            remesas.value.push(...response.data);
            console.log(remesas.value);
            page.value++;
        }
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
}

const handleScroll = () => {
    const scrollableHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrolledFromTop = window.scrollY;

    if(scrollableHeight - scrolledFromTop < 100 && !loading.value) {
        fetchRemesas()
    }
}

onMounted(() => {
    fetchRemesas();
    window.addEventListener('scroll', handleScroll);
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll);
});

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