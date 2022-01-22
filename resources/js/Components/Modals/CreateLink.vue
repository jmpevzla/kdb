<template>
  <transition name="modal-fade">
    <div class="fixed z-10 inset-0 overflow-y-auto">
      <div class="
        flex items-end justify-center
        min-h-screen pt-4 px-4
        pb-20 text-center sm:block
        sm:p-0
      ">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span
          class="hidden sm:inline-block sm:align-middle sm:h-screen"
          aria-hidden="true"
          >&#8203;</span
        >

        <div
          class="
            inline-block align-bottom bg-white
            rounded-lg text-left overflow-hidden
            shadow-xl transform transition-all
            sm:my-8 sm:align-middle sm:max-w-lg
            sm:w-full
          "
          role="dialog"
          aria-modal="true"
          aria-labelledby="modal-headline"
        >
          <form @submit.prevent="handleSubmit">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div
                  class="
                    mx-auto flex-shrink-0 flex
                    items-center justify-center h-12
                    w-12 rounded-full bg-green-200
                    sm:mx-0 sm:h-10 sm:w-10
                  "
                >
                  <i class="fas fa-link"></i>
                </div>

                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                  <h3
                    class="text-lg leading-6 font-bold text-gray-900"
                    id="modal-headline"
                  >
                    Crear un Link
                  </h3>
                  <div class="mt-2">
                    <input
                        id="idDescripcion"
                        type="text"
                        name="descripcion"
                        placeholder="Descripción"
                        required
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
                  <div class="mt-2">
                      <select
                        id="idTipoLink"
                        name="tipo-link_id"
                        required
                        :onchange="onSelChange"
                        class="
                          w-full
                          px-4
                          py-2
                          mt-2
                          border
                          rounded-md
                          focus:outline-none
                          focus:ring-1
                        "
                        :class="[selChange ? 'text-black' : 'text-gray-500']">

                        <option hidden disabled selected value="">
                          Tipo de Link
                        </option>
                        <option class="text-black" v-for="tipo of tiposLinks"
                          :key="tipo.id"
                          :value="tipo.id">{{ tipo.descripcion }}</option>
                      </select>
                  </div>
                  <div class="mt-2">
                    <input
                        id="idLink"
                        type="text"
                        name="link"
                        placeholder="Link"
                        required
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
                </div>
              </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button
                type="submit"
                class="
                  w-full inline-flex justify-center
                  rounded-md border border-transparent
                  shadow-sm px-4 py-2 bg-green-600
                  text-base font-medium text-white
                  hover:bg-green-700 focus:outline-none focus:ring-2
                  focus:ring-offset-2 focus:ring-green-500 sm:ml-3
                  sm:w-auto sm:text-sm
                "
              >
                Crear
              </button>
              <button
                type="reset"
                @click="closeModal"
                class="
                  mt-3 w-full inline-flex
                  justify-center rounded-md border
                  border-gray-300 shadow-sm px-4
                  py-2 bg-white text-base
                  font-medium text-gray-700 hover:bg-gray-50
                  focus:outline-none focus:ring-2 focus:ring-offset-2
                  focus:ring-indigo-500 sm:mt-0 sm:ml-3
                  sm:w-auto sm:text-sm
                "
              >
                Cancelar
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </transition>
</template>

<script setup>
import { ref, toRefs } from 'vue'

const props = defineProps({
  tiposLinks: {
    type: Array,
    required: true
  }
})

const { tiposLinks } = toRefs(props)

const emit = defineEmits(['closeEvent', 'confirmEvent'])

const selChange = ref(false)
const onSelChange = () => selChange.value = true

const clearInputs = () => {
  document.getElementById('idDescripcion').value = ''
  document.getElementById('idTipoLink').value = ''
  document.getElementById('idLink').value = ''
}

const closeModal = () => {
  clearInputs()
  emit("closeEvent")
}

const handleSubmit = (event) => {
  emit("confirmEvent", event)
  clearInputs()
}

</script>
