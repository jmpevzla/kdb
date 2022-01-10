<template>
    <Head title="Links" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Crear un Link
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto w-fit max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-2">
                                <label for="descInput">Descripcion</label>
                                <input
                                    id="descInput"
                                    type="text"
                                    required
                                    v-model="form.descripcion"
                                    class="
                                        w-full
                                        px-4
                                        py-2
                                        mt-2
                                        border
                                        rounded-md
                                        focus:outline-none
                                        focus:ring-1
                                        focus:ring-blue-600
                                    "
                                />
                            </div>
                            <div class="mb-2">
                                <label for="tipoLinkSelect">Tipo de Link</label>
                                <select
                                  id="tipoLinkSelect"
                                  required
                                  class="
                                    w-full
                                    px-4
                                    py-2
                                    mt-2
                                    border
                                    rounded-md
                                    focus:outline-none
                                    focus:ring-1
                                    focus:ring-blue-600
                                  "
                                  v-model="form['tipo-link_id']">

                                  <option v-for="tipo of tiposLinks"
                                    :key="tipo.id"
                                    :value="tipo.id">{{ tipo.descripcion }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="linkInput">Link</label>
                                <input
                                    id="linkInput"
                                    type="url"
                                    required
                                    v-model="form.link"
                                    class="
                                        w-full
                                        px-4
                                        py-2
                                        mt-2
                                        border
                                        rounded-md
                                        focus:outline-none
                                        focus:ring-1
                                        focus:ring-blue-600
                                    "
                                />
                            </div>
                            <!-- submit -->
                            <div class="flex items-center mt-4">
                                <button
                                    class="
                                        px-6
                                        py-2
                                        text-white
                                        bg-gray-900
                                        rounded
                                    "
                                >
                                    Crear
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import { toRefs } from "vue";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
  tiposLinks: Array
})

const { tiposLinks } = toRefs(props)

const form = useForm({
  descripcion: null,
  link: null,
  'tipo-link_id': null
});

const submit = () => {
  form.post(route("links.store"));
}

</script>
