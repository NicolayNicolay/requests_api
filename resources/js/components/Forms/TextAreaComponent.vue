<template>
    <textarea
      v-if="disable"
      :rows="rows"
      :cols="cols"
      :id="id"
      :name="name"
      v-html="model_value"
      disabled="disabled"
      style="width: 100%; min-height: 80px;"
    ></textarea>
  <textarea
    v-else
    :id="id"
    :rows="rows"
    :cols="cols"
    :name="name"
    v-model="model_value"
    style="width: 100%; min-height: 80px;"
  ></textarea>
</template>

<script lang="ts">
export default {
  name: "TextareaComponent",
  props: {
    name: String,
    id: String,
    disable: {
      type: Boolean,
      default: false,
    },
    modelValue: {
      type: [Number, String],
      default: ''
    },
    rows: {
      type: Number,
      default: 2
    },
    cols: {
      type: Number,
      default: 200
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
