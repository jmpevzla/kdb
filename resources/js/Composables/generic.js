import { ref } from 'vue'
import { Inertia } from "@inertiajs/inertia"

export function destroyComps (routeStr) {
  const isShowConfirm = ref(false)
  let _id = -1

  const showConfirm = (id) => {
    isShowConfirm.value = true
    _id = id
  }

  const cancelAction = () => {
    isShowConfirm.value = false
  }

  const deleteAction = () => {
    Inertia.delete(route(routeStr, _id), {
      preserveScroll: true
    });
    isShowConfirm.value = false
  }

  return {
    isShowConfirm,
    showConfirm,
    cancelAction,
    deleteAction
  }
}

