<template>
  <multiselect v-model="model" track-by="id" placeholder="Buscar Links..."
      :options="options" :close-on-select="false" :multiple="true"
      label="descripcion" :hide-selected="true" :internal-search="false"
      :show-no-results="false" :loading="isLoading" :clear-on-select="false"
      @search-change="onSearch" @select="onSelect" :option-height="80">

    <template v-slot:option="{ option }">
      <div class="border-2 w-[25rem] overflow-hidden whitespace-nowrap">

        <p class="mb-2 text-base font-bold">{{ option.descripcion }}</p>
        <p class="text-blue-700">{{ option.link }}</p>
      </div>
    </template>
    <template v-slot:selection="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length && !isOpen">{{ values.length }} links seleccionados</span></template>
    <template v-slot:tag><span></span></template>
  </multiselect>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script setup>
import { ref, toRefs } from "vue"
import Multiselect from "vue-multiselect"

const props = defineProps({
  modelFn: {
    type: Function,
    required: true
  },
  options: {
    type: Array,
    required: true
  }
})

const { modelFn, options } = toRefs(props)
const emit = defineEmits(['search', 'select'])

const model = modelFn.value()
const isLoading = ref(false)

const onSearch = (query) => {
  emit('search', query, isLoading)
}

const onSelect = (selectedOption) => {
  emit('select', selectedOption)
}
</script>
