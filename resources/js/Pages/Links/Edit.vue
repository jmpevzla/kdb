<template>
    <Head title="Links" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 text-center">
                Editar un Link
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
                                <label class="mr-2">Tipo de Link</label>
                                <Button type="button" class="rounded-full px-1 py-1"
                                  @click="showModalTLink">
                                  <i class="fas fa-plus"></i>
                                </Button>
                              </div>

                              <div class="mb-2">
                                <SimpleSelect
                                  :modelFn="getSelTLink"
                                  :options="tiposLinks"
                                />
                              </div>
                            </div>

                            <div>
                                <label for="linkInput">Link</label>
                                <input
                                    id="linkInput"
                                    type="url"
                                    required
                                    v-model="form.link"
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
          v-if="isShowModalTLink"
          modal-title="Crear un Tipo de Link"
          id-input="descripcion"
          placeholder-input="Insertar un tipo de link..."
          @confirm-event="confirmCreateTLink"
          @close-event="cancelCreateTLink"
        />
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import { toRefs, ref } from "vue";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import Button from "@/Components/Button.vue"
import SimpleSelect from "@/Components/SimpleSelect.vue"
import ModalCreate from "@/Components/ModalCreate.vue"
import { createComps } from "@/Composables/generic"
import { idSelRef } from "@/Utils/index"
import { watchNewEntSelRef } from "@/Utils/watch"

const props = defineProps({
  link: Object,
  tiposLinks: Array
})
const { link, tiposLinks } = toRefs(props)

const selTLink = ref()
const getSelTLink = () => selTLink
idSelRef(tiposLinks, link.value['tipo-link_id'], selTLink)
watchNewEntSelRef(tiposLinks, selTLink)

const form = useForm({
  descripcion: link.value.descripcion,
  link: link.value.link,
  'tipo-link_id': null
});

const submit = () => {
  form['tipo-link_id'] = selTLink.value.id
  form.put(route("links.update", link.value.id));
}

const {
  isShowModal: isShowModalTLink,
  showModal: showModalTLink,
  cancelAction: cancelCreateTLink,
  createAction: confirmCreateTLink
} = createComps({
  routeStr: 'links.createTipoLink'
})

</script>
