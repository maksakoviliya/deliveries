<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="fixed z-10 inset-0 overflow-y-auto" @close="handleClose">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                         leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
        </TransitionChild>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <TransitionChild as="template" enter="ease-out duration-300"
                         enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                         leave-from="opacity-100 translate-y-0 sm:scale-100"
                         leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

          <Form
              @submit="onSubmit"
              :validation-schema="schema"
              :initial-values="courier"
              class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full"
              v-slot="{ values }"
          >
            <div class="px-4 py-5 sm:px-6">
              <h3 class="text-lg leading-6 font-medium text-gray-900">Профиль курьера</h3>
              <!--      <p class="mt-1 max-w-2xl text-sm text-gray-500">Здесь указывается ваша контактная информация.</p>-->
            </div>
            <dl class="bg-gray-50 ">
              <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center"
                   v-for="(field, i) in fields"
                   :key="field.key">
                <dt class="text-sm font-medium text-gray-500">{{ field.label }}</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  <CommonInput
                      :is="field.component"
                      :name="field.key"
                      :disabled="field.disabled"
                      :type="field.type"
                      :placeholder="field.placeholder"
                  />
                </dd>
              </div>
            </dl>
            <div class="flex justify-end p-5 lg:ml-4">
                    <span class="sm:ml-3">
                      <CommonButton type="submit">
                        <template v-slot:icon>
                          <CheckIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true"/>
                        </template>
                        {{ $route.params.id === 'create' ? 'Создать' : 'Изменить' }}
                      </CommonButton>
                  </span>
            </div>
          </Form>


        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import {Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";
import CommonButton from "../../../components/common/CommonButton";
import {CheckIcon} from "@heroicons/vue/outline";
import CommonSelect from "../../../components/common/CommonSelect";
import * as yup from "yup";
import "yup-phone";
import CommonInput from "../../../components/common/CommonInput";
import {Form} from "vee-validate";
import {mapActions} from "vuex";
import ApiService from "../../../services/ApiService";

export default {
  name: "CourierForm",

  components: {
    TransitionChild,
    TransitionRoot,
    DialogOverlay,
    DialogTitle,
    Dialog,
    Form,
    CommonButton,
    CheckIcon,
    CommonSelect,
    CommonInput
  },

  data() {
    const fields = [
      {
        key: 'name',
        label: 'Имя',
        placeholder: "Имя курьера",
        type: "text"
      },
      {
        key: 'phone',
        label: 'Телефон',
        placeholder: "Конактный елефон",
        type: "text"
      },
      {
        key: 'comment',
        label: 'Комментарий',
        placeholder: "Комментарий об этом курьере",
        type: "text"
      },
    ];
    const schema = yup.object({
      name: yup.string().required(),
      phone: yup.string().required().length(11).matches(/^7\d+$/, 'Не верный формат номера'),
      comment: yup.string().nullable(true),
    });

    return {
      schema,
      fields,
      courier: {}
    }
  },

  computed: {
    open() {
      return !!this.$route.params.id
    },
  },

  methods: {
    ...mapActions({
      fetchCouriers: "courier/fetchCouriers",
      fetchCourier: "courier/fetchCourier"
    }),
    handleClose() {
      this.$router.push({name: this.$route.name, query: this.$route.query, params: {id: null}})
    },
    onSubmit(values, actions) {
      let prom = null
      if (this.$route.params.id && this.$route.params.id !== 'create') {
        prom = ApiService.updateCourier(this.$route.params.id, values)
      } else {
        prom = ApiService.createCourier(values)
      }

      prom.then(async (res) => {
        console.log('res', res)
        this.$notify({
          type: 'success',
          title: 'Данные курьеров обновлены'
        })
        await this.fetchCouriers()
        this.handleClose()
        this.$emit('close')
      })
          .catch((error) => {
            const errors = getError(error)
            actions.setErrors(errors);
            this.$notify({
              type: 'error',
              title: 'Возникла ошибка!',
            })
          });
    },
  },

  async mounted() {
    if (this.$route.params.id && this.$route.params.id !== 'create') {
      this.courier = await this.fetchCourier(this.$route.params.id)
    }
  }
}
</script>