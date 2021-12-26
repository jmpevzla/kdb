import { Inertia } from "@inertiajs/inertia"

export function destroyComps (routeStr) {
  return (id) => {
    Inertia.delete(route(routeStr, id));
  }
}
