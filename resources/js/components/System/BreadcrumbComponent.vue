<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <template v-for="(value,index) in breadCrumb" :key="index">
        <li v-if="value.active" class="breadcrumb-item">
          <a :href="value.link">{{ value.name }}</a>
        </li>
        <li v-else class="breadcrumb-item active">{{ value.name }}</li>
      </template>
    </ol>
  </nav>
</template>

<script lang="ts" setup>

import {useBreadcrumbs} from '@/composables/useBreadcrumbs'
import {onMounted} from "vue";

const {breadCrumb} = useBreadcrumbs()

onMounted(() => {

});
// export default {
//   name: "BreadcrumbComponent",
//   props: {
//     data: {
//       type: Array,
//       default: null
//     },
//   },
//   mounted() {
//     if (this.data) {
//       this.breadCrumb = [...this.breadCrumb, ...this.data];
//
//     }
//   },
//   data() {
//     return {
//       breadCrumb: [{
//         'name': 'Главная',
//         'link': '/admin',
//         'active': true
//       }],
//     }
//   }
// }
</script>

<style scoped>

</style>
