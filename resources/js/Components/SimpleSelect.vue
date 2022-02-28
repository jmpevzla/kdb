<template>
  <multiselect v-model="model" track-by="id" placeholder="Buscar ..."
      :options="options" :close-on-select="true" :multiple="false"
      label="descripcion" :internal-search="true"
      :show-no-results="false" :clear-on-select="false"
      :max-height="150" openDirection="bottom">
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
    tyle: Array,
    required: true
  }
})

const { modelFn, options } = toRefs(props)

const model = modelFn.value()

</script>
