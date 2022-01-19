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

export function createComps ({
  routeStr = '',
  nameValue = '',
  idRel = 0
}) {
  const isShowModal = ref(false)
  // const entityStr = ref('')
  // let _id = -1

  const showModal = () => {
    isShowModal.value = true
  }

  const cancelAction = () => {
    isShowModal.value = false
  }

  const createAction = (value) => {
    // Inertia.delete(route(routeStr, _id), {
    //   preserveScroll: true
    // });
    Inertia.post(route(routeStr, idRel), {
      [nameValue]: value
    } , {
      preserveScroll: true,
      preserveState: true
    })
    //console.log({ [nameValue]: value, ...addData })
    isShowModal.value = false
  }

  return {
    isShowModal,
    showModal,
    cancelAction,
    createAction
  }
}

export function createMemoryComps ({
  nameValue = ''
}) {
  const isShowModal = ref(false)
  const entities = ref([])

  const showModal = () => {
    isShowModal.value = true
  }

  const cancelAction = () => {
    isShowModal.value = false
  }

  const createAction = (value) => {
    entities.value.push({
      [nameValue]: value
    })

    isShowModal.value = false
  }

  return {
    isShowModal,
    showModal,
    entities,
    cancelAction,
    createAction
  }
}

export function destroyMemoryComps (entities) {
  const deleteAction = (index) => {
    entities.value.splice(index, 1)
  }

  return {
    deleteAction
  }
}
