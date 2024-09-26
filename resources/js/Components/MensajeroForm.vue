<template>
    <div v-show="modalActive" class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
        <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
            <div class="flex items-center justify-between">
                <h3 class="mr-6 text-2xl">Nuevo mensajero</h3>
                <Link :size="24" @click="close">
                    <IconX />
                </Link>
            </div>
            <div>
                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <InputLabel for="nombre" value="Nombre:" />
                        <TextInput id="nombre" type="text" class="block w-full mt-1" placeholder="ej: John Smith" required v-model="form.nombre" />
                        <InputError class="mt-2" :message="form.errors.nombre" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="telefono" value="Teléfono:" />
                        <TextInput id="telefono" type="tel" class="block w-full mt-1" required v-model="form.telefono" />
                        <InputError class="mt-2" :message="form.errors.telefono" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="comision" value="Comisión:" />
                        <TextInput id="comision" type="number" class="block w-full mt-1" placeholder="0.00" v-model="form.comision" />
                        <InputError class="mt-2" :message="form.errors.salario" />
                    </div>
                    <div class="flex mt-4">
                        <input type="checkbox" class="w-6 h-6 rounded-full shadow" name="tiene_efectivo" id="tiene_efectivo" v-model="form.tiene_efectivo">
                        <InputLabel for="tiene_efectivo" class="flex flex-col justify-center px-2" value="Tiene efectivo?" />
                    </div>
                    <div class="flex justify-end mt-4">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit">Guardar</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useForm, Link } from '@inertiajs/inertia-vue3';
import InputLabel from './InputLabel.vue';
import TextInput from './TextInput.vue';
import InputError from './InputError.vue';
import PrimaryButton from './PrimaryButton.vue';
import { IconX } from '@tabler/icons-vue'

const props = defineProps({
    modalActive: {
        type: Boolean,
        default: false
    },
    profile: {
        type: Object,
        default: ({})
    }
})

const form = useForm({
    nombre: props.profile.nombre,
    telefono: props.profile.telefono,
    comision: props.profile.comision,
    tiene_efectivo: props.profile.tiene_efectivo,
})

const emit = defineEmits(['close'])

const submit = () => {
    console.log("Hola Mundo!!")
    form.post(route("mensajeros.store"))
    close()
}

const close = () => {
    emit('close')
}
</script>
