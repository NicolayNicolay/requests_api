import {markRaw, reactive, ref, shallowRef} from 'vue'

interface ModalConfig {
  component: object
  title?: string
  subTitle?: string
  modelValue?: any
  classes?: string
  verticalCentered?: boolean
  withTopMargin?: boolean // Добавляет отступ вверху для мобилок. Полезно на небольших модальных окнах
}

interface ModalParams {
  title: string
  subTitle: string,
  classes: string
  verticalCentered: boolean
  withTopMargin: boolean
  isOpen: boolean
  modelValue: any
}

const view = shallowRef<any>({})
const modalInstance = ref<any>(null)

const params = reactive<ModalParams>({
  title: '',
  subTitle: '',
  classes: '',
  verticalCentered: false,
  withTopMargin: false,
  isOpen: false,
  modelValue: {},
})

function init(modal: any) {
  modalInstance.value = modal
}

function open(config: ModalConfig) {
  modalInstance.value.show()
  view.value = markRaw(config.component)

  // Дополнительные параметры
  params.title = config?.title ?? ''
  params.subTitle = config?.subTitle ?? ''
  params.isOpen = true
  params.classes = config?.classes ?? ''
  params.verticalCentered = config?.verticalCentered ?? false
  params.withTopMargin = config?.withTopMargin ?? false
  params.modelValue = config?.modelValue ?? {}

}

function close() {
  modalInstance.value.hide()
}

export const useModal = () => {
  return {
    view,
    params,
    close,
    open,
    init,
  }
}
