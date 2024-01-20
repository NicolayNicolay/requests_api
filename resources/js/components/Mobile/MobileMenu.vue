<template>
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">
        <a href="/admin" class="logo">
          <img src="/assets/img/logo.png" alt="">
        </a>
      </h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav flex-column my-admin">
        <li class="nav-item">
          <a class="nav-link" href="/admin">
            <div class="wrapper-link">
              Оставить заявку
            </div>
          </a>
        </li>
        <li class="nav-item" v-if="user.admin">
          <a class="nav-link" href="/admin/list">
            <div class="wrapper-link">
              Заявки
            </div>
          </a>
        </li>
        <!--                Выход-->
        <li class="nav-item">
          <a class="nav-link" href="/api/admin/logout">
            <div class="wrapper-link">
              Выход
            </div>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>
<script lang="ts" setup>
import {authStore} from "@/stores/authStore";
import {ref} from "vue"
const user = ref(authStore().userData)
</script>

<style scoped>
.offcanvas {
  --bs-link-color: black;
}
</style>
