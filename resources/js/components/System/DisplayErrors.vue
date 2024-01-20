<template>
  <div class="alert alert-danger" id="validation-messages">
    <div v-for="(error, index) in errors" :key="index">{{ error.join(', ') }}</div>
  </div>
</template>

<script lang="ts">
export default {
  name: "DisplayErrors",
  props: {
    errors: [Object, Array]
  }
}
</script>

