<template>
  <Head title="Categorias" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="text-xl text-center font-semibold leading-tight text-gray-800">
        {{ categoria.nombre }}
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
            <div class="min-w-[20rem]">
              <div class="text-right mb-4">
                <Link
                  class="text-green-700"
                  :href="route('categorias.edit', categoria.id)"
                >
                  Editar
                </Link>
                /
                <Link :preserveState="true" :preserveScroll="true"
                  @click="doConfirmDeleteVisible(categoria.id, categoria.nombre)" class="text-red-700"
                  >Borrar</Link
                >
              </div>

              <div class="table w-full">
                <div class="table-row">
                  <p class="table-cell font-bold text-right pb-4">
                    Descripción:
                  </p>
                  <p class="table-cell text-center break-words w-64 px-4 pb-4">
                    {{ categoria.descripcion }}
                  </p>
                </div>
                <div class="table-row">
                  <p class="table-cell font-bold text-right pb-4">
                    Creado el:
                  </p>
                  <p class="table-cell text-center">
                    {{ created_at }}
                  </p>
                </div>
                <div class="table-row">
                  <p class="table-cell font-bold text-right pb-4">
                    Actualizado el:
                  </p>
                  <p class="table-cell text-center">
                    {{ updated_at }}
                  </p>
                </div>
                <div v-if="categoria.deleted_at" class="table-row">
                  <p class="table-cell font-bold text-right">
                    Eliminado el:
                  </p>
                  <p class="table-cell text-center">
                    {{ deleted_at }}
                  </p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <modal-confirm
      v-show="isConfirmDeleteVisible"
      :modal-title="`¿Borrar a ${confirmDeleteName}?`"
      confirm-message="¿Esta seguro de borrar a la categoria?"
      @confirm-event="confirmDelete"
      @close-event="cancelDelete"
    />
  </BreezeAuthenticatedLayout>
</template>

<script setup>
import { toRefs, computed } from 'vue'
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { formatDatetime } from '@/Utils'
import { destroyComps } from "@/Composables/generic";
import ModalConfirm from "@/Components/ModalConfirm.vue"

const props = defineProps({
  categoria: Object
})
const { categoria } = toRefs(props)

const created_at = computed(() => {
  return formatDatetime(categoria.value.created_at)
})

const updated_at = computed(() => {
  return formatDatetime(categoria.value.updated_at)
})

const {
  isShowConfirm: isConfirmDeleteVisible,
  entityStr: confirmDeleteName,
  showConfirm: doConfirmDeleteVisible,
  cancelAction: cancelDelete,
  deleteAction: confirmDelete
} = destroyComps('categorias.destroy')

</script>
