<template>
  <Head title="Conocimientos" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="text-xl text-center font-semibold leading-tight text-gray-800">{{ conocimiento.descripcion }}</h2>
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
                  :href="route('conocimientos.edit', conocimiento.id)"
                >
                  Editar
                </Link>
                /
                <Link :preserveState="true" :preserveScroll="true"
                  @click="doConfirmDeleteVisible(conocimiento.id, conocimiento.descripcion)" class="text-red-700"
                  >Borrar</Link
                >
              </div>

              <div class="table w-full">
                <div class="table-row">
                  <p class="table-cell font-bold text-right pb-4">
                    Descripcion:
                  </p>
                  <p class="table-cell text-left px-2">
                    {{ conocimiento.descripcion }}
                  </p>
                </div>
                <div class="table-row">
                  <p class="table-cell font-bold text-right pb-4">
                    Tipo:
                  </p>
                  <p class="table-cell text-left px-2">
                    {{ conocimiento.tipo.nombre }}
                  </p>
                </div>
                <div class="table-row">
                  <p class="table-cell font-bold text-right pb-4">
                    Fecha de Información:
                  </p>
                  <p class="table-cell text-left px-2">
                    {{ fecha_informacion }}
                  </p>
                </div>
                <div class="table-row">
                  <p class="table-cell font-bold text-right pb-4">
                    Creado el:
                  </p>
                  <p class="table-cell text-left px-2">
                    {{ created_at }}
                  </p>
                </div>
                <div class="table-row">
                  <p class="table-cell font-bold text-right pb-4">
                    Actualizado el:
                  </p>
                  <p class="table-cell text-left px-2">
                    {{ updated_at }}
                  </p>
                </div>
                <div v-if="conocimiento.deleted_at" class="table-row">
                  <p class="table-cell font-bold text-right">
                    Eliminado el:
                  </p>
                  <p class="table-cell text-left px-2">
                    {{ deleted_at }}
                  </p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

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
            <section>
              <h3 class="text-xl font-bold mb-4 text-center select-none">Contenido</h3>

              <!-- <code>{{ conocimiento.contenido }}</code> -->
              <div id="content" v-html="contenido"></div>
            </section>
          </div>
        </div>
      </div>
    </div>
    <modal-confirm
      v-show="isConfirmDeleteVisible"
      :modal-title="`¿Borrar a ${confirmDeleteName}?`"
      confirm-message="¿Esta seguro de borrar el conocimiento?"
      @confirm-event="confirmDelete"
      @close-event="cancelDelete"
    />
  </BreezeAuthenticatedLayout>
</template>

<style>
  div#content *{
    margin-bottom: 1.25rem;
  }
</style>

<script setup>
import { toRefs, computed } from 'vue'
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue"
import { Head, Link } from "@inertiajs/inertia-vue3"
import { formatDatetime, formatDate } from '@/Utils'
import DOMPurify from 'dompurify'
import { marked } from 'marked'
import { destroyComps } from "@/Composables/generic"
import ModalConfirm from "@/Components/ModalConfirm.vue"

const props = defineProps({
  conocimiento: Object
})
const { conocimiento } = toRefs(props)

const contenido = computed(() => {
  const cont =  marked.parse(conocimiento.value.contenido, {
    breaks: true
  })

  return DOMPurify.sanitize(cont,
    {USE_PROFILES: {html: true},
    FORBID_TAGS: ['input', 'select', 'textarea']})
})

const created_at = computed(() => {
  return formatDatetime(conocimiento.value.created_at)
})

const updated_at = computed(() => {
  return formatDatetime(conocimiento.value.updated_at)
})

const fecha_informacion = computed(() => {
  return formatDate(conocimiento.value.fecha_informacion)
})

const {
  isShowConfirm: isConfirmDeleteVisible,
  entityStr: confirmDeleteName,
  showConfirm: doConfirmDeleteVisible,
  cancelAction: cancelDelete,
  deleteAction: confirmDelete
} = destroyComps('conocimientos.destroy')

</script>
