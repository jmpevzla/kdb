import { ref, watch } from 'vue'
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
  idRel = 0,
  beforeShowModal
}) {
  const isShowModal = ref(false)

  const showModal = () => {
    beforeShowModal ? beforeShowModal() : ''
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
    //entities.value = [...entities.value, obj]

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

export function memory2ListsComps (listOne, listTwo) {

  const allList = ref([])

  const updateList = () => {
    allList.value = [...listOne.value, ...listTwo.value]
  }

  watch(listOne, updateList, { deep: true })
  watch(listTwo, updateList, { deep: true })

  const deleteAction = (value) => {
    const lone = listOne.value
    const ltwo = listTwo.value

    let index = lone.indexOf(value)
    if (index >= 0)
      return listOne.value.splice(index, 1)

    index = ltwo.indexOf(value)
    if (index >= 0)
      return listTwo.value.splice(index, 1)
  }

  return {
    allList,
    deleteAction
  }
}

export function destroyRelComps ({
  routeStr = '',
  idRel = 0
}) {
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
    Inertia.delete(route(routeStr, [idRel, _id]), {
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

export function selLinksPropWatch(propLinksFn, watchProp) {
  const selLinks = ref([...propLinksFn()])
  const getSelLinks = () => selLinks

  watch(watchProp, () => {
    selLinks.value = [...propLinksFn()]
  }, { deep: true })

  return {
    getSelLinks
  }
}
