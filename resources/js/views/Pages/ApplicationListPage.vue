<template>
  <admin-panel>
    <flash-message type="success" class="mb-2"></flash-message>
    <h1 class="bd-title">Список заявок</h1>
    <template v-if="!loading">
      <div class="row">
        <div class="col-6 col-lg-2">
          <div class="filter-container">
            <div class="show-filter">
              <button class="btn btn-primary btn-block btn-sm" @click.prevent="filterShow = !filterShow" data-bs-toggle="collapse" data-bs-target="#filter-panel" aria-expanded="true" aria-controls="filter-panel">
                <i class="fas fa-filter me-1"></i>Фильтр
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div id="filter-panel" class="accordion-collapse collapse mt-3" :class="filterShow ? 'show': ''" aria-labelledby="panelsStayOpen-headingOne">
            <div class="card">
              <div class="card-body">
                <form action="">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="mb-3">
                        <div class="row">
                          <div class="col-lg-6">
                            <label for="filterUploadDateStart" class="form-label">Дата операции</label>
                            <input type="date" class="form-control form-control-sm" id="created_at_start" name="created_at_start" v-model="filter.created_at_start">
                          </div>
                          <div class="col-lg-6">
                            <label for="filterUploadDateEnd" class="form-label">&nbsp;</label>
                            <input type="date" class="form-control form-control-sm" id="created_at_end" name="created_at_end" v-model="filter.created_at_end">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-6">
                        <div class="form-check d-flex">
                          <input class="form-check-input" type="checkbox" v-model="filter.moderation" id="flexCheckDefault">
                          <label class="form-check-label ms-2 align-text-bottom" for="flexCheckDefault">
                            На модерации
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="row">
                          <div class="col-6">
                            <button class="btn btn-primary w-100" type="submit" @click.prevent="filterObject">
                              Показать
                            </button>
                          </div>
                          <div class="col-6">
                            <button class="btn btn-light w-100 text-black" @click.prevent="clearFilter">
                              Сбросить
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-8">
          <div class="parts-wrapper">
            <table class="table table-parts table-sm table-bordered table-hover">
              <thead class="table-light">
              <tr>
                <th scope="col" width="3%">ID</th>
                <th scope="col" width="7%">Название</th>
                <th scope="col" width="50%">Текст</th>
                <th scope="col" width="15%">Статус</th>
                <th scope="col" width="20%">Дата создания</th>
                <th scope="col" width="5%">Действия</th>
              </tr>
              </thead>
              <tbody class="parts table-group-divider">
              <template v-if="data.length > 0">
                <tr v-for="(object,index) in data" :key="index">
                  <td>{{ object.id }}</td>
                  <td>
                    {{ object.name }}
                  </td>
                  <td>{{ object.short_text }}</td>
                  <td>{{ object.status_name }}</td>
                  <td>{{ object.created_at }}</td>
                  <td class="text-center">
                    <router-link class="me-2" :to="{name: 'EditApplicationForm', params: {id: object.id}}" title="Редактировть">
                      <edit-icon class="move-icon"></edit-icon>
                    </router-link>
                    <a href="#" title="Удалить" @click.prevent="removeItemModal(object.id)">
                      <delete-icon class="move-icon"></delete-icon>
                    </a>
                  </td>
                </tr>
              </template>
              <template v-else>
                <tr>
                  <td colspan="6" class="text-center">
                    Заявки не найдены
                  </td>
                </tr>
              </template>
              </tbody>
            </table>
            <pagination-component :paginated="data" :current-page="page" @updateList="getData"></pagination-component>
          </div>
        </div>
      </div>
    </template>
    <loading-component v-else></loading-component>
  </admin-panel>
</template>

<script lang="ts" setup>
import AdminPanel from "@/views/Layouts/AdminPanel.vue";
import {useBreadcrumbs} from '@/composables/useBreadcrumbs'
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import PaginationComponent from "@/components/System/PaginationComponent.vue";
import DeleteIcon from "@/components/Icons/DeleteIcon.vue";
import EditIcon from "@/components/Icons/EditIcon.vue";
import FlashMessage from "@/components/System/FlashMessage.vue";
import {onMounted, ref} from "vue"
import {useModal} from "@/composables/useModal"
import SuccessModal from '@/components/Modals/SuccessModal.vue'
import axios from "axios"
import {config} from "@/config";

const {init} = useBreadcrumbs()
const bread = [{
  'name': 'Список заявок',
  'link': '/admin',
  'active': false
}]
const loading = ref(false)
const data = ref([])
const errors = ref(null)
const page = ref(1)
const modal = useModal()
const filter = ref({
  moderation: false,
  created_at_start: '',
  created_at_end: '',
})
const filterShow = ref(false)

init(bread, false)

onMounted(() => {
  getData()
})

//Functions
function filterObject() {
  filterShow.value = !filterShow.value
  getData()
}

function clearFilter() {
  filter.value = {
    created_at_start: '',
    created_at_end: '',
    moderation: false,
  };
  getData()
}

async function getData(page = 1) {
  loading.value = true
  await axios.get(config.api_url + 'requests/', {
    params: {
      page: page,
      ...filter.value,
    }
  })
    .then((response) => {
      data.value = response.data.data;
      console.log(data.value);
    })
    .catch((error) => {
      if (error) {
        errors.value = error.response;
      }
    })
    .finally(() => {
      loading.value = false;
    });
}

function removeItemModal(id: number) {
  modal.open({
    component: SuccessModal,
    modelValue: {
      title: 'Вы действительно хотите удалить данный объект?',
      subTitle: 'Вы уверены?',
      function: async () => {
        await removeItem(id)
      },
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

async function removeItem(id: number) {
  await axios.get(config.api_url + 'requests/remove/' + id)
    .then(() => {
      getData();
    })
    .catch((error) => {
      if (error) {
        errors.value = error.response;
      }
    });
}
</script>
