<template>
  <Head title="Crear Grupo" />

  <BreezeValidationErrors class="mb-4 text-center" />

  <div v-if="status" class="mb-4 font-medium text-sm text-green-600 text-center">
      {{ status }}
  </div>

  <div class="m-3">
    <form @submit.prevent="submit" class="m-auto sm:w-96">
      <div>
        <BreezeLabel for="name" value="Nombre" />
        <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
      </div>

      <div class="flex items-center justify-end mt-4">
        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Crear
        </BreezeButton>
      </div>
    </form>
  </div>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { inject } from 'vue'
export default {
    layout: BreezeAuthenticatedLayout,

    components: {
      BreezeButton,
      BreezeInput,
      BreezeLabel,
      BreezeValidationErrors,
      Head,
    },

    props: {
      status: String,
    },

    setup() {
      const form = useForm({
        name: ''
      })

      const route = inject('route')

      const submit = () => {
        form.post(route('grupos.crear'), {
          onSuccess: () => form.reset('name')
        })
      }

      return {
        form,
        submit
      };
    }
}
</script>
