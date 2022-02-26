<template>
    <Head title="Medios" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 text-center">
                Editar un Medio
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
                                <label class="font-bold mr-2">Links</label>
                                <Button type="button" class="rounded-full px-1 py-1"
                                  @click="createLinkVisible">
                                  <i class="fas fa-plus"></i>
                                </Button>
                              </div>

                              <div class="mb-2">
                                <LinkMultiSelect
                                  :modelFn="getSelLinks"
                                  :options="links"
                                  @search="onSearchLinks"
                                  @select="onSelectLink"
                                />
                              </div>

                              <div class="
                                  grid
                                  grid-cols-[auto,_1fr]
                                  items-center
                                  gap-2
                                  grid-flow-row-dense
                                ">

                                <template v-for="link of medio.links" :key="link.id">
                                  <div>
                                    <Button type="button" class="rounded-full px-1 py-1 ml-1"
                                      @click="doConfLinkRelDeleteVisible(link.id, link.descripcion)">
                                      <i class="fas fa-times"></i>
                                    </Button>
                                  </div>
                                  <div>
                                    <p class="
                                      text-ellipsis w-80 overflow-hidden whitespace-nowrap
                                    ">{{ link.descripcion }}
                                    </p>
                                    <a class="
                                      block text-ellipsis w-80 overflow-hidden whitespace-nowrap
                                      text-blue-600 hover:text-black
                                      "
                                      :href="'//' + link.link"
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
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <ModalCreateLink
          v-if="isCreateLinkVisible"
          :tipos-links="tiposLinks"
          @confirm-event="confirmCreateLink"
          @close-event="cancelCreateLink"
        />
        <modal-confirm
          v-if="isConfLinkRelDeleteVisible"
          :modal-title="`¿Borrar a ${confLinkRelDeleteName}?`"
          confirm-message="¿Esta seguro de borrar esta relación?"
          @confirm-event="confirmLinkRelDelete"
          @close-event="cancelLinkRelDelete"
        />
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import { toRefs } from "vue"
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue"
import { Head } from "@inertiajs/inertia-vue3"
import { useForm } from "@inertiajs/inertia-vue3"
import LinkMultiSelect from "@/Components/LinkMultiSelect.vue"
import Button from "@/Components/Button.vue"
import ModalConfirm from "@/Components/ModalConfirm.vue"
import ModalCreateLink from "@/Components/Modals/CreateLink.vue"
import { createComps, destroyComps,
  destroyRelComps, selLinksPropWatch } from "@/Composables/generic"
import { beforeModalCreateLink } from "@/Composables/utils/links"
import { onSearchLinks, selectLinkFn } from "@/Utils/links"

const props = defineProps({
  medio: Object,
  tiposLinks: {
    type: Array,
    default: []
  },
  links: {
    type: Array,
    default: []
  }
})
const { medio, tiposLinks, links } = toRefs(props)

const {
  getSelLinks
} = selLinksPropWatch(() => medio.value.links, medio)

const form = useForm({
    nombre: medio.value.nombre,
    bio: medio.value.bio
});

const submit = () => {
  form.put(route("medios.update", medio.value.id))
}

const {
  isShowModal: isCreateLinkVisible,
  showModal: createLinkVisible,
  cancelAction: cancelCreateLink,
  createAction: confirmCreateLink
} = createComps({
  routeStr: 'medios.createLink',
  idRel: medio.value.id,
  beforeShowModal: beforeModalCreateLink
})

const onSelectLink = selectLinkFn('medios.attachLink', medio.value.id)

const {
  isShowConfirm: isConfLinkRelDeleteVisible,
  entityStr: confLinkRelDeleteName,
  showConfirm: doConfLinkRelDeleteVisible,
  cancelAction: cancelLinkRelDelete,
  deleteAction: confirmLinkRelDelete
} = destroyRelComps({
  routeStr: 'medios.removeLink',
  idRel: medio.value.id
})

</script>
