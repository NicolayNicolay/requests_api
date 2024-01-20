<script setup lang="ts">
import {ref} from "vue";
import {useModal} from '@/composables/useModal'

const {params, close} = useModal()
const {title, subTitle} = params.modelValue

const error = ref(false)

function success() {
  params.modelValue.function().then(() => {
    close()
    params.modelValue.reloadFunction()
  }).catch(() => {
    error.value = true;
  })
}
</script>

<template>
  <div class="modal-body pt-3 pb-3 text-center">
    <div class="h5 mb-4">
      <div class="text-danger" v-if="error">Error, something went wrong</div>
      <div class="mb-2" v-html="title"></div>
      {{ subTitle }}
    </div>
    <div class="d-flex justify-content-center pt-2 pb-4">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Закрыть">Нет</button>
      <button type="button" class="btn btn-success ms-4" @click.prevent="success">Да</button>
    </div>
  </div>
</template>
<style scoped lang="scss">
.btn {
  --bs-btn-padding-x: 2rem;
}
</style>
