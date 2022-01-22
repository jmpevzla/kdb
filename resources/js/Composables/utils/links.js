import { Inertia } from "@inertiajs/inertia";

export const beforeModalCreateLink = () => {
  Inertia.reload({
    // data: {
    //   'tipos-links': 1
    // },
    only: ['tiposLinks']
  })
}

/**
 * @param {Array} entities
 * @param {FormData} data
 */
export const removeLinkDuplicate = (entities, data) => {
  const descripcion = data.get('descripcion')
  const link = data.get('link')

  const index = entities.findIndex((ent) => {
    return ent.descripcion.toLowerCase() === descripcion.toLowerCase()
      && ent.link.toLowerCase() === link.toLowerCase()
  })

  if (index >= 0) {
    entities.splice(index, 1)
  }
}
