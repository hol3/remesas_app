<template>
    <Head title="Editar" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ item.nombre_cliente }}
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="grid grid-cols-2 gap-2 px-8">
                        <div class="col-span-2 mt-4">
                            <InputLabel for="codigo" value="Codigo:" />
                            <TextInput id="codigo" type="text" class="block w-full mt-1" v-model="form.codigo" required
                                autofocus onkeyup="this.value = this.value.toUpperCase();" />
                            <InputError class="mt-2" :message="form.errors.codigo" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="nombre_cliente" value="Nombre del cliente:" />
                            <TextInput id="nombre_cliente" type="text" class="block w-full mt-1"
                                v-model="form.nombre_cliente" required autocomplete="nombre_cliente" />
                            <InputError class="mt-2" :message="form.errors.nombre_cliente" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="telefono" value="Telefono:" />
                            <TextInput id="telefono" type="tel" class="block w-full mt-1" v-model="form.telefono" />
                            <InputError class="mt-2" :message="form.errors.direccion" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="cantidad" value="Cantidad:" />
                            <TextInput id="cantidad" type="number" class="block w-full mt-1" v-model="form.cantidad" />
                            <InputError class="mt-2" :message="form.errors.cantidad" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="monedas" value="Moneda" />
                            <select v-model="form.moneda_id" id="monedas"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option v-for="moneda in monedas" v-bind:value="moneda.id">{{
                                    moneda.nombre
                                }}</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <InputLabel for="comision" value="Comision:" />
                            <TextInput id="comision" type="number" class="block w-full mt-1" v-model="form.comision"
                                required />
                            <InputError class="mt-2" :message="form.errors.comision" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="monedas" value="Moneda" />
                            <select v-model="form.moneda_comision" id="monedas"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option v-for="moneda in monedas" v-bind:value="moneda.id">{{
                                    moneda.nombre
                                }}</option>
                            </select>
                        </div>
                        <div class="col-span-2 mt-4">
                            <InputLabel for="localidad" value="Localidad:" />
                            <TextInput id="localidad" type="text" class="block w-full mt-1" v-model="form.localidad" />
                            <InputError class="mt-2" :message="form.errors.direccion" />
                        </div>
                        <div class="col-span-2 mt-4">
                            <InputLabel for="direccion" value="Direccion:" />
                            <TextInput id="direccion" type="text" class="block w-full mt-1" v-model="form.direccion" />
                            <InputError class="mt-2" :message="form.errors.direccion" />
                        </div>
                        <div class="col-span-2 mt-4">
                            <InputLabel for="mensajero" value="Mensajero:" />
                            <select v-model="form.mensajero_id" id="mensajero"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Seleccione un mensajero</option>
                                <option v-for="mensajero in mensajeros" v-bind:value="mensajero.id">{{
                                    mensajero.nombre
                                }}</option>
                            </select>
                        </div>
                        <div class="col-span-2 mt-4">
                            <InputLabel for="estado" value="Estado:" />
                            <select v-model="form.estado" id="mensajero"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Seleccione un mensajero</option>
                                <option v-for="estado in estados" v-bind:value="estado">{{
                                    estado
                                }}</option>
                            </select>
                        </div>
                        <div class="flex justify-end col-span-2 mt-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Guardar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '../../Components/InputLabel.vue';
import TextInput from '../../Components/TextInput.vue';
import InputError from '../../Components/InputError.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';

const props = defineProps({
    item: {
        type: Object,
        default: ({})
    },
    estados: Object,
    monedas: null,
    mensajeros: null,
})

console.log(props.estados);

const form = useForm({
    id: props.item.id,
    codigo: props.item.codigo,
    nombre_cliente: props.item.nombre_cliente,
    telefono: props.item.telefono,
    direccion: props.item.direccion,
    localidad: props.item.localidad,
    cantidad: props.item.cantidad,
    moneda_id: props.item.moneda_id,
    comision: props.item.comision,
    moneda_comision: props.item.comision_moneda_id,
    mensajero_id: props.item.mensajero_id,
    estado: props.item.estado,
})

const submit = () => {
    // console.log('Acabo de envier el formulario!!')
    // console.log(form)
    form.put(route('remesas.update', props.item.id))
    // form.reset()
    // close()
}

</script>
