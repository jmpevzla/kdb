<template>
  <Head title="Grupos" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="text-xl text-center font-semibold leading-tight text-gray-800">
        Grupos
      </h2>
    </template>

    <div class="py-6">
      <div class="mx-auto w-fit max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div
            class="
              flex flex-col
              items-center
              p-6
              bg-white
              border-b border-gray-200
            "
          >
            <div>
              <div class="mb-4 text-right">
                <Link
                  class="px-6 py-2 mb-2 text-green-100 bg-green-500 rounded"
                  :href="route('grupos.create')"
                >
                  Crear Grupo
                </Link>
              </div>
              <table>
                <thead class="font-bold bg-gray-300 border-b-2">
                  <td class="px-4 py-2">ID</td>
                  <td class="px-4 py-2">Nombre</td>
                  <td class="px-4 py-2">Acción</td>
                </thead>
                <tbody>
                  <tr v-for="grupo in grupos.data" :key="grupo.id">
                    <td class="px-4 py-2">{{ grupo.id }}</td>
                    <td class="px-4 py-2">
                      <Link
                        class="text-blue-700"
                        :href="route('grupos.show', grupo.id)"
                        >{{ grupo.nombre }}</Link
                      >
                    </td>

                    <td class="px-4 py-2 font-extrabold">
                      <Link
                        class="text-green-700"
                        :href="route('grupos.edit', grupo.id)"
                      >
                        Editar
                      </Link>
                      /
                      <Link @click="destroy(grupo.id)" class="text-red-700"
                        >Borrar</Link
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
              <pagination
                class="flex justify-center mt-4"
                :links="grupos.links"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import Pagination from "@/Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { toRefs } from "vue";

const props = defineProps({
  grupos: Object,
});
const { grupos } = toRefs(props);

const destroy = (id) => {
  Inertia.delete(route("grupos.destroy", id));
};
</script>
