<template>
  <Head title="Personas" />

  <breeze-authenticated-layout>
    <template #header>
      <h2 class="text-xl text-center font-semibold leading-tight text-gray-800">
        Personas
      </h2>
    </template>

    <div class="py-6">
      <div class="mx-auto w-full lg:w-[50rem] sm:px-6 lg:px-8">
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
            <div class="w-full">
              <div class="mb-4 text-right">
                <Link
                  class="px-6 py-2 mb-2 text-green-100 bg-green-500 rounded"
                  :href="route('personas.create')"
                >
                  Crear Persona
                </Link>
              </div>

              <div class="mb-2">
                <breeze-input id="search" type="search"
                  class="block w-full" autofocus
                  v-model="params.search"
                  placeholder="Buscar"
                />
              </div>

              <table class="w-full">
                <thead class="font-bold bg-gray-300 border-b-2">
                  <td class="px-4 py-2">
                    <header-table-sort title="ID" field="id"
                      :params="params" @click="sort('id')" />
                  </td>
                  <td class="px-4 py-2">
                    <header-table-sort title="Nombre" field="nombre"
                      :params="params" @click="sort('nombre')" />
                  </td>
                  <td class="px-4 py-2">Bio</td>
                  <td class="px-4 py-2">Acción</td>
                </thead>
                <tbody>
                  <tr v-for="persona in personas.data" :key="persona.id">
                    <td class="px-4 py-2">{{ persona.id }}</td>
                    <td class="px-4 py-2">
                      <Link
                        class="text-blue-700"
                        :href="route('personas.show', persona.id)"
                        >{{ persona.nombre }}</Link
                      >
                    </td>
                    <td class="px-4 py-2">
                      <span class="block text-ellipsis w-24 overflow-hidden whitespace-nowrap"
                        :title="persona.bio">{{ persona.bio }}</span>
                    </td>
                    <td class="px-4 py-2 font-extrabold">
                      <Link
                        class="text-green-700"
                        :href="route('personas.edit', persona.id)"
                      >
                        Editar
                      </Link>
                      /
                      <Link :preserveState="true" :preserveScroll="true"
                        @click="doConfirmDeleteVisible(persona.id, persona.nombre)" class="text-red-700"
                        >Borrar</Link
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
              <pagination-links
                class="flex justify-center mt-4"
                :links="personas.links"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal-confirm
      v-show="isConfirmDeleteVisible"
      :modal-title="`¿Borrar a ${confirmDeleteName}?`"
      confirm-message="¿Esta seguro de borrar a la persona?"
      @confirm-event="confirmDelete"
      @close-event="cancelDelete"
    />
  </breeze-authenticated-layout>
</template>

<script setup>
import { reactive, toRefs, watch } from "vue"
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue"
import BreezeInput from "@/Components/Input.vue"
import PaginationLinks from "@/Components/PaginationLinks.vue"
import { Inertia } from "@inertiajs/inertia"
import { Head, Link } from "@inertiajs/inertia-vue3"
import { pickBy, throttle } from "lodash"
import { destroyComps } from "@/Composables/generic"
import HeaderTableSort from '@/Components/HeaderTableSort.vue'
import ModalConfirm from "@/Components/ModalConfirm.vue"

const props = defineProps({
  personas: {
    type: Object,
    required: true
  },
  filters: Object
})
const { personas, filters } = toRefs(props)
const { search, field, direction } = filters.value

const params = reactive({
  search,
  field,
  direction
})

watch(params, throttle(() => {
  Inertia.get(route('personas.index'), pickBy({ ...params }, (value) => value), {
    replace: true,
    preserveState: true,
    preserveScroll: true
  })
}, {
  deep: true
}, 500))

const sort = (field) => {

  if (params.field !== field) {
    params.field = field
    params.direction = 'asc'
    return
  }

  if (params.direction === 'desc') {
    params.direction = null
    params.field = null
    return
  }

  if(params.direction === 'asc') {
    params.direction = 'desc'
    return
  }

  params.direction = 'asc'
}

const {
  isShowConfirm: isConfirmDeleteVisible,
  entityStr: confirmDeleteName,
  showConfirm: doConfirmDeleteVisible,
  cancelAction: cancelDelete,
  deleteAction: confirmDelete
} = destroyComps('personas.destroy')

</script>
