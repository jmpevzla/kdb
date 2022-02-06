import { Inertia } from '@inertiajs/inertia'

export const onSearchLinks = (query, isLoadingLinks) => {
  Inertia.reload({
    data: {
      searchLink: query
    },
    only: ['links'],
    onBefore: () => {
      isLoadingLinks.value = true
    },
    onFinish: () => {
      isLoadingLinks.value = false
    }
  })
}

export const selectLinkFn = (routeStr, idRel) => (selectedOption) => {
  Inertia.post(route(routeStr, idRel), { id: selectedOption.id }, {
    preserveScroll: true,
    preserveState: true
  })
}
