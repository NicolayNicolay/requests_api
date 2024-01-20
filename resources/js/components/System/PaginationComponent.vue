<template>
  <nav v-if="paginated.total > paginated.per_page">
    <ul class="pagination mt-4">
      <template v-for="(link,index) in paginated.links" :key="index">
        <li class="page-item" v-if="index === 0">
          <a class="page-link" :class="(link.url === null)? 'disabled':''" href="#" @click.prevent="getUserList(getNewLink(link.url))" rel="next">Назад</a>
        </li>
        <template v-if="index !==0 && index!==paginated.links.length - 1">
          <li class="page-item active" aria-current="page" v-if="link.active">
            <span class="page-link">{{ link.label }}</span>
          </li>
          <li class="page-item" v-else>
            <a class="page-link" href="#" @click.prevent="getUserList(getNewLink(link.url))">
              {{ link.label }}
            </a>
          </li>
        </template>
        <li class="page-item" v-if="index===paginated.links.length - 1">
          <a class="page-link" :class="(link.url === null)? 'disabled':''" href="#" @click.prevent="getUserList(getNewLink(link.url))" rel="next">Вперед</a>
        </li>
      </template>
    </ul>
  </nav>

</template>

<script lang="ts">
export default {
  name: "PaginationComponent",
  props: {
    paginated: {},
    current_page: {},
  },
  methods: {
    getNewLink(link: any) {
      if (link !== null) {
        return link.substring(link.indexOf('=') + 1);
      }
    },
    getUserList(data: any) {
      this.$emit('updateList', data);
    }
  }
}
</script>
