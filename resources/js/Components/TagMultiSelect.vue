<template>
  <multiselect style="max-width: 400px" v-model="model" track-by="id" placeholder="Buscar ..."
      :options="options" :close-on-select="false" :multiple="true"
      :label="label" :hide-selected="true" :internal-search="false"
      :show-no-results="false" :loading="isLoading" :clear-on-select="false"
      @search-change="onSearch" @select="onSelect">

    <!-- <template v-slot:selection="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length && !isOpen">{{ values.length }} seleccionados</span></template> -->
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
  },
  label: {
    type: String,
    default: 'nombre'
  }
})

const { modelFn, options, label } = toRefs(props)
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
