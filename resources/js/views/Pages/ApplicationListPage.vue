<template>
  <admin-panel>
    Страница модерации заявок
  </admin-panel>
</template>

<script lang="ts" setup>
import AdminPanel from "@/views/Layouts/AdminPanel.vue";
import {useBreadcrumbs} from '@/composables/useBreadcrumbs'

const {init} = useBreadcrumbs()
const bread = [{
  'name': 'Оставить заявку',
  'link': '/admin',
  'active': false
}]
init(bread, false)
</script>
