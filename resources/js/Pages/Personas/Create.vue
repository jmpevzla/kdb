<template>
    <Head title="Personas" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 text-center">
                Crear una Persona
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto w-fit max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-2">
                                <label for="title">Nombre</label>
                                <input
                                    type="text"
                                    v-model="form.nombre"
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
                                <label for="title">Bio</label>
                                <textarea
                                    v-model="form.bio"
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
                            <div class="mb-2">
                              <div class="flex flex-row mb-2">
                                <label class="font-bold mr-2">Apodos</label>
                                <Button type="button" class="rounded-full px-1 py-1"
                                  @click="createApodoVisible">
                                  <i class="fas fa-plus"></i>
                                </Button>
                              </div>

                              <div class="
                                grid
                                grid-cols-[repeat(2,_auto_1fr)]
                                lg:grid-cols-[repeat(3,_auto_1fr)]
                                gap-2 grid-flow-row-dense
                                ">

                                <template v-for="(apodo, index) of apodos" :key="index">
                                  <div>
                                    <Button type="button" class="rounded-full px-1 py-1 ml-1"
                                      @click="apodoDelete(index)">
                                      <i class="fas fa-times"></i>
                                    </Button>
                                  </div>
                                  <p class="break-all">{{ apodo.apodo }}</p>
                                </template>

                              </div>
                            </div>
                            <div class="mb-2">
                              <div class="flex flex-row mb-2">
                                <label class="font-bold mr-2">Links</label>
                                <Button type="button" class="rounded-full px-1 py-1"
                                  @click="createLinkVisible">
                                  <i class="fas fa-plus"></i>
                                </Button>
                              </div>

                              <div>
                                <!-- <multiselect v-model="value" deselect-label="Can't remove this value" track-by="name" :custom-label="({ name, language }) => `${language} <br> ${name}`" placeholder="Select one" :options="options" :searchable="false" :allow-empty="false">
                                  <template v-slot:singleLabel="{ option }" ><strong>{{ option.name }}</strong> is written in <strong>  {{ option.language }}</strong></template>
                                  <template v-slot:option="{ option }">
                                    <div class="option__desc"><span class="option__title">{{ option.name }}</span><span class="option__small">{{ option.language }}</span></div>
                                  </template>
                                </multiselect> -->
                                <multiselect v-model="selLinks" track-by="id" placeholder="Buscar Links..."
                                  :options="dbLinks" :close-on-select="false" :multiple="true"
                                  label="descripcion" :hide-selected="true" :internal-search="false"
                                  :show-no-results="false" :loading="isLoadingLinks" :clear-on-select="false"
                                  @search-change="onSearchLinks" :option-height="80">
                                  <!-- <template v-slot:singleLabel="{ option }" ><strong>{{ option.name }}</strong> is written in <strong>  {{ option.language }}</strong></template> -->
                                  <template v-slot:option="{ option }">
                                    <div class="border-2 w-[25rem] overflow-hidden whitespace-nowrap">

                                      <p class="mb-2 text-base font-bold">{{ option.descripcion }}</p>
                                      <p class="text-blue-700">{{ option.link }}</p>
                                    </div>
                                  </template>
                                  <template v-slot:selection="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length && !isOpen">{{ values.length }} links seleccionados</span></template>
                                  <template v-slot:tag><span></span></template>
                                </multiselect>
                              </div>

                              <div class="
                                  grid
                                  grid-cols-[auto,_1fr]
                                  items-center
                                  gap-2
                                  grid-flow-row-dense
                                ">

                                <template v-for="(link, _index) of allLinks" :key="_index">
                                  <div>
                                    <Button type="button" class="rounded-full px-1 py-1 ml-1"
                                      @click="linkDelete(link)">
                                      <i class="fas fa-times"></i>
                                    </Button>
                                  </div>
                                  <div :class="[{'bg-green-200': !link.id}]">
                                    <p class="
                                      text-ellipsis w-80 overflow-hidden whitespace-nowrap
                                    ">{{ link.descripcion }}
                                    </p>
                                    <a class="
                                      block text-ellipsis w-80 overflow-hidden whitespace-nowrap
                                      text-blue-600 hover:text-black
                                      "
                                      :href="link.link"
                                      rel="noopener noreferrer"
                                      target="_blank">{{ link.link }}
                                    </a>
                                  </div>
                                </template>

                              </div>
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
          v-if="isCreateApodoVisible"
          modal-title="Crear un Apodo"
          id-input="apodo"
          placeholder-input="Insertar un apodo..."
          @confirm-event="confirmCreateApodo"
          @close-event="cancelCreateApodo"
        />
        <ModalCreateLink
          v-if="isCreateLinkVisible"
          :tipos-links="tiposLinks"
          @confirm-event="confirmCreateLink"
          @close-event="cancelCreateLink"
        />
    </BreezeAuthenticatedLayout>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script setup>
import { toRefs, ref, onMounted } from "vue"
import Multiselect from "vue-multiselect"
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue"
import { Head } from "@inertiajs/inertia-vue3"
import { useForm } from "@inertiajs/inertia-vue3"
import ModalCreate from "@/Components/ModalCreate.vue"
import Button from "@/Components/Button.vue"
import { createMemoryComps, destroyMemoryComps,
  memory2ListsComps } from "@/Composables/generic";
import ModalCreateLink from '@/Components/Modals/CreateLink.vue'
import { beforeModalCreateLink, removeLinkDuplicate } from '@/Composables/utils/links'
import { Inertia } from "@inertiajs/inertia"

const props = defineProps({
  tiposLinks: {
    type: Array,
    default: []
  },
  links: {
    tyle: Array,
    default: []
  }
})

const { tiposLinks, links: dbLinks } = toRefs(props)

const form = useForm({
  nombre: null,
  bio: null,
  apodos: [],
  links: {
    selLinks: [],
    createLinks: []
  }
});

const isLoadingLinks = ref(false)
const selLinks = ref([])

const {
  isShowModal: isCreateApodoVisible,
  showModal: createApodoVisible,
  entities: apodos,
  cancelAction: cancelCreateApodo,
  createAction: confirmCreateApodo
} = createMemoryComps()

const {
  deleteAction: apodoDelete
} = destroyMemoryComps(apodos)

const {
  isShowModal: isCreateLinkVisible,
  showModal: createLinkVisible,
  entities: links,
  cancelAction: cancelCreateLink,
  createAction: confirmCreateLink
} = createMemoryComps({
  beforeShowModal: beforeModalCreateLink,
  removeDuplicateCustom: removeLinkDuplicate
})

const onSearchLinks = (query) => {
  Inertia.reload({
    data: {
      searchLink: query
    },
    only: ['links'],
    onBefore: () => {
      isLoadingLinks.value = true
    },
    onFinish: () => {
      isLoadingLinks.value = false
    }
  })
}

const {
  allList: allLinks,
  deleteAction: linkDelete
} = memory2ListsComps(selLinks, links)

const submit = () => {
  form.apodos = apodos.value
  form.links.selLinks = selLinks.value.map((value) => {
    return value.id
  })
  form.links.createLinks = links.value
  form.post(route("personas.store"))
}

</script>
