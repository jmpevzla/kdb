<template>
    <Head title="Conocimientos" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 text-center">
                Crear un Conocimiento
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
                                    required
                                    type="text"
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
                              <div class="flex flex-row mb-2">
                                <label class="mr-2">Tipo</label>
                                <Button type="button" class="rounded-full px-1 py-1"
                                  @click="showModalTipo">
                                  <i class="fas fa-plus"></i>
                                </Button>
                              </div>

                              <div class="mb-2">
                                <SimpleSelect
                                  :modelFn="getSelTipo"
                                  :options="tipos"
                                  label="nombre"
                                />
                              </div>
                            </div>
                            <div class="mb-2">
                              <div class="flex flex-row mb-2">
                                <label class="mr-2">Categorias</label>
                                <Button type="button" class="rounded-full px-1 py-1"
                                  @click="">
                                  <i class="fas fa-plus"></i>
                                </Button>
                              </div>

                              <div class="mb-2">
                                <TagMultiSelect
                                  :modelFn="getSelCats"
                                  :options="categorias"
                                  @search="(query, loading) => onSearchSelect('searchCats', 'categorias')(query, loading)"
                                />
                              </div>
                            </div>
                            <div class="mb-2">
                              <div class="flex flex-row mb-2">
                                <label class="mr-2">Etiquetas</label>
                                <Button type="button" class="rounded-full px-1 py-1"
                                  @click="">
                                  <i class="fas fa-plus"></i>
                                </Button>
                              </div>

                              <div class="mb-2">
                                <TagMultiSelect
                                  :modelFn="getSelEtqs"
                                  :options="etiquetas"
                                  @search="(query, loading) => onSearchSelect('searchEtqs', 'etiquetas')(query, loading)"
                                />
                              </div>
                            </div>
                            <div class="mb-2">
                                <label for="fecInfInput">Fecha de Información</label>
                                <input
                                    id="fecInfInput"
                                    type="date"
                                    v-model="form.fecha_informacion"
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
                                <label for="contenidoInput">Contenido</label>
                                <textarea
                                    id="contenidoInput"
                                    required
                                    v-model="form.contenido"
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
                                ></textarea>
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
        <ModalCreate
          v-if="isShowModalTipo"
          modal-title="Crear un Tipo"
          id-input="nombre"
          placeholder-input="Insertar un tipo..."
          @confirm-event="confirmCreateTipo"
          @close-event="cancelCreateTipo"
        />
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import { toRefs, ref } from "vue";
import { Inertia } from '@inertiajs/inertia'
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import Button from "@/Components/Button.vue"
import SimpleSelect from "@/Components/SimpleSelect.vue"
import ModalCreate from "@/Components/ModalCreate.vue"
import { createComps } from "@/Composables/generic";
import { watchNewEntSelRef } from "@/Utils/watch"
import TagMultiSelect from "@/Components/TagMultiSelect.vue";

const props = defineProps({
  tipos: Array,
  categorias: {
    type: Array,
    default: []
  },
  etiquetas: {
    type: Array,
    default: []
  }
})
const { tipos, categorias, etiquetas } = toRefs(props)

const selTipo = ref()
const getSelTipo = () => selTipo
watchNewEntSelRef(tipos, selTipo)

const selCats = ref([])
const getSelCats = () => selCats

const selEtqs = ref([])
const getSelEtqs = () => selEtqs

const form = useForm({
  descripcion: null,
  contenido: null,
  tipo_id: null,
  categorias: null,
  etiquetas: null,
  fecha_informacion: null
});

const submit = () => {
  form.tipo_id = selTipo.value.id
  form.categorias = selCats.value.map(value => value.id)
  form.etiquetas = selEtqs.value.map(value => value.id)
  form.post(route("conocimientos.store"));
}

const {
  isShowModal: isShowModalTipo,
  showModal: showModalTipo,
  cancelAction: cancelCreateTipo,
  createAction: confirmCreateTipo
} = createComps({
  routeStr: 'conocimientos.createTipo'
})

const onSearchSelect = (nameSearch, field) => (query, isLoading) => {
  Inertia.reload({
    data: {
      [nameSearch]: query
    },
    only: [field],
    onBefore: () => {
      isLoading.value = true
    },
    onFinish: () => {
      isLoading.value = false
    }
  })
}


</script>
