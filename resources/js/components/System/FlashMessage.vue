<template>
  <div class="row mt-4" v-if="message.length > 0">
    <div class="col-lg-8">
      <div class="alert alert-success" role="alert">
        <span>{{ message.join(', ') }}</span>
        <a class="msg_main_close" @click="closeMessage()">&nbsp;</a>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {flashMessages} from "@/stores/flashMessagesStore";

export default {
  name: "FlashMessage",
  props: {
    type: {
      type: String,
      default: 'success'
    }
  },
  data() {
    const messages = flashMessages();
    return {
      message: messages.getMessages(this.type),
    }
  },
  methods: {
    closeMessage() {
      this.message = [];
    },
  },
}
</script>
