<template>
  <div class="admin-wrapper">
    <div class="container-fluid p-0">
      <div class="bd-body">
        <div class="bd-sidebar slideout-menu slideout-menu-left" id="bd_sidebar">
          <div class="bd-logo">
            <a href="/admin" class="logo">
              <img src="/assets/img/logo.png" alt="">
            </a>
          </div>
          <div class="bd-login">
            <div class="dropdown">
              <div class="name">
                <div class="role mt-2 small" v-if="user"> {{ user.name }}</div>
              </div>
            </div>
          </div>
          <div class="scrollbar-outer">
            <div class="bd-menu">
              <ul class="nav flex-column my-admin">
                <li class="nav-item">
                  <router-link class="nav-link" :to="{name: 'ApplicationPage'}">
                    <div class="wrapper-link">
                      <span class="icon text-primary">
                        <application-icon />
                    </span>
                      Оставить заявку
                    </div>
                  </router-link>
                </li>
                <li class="nav-item" v-if="user.admin">
                  <router-link class="nav-link" :to="{name: 'ApplicationListPage'}">
                    <div class="wrapper-link">
                      <span class="icon text-primary">
                        <application-list-icon />
                    </span>
                      Заявки
                    </div>
                  </router-link>
                </li>
                <!--                Выход-->
                <li class="nav-item">
                  <a class="nav-link" href="/api/admin/logout">
                    <div class="wrapper-link">
                    <span class="icon text-primary">
                      <exit-icon/>
                    </span>
                      Выход
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <main class="bd-content" id="bd_content">
          <div class="bd-head-mobile">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12 text-center">
                  <div class="brand">
                    <div class="logo">
                      <a href="/admin" class="logo">
                        <img src="/assets/img/logo.png" alt="">
                      </a>
                    </div>
                    <a class="btn bg-light" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                      <mobile-icon/>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="content-wrapper">
            <breadcrumb-component/>
            <slot></slot>
          </div>
        </main>
      </div>
    </div>
  </div>
  <modal-component />
  <mobile-menu/>
</template>

<script lang="ts" setup>
import {authStore} from "@/stores/authStore";
import {ref} from "vue"
import ExitIcon from "@/components/Icons/ExitIcon.vue";
import MobileMenu from "@/components/Mobile/MobileMenu.vue";
import MobileIcon from "@/components/Icons/MobileIcon.vue";
import BreadcrumbComponent from "@/components/System/BreadcrumbComponent.vue";
import ApplicationIcon from "@/components/Icons/ApplicationIcon.vue";
import ApplicationListIcon from "@/components/Icons/ApplicationListIcon.vue";
import ModalComponent from "@/components/Modals/ModalComponent.vue";

const user = ref(authStore().userData)
</script>

