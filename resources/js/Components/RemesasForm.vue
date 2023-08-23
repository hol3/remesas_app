<template>
    <div v-show="formActive" class="fixed inset-0 flex items-center self-center justify-center bg-gray-700 bg-opacity-50 backdrop-blur-sm">
        <div class="w-[640px] max-w-2xl h-4/5 overflow-auto lg:h-auto bg-white rounded-md shadow-sm p-4">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl mr-6">Nueva Entrega</h3>
                <IconX @click="close"/>
            </div>
            <form @submit.prevent="submit" class="grid grid-cols-2 gap-2">
                <div class="mt-2 col-span-2">
                    <InputLabel for="codigo" value="Codigo:" />
                    <TextInput id="codigo" type="text" class="mt-1 block w-full" v-model="form.codigo" required autofocus
                        onkeyup="this.value = this.value.toUpperCase();" />
                    <InputError class="mt-2" :message="form.errors.codigo" />
                </div>
                <div class="mt-2">
                    <InputLabel for="nombre_cliente" value="Nombre del cliente:" />
                    <TextInput id="nombre_cliente" type="text" class="mt-1 block w-full" v-model="form.nombre_cliente"
                        required autocomplete="nombre_cliente" />
                    <InputError class="mt-2" :message="form.errors.nombre_cliente" />
                </div>
                <div class="mt-2">
                    <InputLabel for="telefono" value="Telefono:" />
                    <TextInput id="telefono" type="tel" class="mt-1 block w-full" v-model="form.telefono" />
                    <InputError class="mt-2" :message="form.errors.direccion" />
                </div>
                <div class="mt-2">
                    <InputLabel for="cantidad" value="Cantidad:" />
                    <TextInput id="cantidad" type="number" step="0.01" required class="mt-1 block w-full" v-model="form.cantidad" />
                    <InputError class="mt-2" :message="form.errors.cantidad" />
                </div>
                <div class="mt-2">
                    <InputLabel for="monedas" value="Tipo de moneda" />
                    <select v-model="form.moneda_id" id="monedas" required
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option v-for="moneda in monedas" v-bind:value="moneda.id">{{
                            moneda.nombre
                        }}</option>
                    </select>
                </div>
                <div class="mt-2 col-span-2">
                    <InputLabel for="comision" value="Comision:" />
                    <TextInput id="comision" type="number" class="mt-1 block w-full" step="0.01" v-model="form.comision" required />
                    <InputError class="mt-2" :message="form.errors.comision" />
                </div>
                <div class="mt-2 col-span-2">
                    <InputLabel for="municipios" value="Municipio" />
                    <select v-model="form.municipio_id" id="municipios" required
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value=""></option>
                        <option v-for="municipio in props.provincias[0].municipio" v-bind:value="municipio.id">{{
                            municipio.nombre
                        }}</option>
                    </select>
                </div>
                <div class="mt-2 col-span-2">
                    <InputLabel for="direccion" value="Direccion:" />
                    <TextInput id="direccion" type="text" class="mt-1 block w-full" v-model="form.direccion" />
                    <InputError class="mt-2" :message="form.errors.direccion" />
                </div>
                <div class="mt-2 col-span-2">
                    <InputLabel for="mensajero" value="Mensajero:" />
                    <select v-model="form.mensajero_id" id="mensajero" required
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="">Seleccione un mensajero</option>
                        <option v-for="mensajero in props.mensajeros" v-bind:value="mensajero.id">{{ mensajero.nombre }}
                        </option>
                    </select>
                </div>
                <div class="mt-4 col-span-2">
                    <div class="flex justify-end">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar
                        </PrimaryButton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { IconX } from '@tabler/icons-vue'
import InputLabel from './InputLabel.vue';
import TextInput from './TextInput.vue';
import InputError from './InputError.vue';
import PrimaryButton from './PrimaryButton.vue';

const props = defineProps({
    formActive: {
        type: Boolean,
        default: false
    },
    provincias: null,
    monedas: null,
    mensajeros: null,
})

const emit = defineEmits(['close'])

const form = useForm({
    codigo: '',
    nombre_cliente: '',
    telefono: '',
    direccion: '',
    municipio_id: '',
    cantidad: '',
    moneda_id: '',
    comision: '',
    mensajero_id: '',
})

const parseData = (data) => {

    let factura = data.match(/Factura:\s(.+?)\./)[1];
    let fecha = data.match(/Fecha:\s(.+?)\./)[1];
    let nombre = data.match(/Nombre:\s(.+?)\./)[1];
    let telefono = data.match(/Teléfono:\s(.+?)\./)[1];
    let valor = data.match(/Valor:\s(.+?)\./)[1];
    let comision = data.match(/Comisión:\s(.+?)\./)[1];
    let bono = data.match(/Bono:\s(.+?)\./)[1];
    let localidad = data.match(/Localidad:\s(.+?)\./)[1];
    let direccion = data.match(/Dirección:\s(.+?)\./)[1];
    let puntoDeReferencia = data.match(/Punto de Referencia:\s(.+?)\./)[1];
    let url = data.match(/URL:\s(.+)/)[1];

    //get currency
    let [value, currency] = valor.match(/([\d.,]+)\s(.+)/).slice(1);

    //get municipio
    let [provincia, municipio] = localidad.split(" / ");
}

const submit = () => {
    // console.log('Acabo de envier el formulario!!')    
    // console.log(form)
    form.post(route('remesas.store'))
    form.reset()
    close()
}

const close = () => {
    emit('close')
}

</script>