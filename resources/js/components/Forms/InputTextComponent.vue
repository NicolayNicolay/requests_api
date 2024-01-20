<template>
  <input :type="type"
         :id="id"
         :name="name"
         v-model="model_value"
         :disabled="disable"
  />
</template>

<script lang="ts">
export default {
  name: "InputTextComponent",
  props: {
    name: String,
    id: String,
    modelValue: {
      type: [Number, String],
      default: ''
    },
    disable: {
      type: Boolean,
      default: false
    },
    type:{
      type: String,
      default: 'text',
    }
  },
  emits: ['update:modelValue'],
  data() {
    return {
      model_value: this.modelValue,
    }
  },
  watch: {
    'model_value': function () {
      this.$emit('update:modelValue', this.model_value);
    }
  },
}
</script>
