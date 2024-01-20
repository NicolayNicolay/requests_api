<template>
  <div class="container-fluid">
    <div class="form-signin">
      <div class="card">
        <div class="card-body p-4">
          <form action="#" method="POST" @submit.prevent="authorize">
            <div class="logo">
              <img src="/assets/img/logo.png" alt="">
            </div>
            <div class="text-center">
              <h1 class="h2 fw-bold">Авторизация</h1>
              <div class="mb-3">
                Пожалуйста, авторизуйтесь
              </div>
            </div>
            <div class="alert alert-danger" v-if="errors">{{ errors }}</div>
            <div class="form-floating">
              <input type="email" id="email" name="email" class="form-control" v-model="form.email" required>
              <label for="email">E-mail</label>
            </div>
            <div class="form-floating">
              <input type="password" id="password" class="form-control" name="password" required v-model="form.password">
              <label for="password">Пароль</label></div>
            <div class="form-check mb-3">
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
                <router-link class="w-100 btn btn-primary" :to="{name: 'Registration'}">
                  Регистрация
                </router-link>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import {ref} from "vue"
import axios from "axios"
import {authStore} from "@/stores/authStore"
import {useRouter} from 'vue-router';

const route = useRouter();
const form = ref({
  email: '',
  password: '',
  remember: true,
})
const errors = ref(null)
const loading = ref(false)

function authorize() {
  axios.post('/api/login', form.value)
    .then(() => {
      // Check auth and redirect to homepage
      authStore()
        .checkAuth()
        .then(() => {
          route.push({name: 'ApplicationPage'})
        })
    })
    .catch((error) => {
      errors.value = error.response.data.message
    })
}
</script>

<style scoped>
input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
