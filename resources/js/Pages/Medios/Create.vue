<template>
    <Head title="Medios" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 text-center">
                Crear un Medio
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
                                  :options="dbLinks"
                                  @search="onSearchLinks"
                                />
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
        <ModalCreateLink
          v-if="isCreateLinkVisible"
          :tipos-links="tiposLinks"
          @confirm-event="confirmCreateLink"
          @close-event="cancelCreateLink"
        />
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import { toRefs, ref } from 'vue'
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import LinkMultiSelect from "@/Components/LinkMultiSelect.vue"
import Button from "@/Components/Button.vue"
import ModalCreateLink from '@/Components/Modals/CreateLink.vue'
import { createMemoryComps, destroyMemoryComps,
  memory2ListsComps } from "@/Composables/generic";
import { beforeModalCreateLink, removeLinkDuplicate } from '@/Composables/utils/links'
import { onSearchLinks } from '@/Utils/links'

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
  links: {
    selLinks: [],
    createLinks: []
  }
})

const selLinks = ref([])
const getSelLinks = () => selLinks

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

const {
  allList: allLinks,
  deleteAction: linkDelete
} = memory2ListsComps(selLinks, links)

const submit = () => {
  form.links.selLinks = selLinks.value.map((value) => {
    return value.id
  })
  form.links.createLinks = links.value
  form.post(route("medios.store"));
}

</script>
