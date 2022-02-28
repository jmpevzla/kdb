import { watch } from 'vue'

export function watchNewEntSelRef(watchRef, selRef) {
  watch(watchRef, (arr, oldArr) => {
    arr.every(val => {
    const res = oldArr.find(v => v.id === val.id)
    if (!res) {
      selRef.value = val
      return false
    }
    return true
    })
  })
}


