export function formatDatetime(str) {
  const date = new Date(str)
  const day = String(date.getDate()).padStart(2, '0')
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const year = String(date.getFullYear())
  const hour = String(date.getHours()).padStart(2, '0')
  const minutes = String(date.getMinutes()).padStart(2, '0')
  return `${day}-${month}-${year} (${hour}:${minutes})`
}

export function formatDate(str) {
  const date = new Date(str)
  const day = String(date.getDate()).padStart(2, '0')
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const year = String(date.getFullYear())

  return `${day}-${month}-${year}`
}

export function idSelRef(watchRef, id, selRef) {
  const res = watchRef.value.find(v => v.id === id)
  selRef.value = res
}

export function selTagsRef(watchRef, field, selRef) {
  const wRef = watchRef.value[field]
  selRef.value = []
  wRef.forEach((value) => {
   selRef.value.push(value)
  })
}

export const onSearchSelect = (nameSearch, field) => (query, isLoading) => {
  Inertia.reload({
    data: {
      [nameSearch]: query
    },
    only: [field],
    onBefore: () => {
      isLoading.value = true
    },
    onFinish: () => {
      isLoading.value = false
    }
  })
}
