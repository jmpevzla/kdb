<template>
  <Head title="Etiquetas" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="text-xl text-center font-semibold leading-tight text-gray-800">
        {{ etiqueta.nombre }}
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
                  :href="route('etiquetas.edit', etiqueta.id)"
                >
                  Editar
                </Link>
                /
                <Link :preserveState="true" :preserveScroll="true"
                  @click="doConfirmDeleteVisible(etiqueta.id, etiqueta.nombre)" class="text-red-700"
                  >Borrar</Link
                >
              </div>

              <div class="table w-full">
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
                <div v-if="etiqueta.deleted_at" class="table-row">
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
      confirm-message="¿Esta seguro de borrar a la etiqueta?"
      @confirm-event="confirmDelete"
      @close-event="cancelDelete"
    />
  </BreezeAuthenticatedLayout>
</template>

<script setup>
import { toRefs, computed } from 'vue'
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { formatDatetime } from '@/Utils'
import { destroyComps } from "@/Composables/generic";
import ModalConfirm from '@/Components/ModalConfirm.vue';

const props = defineProps({
  etiqueta: Object
})
const { etiqueta } = toRefs(props)

const created_at = computed(() => {
  return formatDatetime(etiqueta.value.created_at)
})

const updated_at = computed(() => {
  return formatDatetime(etiqueta.value.updated_at)
})

const {
  isShowConfirm: isConfirmDeleteVisible,
  entityStr: confirmDeleteName,
  showConfirm: doConfirmDeleteVisible,
  cancelAction: cancelDelete,
  deleteAction: confirmDelete
} = destroyComps('etiquetas.destroy')

</script>
