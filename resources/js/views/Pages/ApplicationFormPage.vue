<template>
  <admin-panel>
    <div v-if="!loading">
      <h1 class="bd-title" id="title">Оставить заявку</h1>
      <div class="row">
        <div class="col-lg-6 col-12">
          <display-errors v-if="errors" :errors="errors"></display-errors>
          <flash-message type="success" class="mb-2"></flash-message>
          <form @submit.prevent="submitForm()">
            <div class="card">
              <div class="card-body add-form">
                <div class="row">
                  <div class="col-lg-12" v-for="(field,indexField) in form" :key="indexField">
                    <div class="row">
                      <div class="col-12 mb-3" v-if="field.id && field.type !== 'textHidden'">
                        <label :for="field.id" class="form-label">{{ field.label }}</label>
                        <input-text-component
                          v-if="field.type === 'text'"
                          :name="field.name"
                          :id="field.id"
                          v-model="field.value"
                          class="form-control"
                        ></input-text-component>
                        <textarea-component
                          v-if="field.type === 'textarea'"
                          :name="field.name"
                          :rows="8"
                          :id="field.id"
                          v-model="field.value"
                          class="form-control"
                        ></textarea-component>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button class="btn btn-primary" @click.prevent="submitForm">Сохранить</button>
                <button class="btn btn-light text-black ms-2" @click="$router.back()">Назад</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <loading-component v-else></loading-component>
  </admin-panel>
</template>

<script lang="ts" setup>
import AdminPanel from "@/views/Layouts/AdminPanel.vue"
import {useBreadcrumbs} from '@/composables/useBreadcrumbs'
import LoadingComponent from "@/components/System/LoadingComponent.vue"
import DisplayErrors from "@/components/System/DisplayErrors.vue"
import InputTextComponent from "@/components/Forms/InputTextComponent.vue"
import TextareaComponent from "@/components/Forms/TextAreaComponent.vue"
import {flashMessages} from "@/stores/flashMessagesStore"
import {onMounted, ref} from "vue"
import axios from "axios"
import {config} from "@/config";
import FlashMessage from "@/components/System/FlashMessage.vue";

const {init} = useBreadcrumbs()
const bread = [{
  'name': 'Оставить заявку',
  'link': '/admin',
  'active': false
}]
const loading = ref(true)
const form = ref([])
const errors = ref(null)
init(bread, false)


onMounted(() => {
  getForm();
})

async function getForm() {
  loading.value = true;
  await axios.get(config.api_url + 'requests/getUserForm')
    .then((response) => {
      form.value = response.data;
      errors.value = null;
    })
    .catch((error) => {
      if (error) {
        errors.value = error.response;
      }
    })
    .finally(() => {
      loading.value = false;
    });
}

/**
 * Отправка формы
 */
function submitForm() {
  loading.value = true;
  const messages = flashMessages();
  axios.post(config.api_url + 'requests/', form.value)
    .then(() => {
      errors.value = null;
      messages.addMessage('Заявка принята!', 'success');
      getForm();
    })
    .catch((error) => {
      if (error.response.data.errors) {
        errors.value = error.response.data.errors;
        setTimeout(() => {
          let validationMessages = document.getElementById('title');
          if (validationMessages) {
            validationMessages.scrollIntoView({block: "center", behavior: "smooth"});
          }
        }, 300);
      }
      loading.value = false;
    });
}

</script>
