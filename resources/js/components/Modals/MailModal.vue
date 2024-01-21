<script setup lang="ts">
import {ref} from "vue";
import axios from "axios";
import {useModal} from '@/composables/useModal'
import TextareaComponent from "@/components/Forms/TextAreaComponent.vue";
import {config} from "@/config";

const {params, close} = useModal()

const errors = ref(null)
const success = ref(false)
const form = ref({
  'text': '',
})

/**
 * Отправка формы
 */
function submitForm() {
  axios.post(config.api_url + 'mails/store/' + params.modelValue.id, form.value)
    .then(() => {
      success.value = true
    })
    .catch((error) => {
      if (error.response.data.errors) {
        errors.value = error.response.data.errors;
      }
    })
}
</script>

<template>
  <div class="modal-body pt-3 pb-3 text-center">
    <div class="alert alert-danger" id="validation-messages" v-if="errors">
      {{ errors }}
    </div>
    <div class="alert alert-success" id="validation-messages" v-if="success">
      {{ errors }}
    </div>
    <form @submit.prevent="submitForm()">
      <div class="card">
        <div class="card-body add-form">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-start mb-3">
                <label for="name" class="form-label">Сообщение</label>
                <textarea-component
                  name="description"
                  id="description"
                  :rows="12"
                  :cols="200"
                  v-model="form.text"
                  class="form-control"
                ></textarea-component>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button class="btn btn-primary" @click.prevent="submitForm">Отправить</button>
          <button class="btn btn-light text-black ms-2" @click.prevent="close">Закрыть</button>
        </div>
      </div>
    </form>
  </div>
</template>
<style scoped lang="scss">
.btn {
  --bs-btn-padding-x: 2rem;
}
</style>
