<template>
  <Head title="Personas" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="text-xl text-center font-semibold leading-tight text-gray-800">{{ persona.nombre }}</h2>
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
                  :href="route('personas.edit', persona.id)"
                >
                  Editar
                </Link>
                /
                <Link :preserveState="true" :preserveScroll="true"
                  @click="doConfirmDeleteVisible(persona.id, persona.nombre)" class="text-red-700"
                  >Borrar</Link
                >
              </div>

              <div class="table w-full">
                <div class="table-row">
                  <p class="table-cell font-bold text-right pb-4">
                    Bio:
                  </p>
                  <p class="table-cell text-center break-words w-64 px-4 pb-4">
                    {{ persona.bio }}
                  </p>
                </div>
                <div class="table-row">
                  <p class="table-cell font-bold text-right pb-4">
                    Apodos:
                  </p>
                  <p class="table-cell text-center break-words w-64 px-4 pb-4">
                    {{ apodos }}
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
                <div v-if="persona.deleted_at" class="table-row">
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
      confirm-message="¿Esta seguro de borrar a la persona?"
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
  persona: Object
})
const { persona } = toRefs(props)

const apodos = computed(() => {
  return persona.value.apodos.map((apodo) => {
    return apodo.apodo
  }).join(', ')
})

const created_at = computed(() => {
  return formatDatetime(persona.value.created_at)
})

const updated_at = computed(() => {
  return formatDatetime(persona.value.updated_at)
})

const {
  isShowConfirm: isConfirmDeleteVisible,
  entityStr: confirmDeleteName,
  showConfirm: doConfirmDeleteVisible,
  cancelAction: cancelDelete,
  deleteAction: confirmDelete
} = destroyComps('personas.destroy')

</script>
