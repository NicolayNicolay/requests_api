import {defineStore} from 'pinia'

export const flashMessages = defineStore('flashMessages', {
  state: () => {
    return {
      success: []
    }
  },
  getters: {},
  actions: {
    getMessages(type = 'success') {
      const messages = this[type];
      this[type] = [];
      return messages;
    },
    addMessage(message: string, type = 'success') {
      this[type].push(message);
    }
  }
})
