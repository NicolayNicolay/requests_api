<template>
  <div class="container-fluid">
    <div class="form-signin">
      <div class="card">
        <div class="card-body p-4">
          <form action="#" method="POST" @submit.prevent="register">
            <div class="logo">
              <img src="/assets/img/logo.png" alt="">
            </div>
            <div class="text-center">
              <h1 class="h2 fw-bold">Регистрация</h1>
              <div class="mb-3">
                Пожалуйста, зарегистрируйтесь
              </div>
            </div>
            <display-errors :errors="errors" v-if="errors" :key="key"></display-errors>
            <div class="form-floating">
              <input type="text" id="name" name="name" class="form-control" v-model="form.name" required>
              <label for="name">ФИО</label>
            </div>
            <div class="form-floating mt-2">
              <input type="email" id="email" name="email" class="form-control" v-model="form.email" required>
              <label for="email">E-mail</label>
            </div>
            <div class="form-floating mt-2">
              <input type="password" id="password" class="form-control" name="password" required v-model="form.password">
              <label for="password">Пароль</label></div>
            <div class="form-check mt-3 mb-3">
              <input id="rememberInput" name="remember" class="form-check-input cursor-pointer" type="checkbox" value="0" v-model="form.remember">
              <label class="form-check-label cursor-pointer" for="rememberInput">Запомнить меня</label>
            </div>
            <div class="row mt-4">
              <div class="col-6">
                <button type="submit" class="w-100 btn btn-primary" :disabled="loading">
                  Войти
                </button>
              </div>
              <div class="col-6">
                <button class="w-100 btn btn-primary ms-2" @click="$router.back()">
                  Назад
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import axios from "axios";
import {authStore} from "@/stores/authStore";
import {ref} from "vue"
import {useRouter} from 'vue-router';
import DisplayErrors from "@/components/System/DisplayErrors.vue";

const route = useRouter();
const form = ref({
  name: '',
  email: '',
  password: '',
  remember: true,
})
const errors = ref(null)
const loading = ref(false)
const key = ref(0)

function register() {
  loading.value = true
  axios.post('/api/admin/register', form.value)
    .then(() => {
      // Check auth and redirect to homepage
      authStore()
        .checkAuth()
        .then(() => {
          route.push({name: 'ApplicationPage'})
        })
    })
    .catch((error) => {
      errors.value = error.response.data.errors
    }).finally(() => {
    loading.value = false;
  })
}

</script>

<style scoped>
</style>
