<template>
  <Head title="Tipos de Links" />

  <breeze-authenticated-layout>
    <template #header>
      <h2 class="text-xl text-center font-semibold leading-tight text-gray-800">
        Tipos de Links
      </h2>
    </template>

    <div class="py-6">
      <div class="mx-auto w-full lg:w-[40rem] sm:px-6 lg:px-8">
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
                  :href="route('tipos-links.create')"
                >
                  Crear Tipo de Link
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
                    <header-table-sort title="Descripcion" field="descripcion"
                      :params="params" @click="sort('descripcion')" />
                  </td>
                  <td class="px-4 py-2">Acción</td>
                </thead>
                <tbody>
                  <tr v-for="tipoLink in tiposLinks.data" :key="tipoLink.id">
                    <td class="px-4 py-2">{{ tipoLink.id }}</td>
                    <td class="px-4 py-2">
                      <Link
                        class="text-blue-700"
                        :href="route('tipos-links.show', tipoLink.id)"
                        >{{ tipoLink.descripcion }}</Link
                      >
                    </td>

                    <td class="px-4 py-2 font-extrabold">
                      <Link
                        class="text-green-700"
                        :href="route('tipos-links.edit', tipoLink.id)"
                      >
                        Editar
                      </Link>
                      /
                      <Link preserveState="true" preserveScroll="true"
                        @click="doConfirmDeleteVisible(tipoLink.id, tipoLink.descripcion)" class="text-red-700"
                        >Borrar</Link
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
              <pagination-links
                class="flex justify-center mt-4"
                :links="tiposLinks.links"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal-confirm
      v-show="isConfirmDeleteVisible"
      :modal-title="`¿Borrar a ${confirmDeleteName}?`"
      confirm-message="¿Esta seguro de borrar a el tipo de link?"
      @confirm-event="confirmDelete"
      @close-event="cancelDelete"
    />
  </breeze-authenticated-layout>
</template>

<script setup>
import { reactive, toRefs, watch } from "vue"
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue"
import BreezeNavLink from "@/Components/NavLink.vue"
import BreezeInput from "@/Components/Input.vue"
import PaginationLinks from "@/Components/PaginationLinks.vue"
import { Inertia } from "@inertiajs/inertia"
import { Head, Link } from "@inertiajs/inertia-vue3"
import { pickBy, throttle } from "lodash"
import { destroyComps } from "@/Composables/generic"
import HeaderTableSort from '@/Components/HeaderTableSort.vue'
import ModalConfirm from "@/Components/ModalConfirm.vue"

const props = defineProps({
  tiposLinks: {
    type: Object,
    required: true
  },
  filters: Object
})
const { tiposLinks, filters } = toRefs(props)
const { search, field, direction } = filters.value

const params = reactive({
  search,
  field,
  direction
})

watch(params, throttle(() => {
  Inertia.get(route('tipos-links.index'), pickBy({ ...params }, (value) => value), {
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
} = destroyComps('tipos-links.destroy')

</script>
