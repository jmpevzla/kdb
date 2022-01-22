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
  idRel = 0
}) {
  const isShowModal = ref(false)

  const showModal = () => {
    isShowModal.value = true
  }

  const cancelAction = () => {
    isShowModal.value = false
  }

  const createAction = (event) => {

    const data = new FormData(event.target)

    Inertia.post(route(routeStr, idRel), data, {
      preserveScroll: true,
      preserveState: true
    })

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
  beforeShowModal,
  removeDuplicateCustom
} = {}) {
  const isShowModal = ref(false)
  const entities = ref([])

  const showModal = () => {
    beforeShowModal ? beforeShowModal() : ''
    isShowModal.value = true
  }

  const cancelAction = () => {
    isShowModal.value = false
  }

  function removeDuplicate(entities, value, key) {
    const ents = entities
    const index = ents.findIndex((ent) => ent[key].toLowerCase() === value.toLowerCase())
    if (index >= 0) {
      ents.splice(index, 1)
    }
  }

  const createAction = (event) => {

    const data = new FormData(event.target)

    const obj = {}
    removeDuplicateCustom ? removeDuplicateCustom(entities.value, data) : ''
    data.forEach((value, key) => {
      !removeDuplicateCustom ? removeDuplicate(entities.value, value, key) : ''
      obj[key] = value
    })

    entities.value.push(obj)

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
