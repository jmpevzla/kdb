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
          v-show="isCreateApodoVisible"
          modal-title="Crear un Apodo"
          id-input="apodo"
          placeholder-input="Insertar un apodo..."
          @confirm-event="confirmCreateApodo"
          @close-event="cancelCreateApodo"
        />
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import ModalCreate from "@/Components/ModalCreate.vue";
import Button from "@/Components/Button.vue"
import { createMemoryComps, destroyMemoryComps } from "@/Composables/generic";

const form = useForm({
  nombre: null,
  bio: null,
  apodos: []
});

const submit = () => {
  form.apodos = apodos.value
  form.post(route("personas.store"))
}

const {
  isShowModal: isCreateApodoVisible,
  showModal: createApodoVisible,
  cancelAction: cancelCreateApodo,
  createAction: confirmCreateApodo,
  entities: apodos
} = createMemoryComps({
  nameValue: 'apodo'
})

const {
  deleteAction: apodoDelete
} = destroyMemoryComps(apodos)

</script>
