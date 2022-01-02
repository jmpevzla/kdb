import { ref } from 'vue'
import { Inertia } from "@inertiajs/inertia"

export function destroyComps (routeStr) {
  const isShowConfirm = ref(false)
  const entityStr = ref('')
  let _id = -1

  const showConfirm = (id, str = 'entidad') => {
    isShowConfirm.value = true
    entityStr.value = str
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
    entityStr,
    showConfirm,
    cancelAction,
    deleteAction
  }
}

