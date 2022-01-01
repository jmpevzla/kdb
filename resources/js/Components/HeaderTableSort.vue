<template>
  <div class="flex justify-between cursor-pointer select-none">
    <span>{{ title }}</span>
    <Icon class="fas ml-2"
      :class="{'fa-sort': (!params.field && !params.direction) || params.field !== field,
        'fa-sort-up': params.field === field && params.direction === 'asc',
        'fa-sort-down': params.field === field && params.direction === 'desc'}" />
  </div>
</template>

<script setup>
import { toRefs } from 'vue'
import Icon from '@/Components/IconFontAwesome.vue'

const props = defineProps({
  title: String,
  field: String,
  params: Object
})
const { title, params, field } = toRefs(props)
</script>
