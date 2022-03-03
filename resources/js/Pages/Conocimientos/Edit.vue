<template>
    <Head title="Conocimientos" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 text-center">
                Editar un Conocimiento
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto w-fit max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-2">
                                <label for="title">Descripcion</label>
                                <input
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
                                  @click="showModalCat">
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
                                  @click="showModalEtq">
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
                                <label for="title">Fecha de Información</label>
                                <input
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
                                <label for="title">Contenido</label>
                                <textarea
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
                                    Guardar
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
        <ModalCreate
          v-if="isShowModalCat"
          modal-title="Crear una Categoria"
          id-input="nombre"
          placeholder-input="Insertar una categoria..."
          @confirm-event="confirmCreateCat"
          @close-event="cancelCreateCat"
        />
        <ModalCreate
          v-if="isShowModalEtq"
          modal-title="Crear una Etiqueta"
          id-input="nombre"
          placeholder-input="Insertar una etiqueta..."
          @confirm-event="confirmCreateEtq"
          @close-event="cancelCreateEtq"
        />
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import { toRefs, ref, watch } from "vue";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import Button from "@/Components/Button.vue"
import SimpleSelect from "@/Components/SimpleSelect.vue"
import ModalCreate from "@/Components/ModalCreate.vue"
import { createComps } from "@/Composables/generic";
import { watchNewEntSelRef } from "@/Utils/watch"
import { idSelRef, onSearchSelect, selTagsRef } from "@/Utils/index"
import TagMultiSelect from "@/Components/TagMultiSelect.vue";

const props = defineProps({
  conocimiento: Object,
  tipos: Array,
  categorias: Array,
  etiquetas: Array,
  createCategoria: Object,
  createEtiqueta: Object
})
const { conocimiento, tipos, categorias, etiquetas
 , createCategoria , createEtiqueta } = toRefs(props)

const selTipos = ref()
const getSelTipo = () => selTipos
idSelRef(tipos, conocimiento.value.tipo_id, selTipos)
watchNewEntSelRef(tipos, selTipos)

const selCats = ref([])
const getSelCats = () => selCats
selTagsRef(conocimiento, 'categorias', selCats)

const selEtqs = ref([])
const getSelEtqs = () => selEtqs
selTagsRef(conocimiento, 'etiquetas', selEtqs)

watch(createCategoria, (value) => {
  if (value) selCats.value.push(value)
})

watch(createEtiqueta, (value) => {
  if (value) selEtqs.value.push(value)
})

const form = useForm({
  descripcion: conocimiento.value.descripcion,
  tipo_id: conocimiento.value.tipo_id,
  contenido: conocimiento.value.contenido,
  categorias: [],
  etiquetas: [],
  fecha_informacion: conocimiento.value.fecha_informacion
});

const submit = () => {
  form.tipo_id = selTipos.value.id
  form.categorias = selCats.value.map(value => value.id)
  form.etiquetas = selEtqs.value.map(value => value.id)

  form.put(route("conocimientos.update", conocimiento.value.id));
}

const {
  isShowModal: isShowModalTipo,
  showModal: showModalTipo,
  cancelAction: cancelCreateTipo,
  createAction: confirmCreateTipo
} = createComps({
  routeStr: 'conocimientos.createTipo'
})

const {
  isShowModal: isShowModalCat,
  showModal: showModalCat,
  cancelAction: cancelCreateCat,
  createAction: confirmCreateCat
} = createComps({
  routeStr: 'conocimientos.createCategoria'
})

const {
  isShowModal: isShowModalEtq,
  showModal: showModalEtq,
  cancelAction: cancelCreateEtq,
  createAction: confirmCreateEtq
} = createComps({
  routeStr: 'conocimientos.createEtiqueta'
})

</script>
