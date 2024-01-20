import {reactive, ref} from 'vue'

interface breadcrumbsParams {
  items: object
}

const breadCrumb: any = ref([])
const mainBreadCrumb = ref({
  'name': 'Главная',
  'link': '/admin',
  'active': true
})
const params = reactive<breadcrumbsParams>({
  items: {},
})

function init(items: any, mainActive: boolean = true) {
  mainBreadCrumb.value.active = mainActive
  breadCrumb.value = [mainBreadCrumb.value, ...items]
}

export const useBreadcrumbs = () => {
  return {
    breadCrumb,
    init,
  }
}
