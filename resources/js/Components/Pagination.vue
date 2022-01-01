<template>
  <div v-if="links.length > 2">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, key) in links" :key="key">
        <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
        <div v-else-if="link.active" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-green-500 border border-green-500 rounded" v-html="link.label" />
        <Link v-else class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
          :href="link.url" v-html="link.label" replace="true" preserveState="true" preserveScroll="true" />
      </template>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
export default {
  components: {
    Link
  },
  props: {
    links: Array
  },
}
</script>
