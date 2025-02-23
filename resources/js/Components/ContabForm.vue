<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import PrimaryButton from "./PrimaryButton.vue";

const props = defineProps({
    efectivo: Object,
    monedas: Object,
    estados: Object,
});

const form = useForm({
    cantidad: "",
    moneda_id: "",
    concepto: "",
    nota: "",
});

const emit = defineEmits(["close"]);

const submit = () => {
    console.log(form);
    form.post(route("contabilidad.store"));
    form.reset();
    emit("close");
};
</script>
<template>
    <form @submit.prevent="submit" class="grid grid-cols-2 gap-2">
        <div class="mt-2">
            <InputLabel for="cantidad" value="Cantidad" />
            <TextInput
                id="cantidad"
                v-model="form.cantidad"
                type="number"
                step="0.01"
                required
                class="block w-full mt-1"
            />
        </div>
        <div class="mt-2">
            <InputLabel for="monedas" value="Moneda" />
            <select
                id="monedas"
                v-model="form.moneda_id"
                required
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
                <option v-for="moneda in monedas" v-bind:value="moneda.id">
                    {{ moneda.nombre }}
                </option>
            </select>
        </div>
        <div class="col-span-2 mt-2">
            <InputLabel for="tipo" value="Entrada/Salida" />
            <select
                id="tipo"
                v-model="form.concepto"
                required
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
                <option v-for="estado in estados" v-bind:value="estado">
                    {{ estado }}
                </option>
            </select>
        </div>
        <div class="col-span-2 mt-2">
            <InputLabel for="nota" value="Nota" />
            <TextInput
                id="nota"
                v-model="form.nota"
                type="text"
                required
                class="block w-full mt-1"
            />
        </div>
        <div class="col-span-2 mt-4">
            <div class="flex justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    >Guardar
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>
