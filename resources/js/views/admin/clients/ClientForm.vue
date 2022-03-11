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
              :initial-values="client"
              class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full"
              v-slot="{ values }"
          >
            <div class="flex items-stretch">
              <div class="flex-1">
                <div class="px-4 py-5 sm:px-6">
                  <h3 class="text-lg leading-6 font-medium text-gray-900">Профиль пользователя</h3>
                  <!--      <p class="mt-1 max-w-2xl text-sm text-gray-500">Здесь указывается ваша контактная информация.</p>-->
                </div>
                <dl class="h-[40vh] overflow-auto bg-gray-50 ">
                  <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center"
                       v-for="(field, i) in userFields"
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
              </div>
              <div class="flex-1">
                <div class="px-4 py-5 sm:px-6">
                  <h3 class="text-lg leading-6 font-medium text-gray-900">Данные о компании</h3>
                  <!--      <p class="mt-1 max-w-2xl text-sm text-gray-500">Здесь указывается ваша контактная информация.</p>-->
                </div>
                <div>
                  <dl class="h-[40vh] overflow-auto bg-gray-50 ">
                    <template v-for="(field, i) in companyFields">

                      <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center"

                           v-if="!values['type'] || field.for.includes(values['type'])" :key="field.key">
                        <dt class="text-sm font-medium text-gray-500">{{ field.label }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                          <CommonInput
                              v-if="field.type !== 'select'"
                              :is="field.component"
                              :name="field.key"
                              :type="field.type"
                              :placeholder="field.placeholder"
                          />
                          <CommonSelect
                              v-else
                              :is="field.component"
                              :name="field.key"
                              :options="field.options"
                          />
                        </dd>
                      </div>
                    </template>
                  </dl>
                </div>
              </div>
              <div class="flex-1">
                <div class="px-4 py-5 sm:px-6">
                  <h3 class="text-lg leading-6 font-medium text-gray-900">Тариф</h3>
                  <!--      <p class="mt-1 max-w-2xl text-sm text-gray-500">Здесь указывается ваша контактная информация.</p>-->
                </div>
                <dl class="h-[40vh] overflow-auto bg-gray-50 ">
                  <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center"
                       v-for="(field, i) in tarifFields"
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
              </div>
            </div>

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
import ClientProfile from "./ClientProfile";
import ClientCompany from "./ClientCompany";
import CommonButton from "../../../components/common/CommonButton";
import {CheckIcon} from "@heroicons/vue/outline";
import CommonSelect from "../../../components/common/CommonSelect";
import * as yup from "yup";
import CommonInput from "../../../components/common/CommonInput";
import {Form} from "vee-validate";
import ApiService from "../../../services/ApiService";
import {getError} from "../../../utils/helpers";
import {mapActions} from "vuex";
import {omit} from "lodash";

export default {
  name: "ClientForm",

  components: {
    TransitionChild,
    TransitionRoot,
    DialogOverlay,
    DialogTitle,
    Dialog,
    Form,
    ClientProfile,
    ClientCompany,
    CommonButton,
    CheckIcon,
    CommonSelect,
    CommonInput
  },

  data() {
    const companyFields = [
      {
        key: 'title',
        label: 'Название',
        placeholder: "Название организации",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'type',
        label: 'Тип юр. лица',
        type: "select",
        for: ['ip', 'ooo'],
        options: [
          {
            key: 'ip',
            label: "ИП",
            value: 'ip'
          },
          {
            key: 'ooo',
            label: "ООО",
            value: 'ooo'
          },
        ]
      },
      {
        key: 'long_title',
        label: 'Полное наименование организации',
        placeholder: "Полное наименование организации",
        type: "text",
        for: ['ooo'],
      },
      {
        key: 'opf',
        label: 'ОПФ',
        placeholder: "ОПФ",
        for: ['ooo'],
        type: "text"
      },
      {
        key: 'inn',
        label: 'ИНН',
        placeholder: "ИНН",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'ogrn',
        label: 'ОГРН',
        placeholder: "ОГРН",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'okpo',
        label: 'ОКПО',
        placeholder: "ОКПО",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'address',
        label: 'Адрес',
        placeholder: "Адрес",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'oktmo',
        label: 'ОКТМО',
        placeholder: "ОКТМО",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'okved',
        label: 'ОКВЕД',
        placeholder: "ОКВЕД",
        type: "text",
        for: ['ip'],
      },
      {
        key: 'pfr',
        label: 'ПФР',
        placeholder: "ПФР",
        type: "text",
        for: ['ip'],
      },
      {
        key: 'rs',
        label: 'Рассч.счет',
        placeholder: "Рассч.счет",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'bank',
        label: 'Банк',
        placeholder: "Банк",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'bank_address',
        label: 'Адрес банка',
        placeholder: "Адрес банка",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'bik',
        label: 'БИК',
        placeholder: "БИК",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'ks',
        label: 'КС',
        placeholder: "КС",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'company_phone',
        label: 'Телефон',
        placeholder: "Телефон",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'mail',
        label: 'Почта',
        placeholder: "Почта",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'kpp',
        label: 'КПП',
        placeholder: "КПП",
        type: "text",
        for: ['ip', 'ooo'],
      },
      {
        key: 'okato',
        label: 'ОКАТО',
        placeholder: "ОКАТО",
        type: "text",
        for: ['ooo'],
      },
    ];
    const userFields = [
      {
        key: 'name',
        label: 'Имя',
        placeholder: "Ваше имя",
        type: "text"
      },
      {
        key: 'email',
        label: 'Email',
        placeholder: "Ваш Email",
        type: "text"
      },
      {
        key: 'phone',
        label: 'Телефон',
        placeholder: "Ваш телефон",
        type: "text"
      },
      {
        key: 'password',
        label: 'Пароль',
        placeholder: "Новый пароль",
        type: "password"
      },
      {
        key: 'password_confirmation',
        label: 'Пароль еще раз',
        placeholder: "Новый пароль еще раз",
        type: "password"
      },
    ];
    const tarifFields = [
      {
        key: 'foot_today',
        label: 'Пешая - сегодня (₽)',
        placeholder: "Стоимость доставки",
        type: "text"
      },
      {
        key: 'foot',
        label: 'Пешая (₽)',
        placeholder: "Стоимость доставки",
        type: "text"
      },
      {
        key: 'car_today',
        label: ' Авто - сегодня (₽)',
        placeholder: "Стоимость доставки",
        type: "text"
      },
      {
        key: 'car',
        label: 'Авто (₽)',
        placeholder: "Стоимость доставки",
        type: "text"
      },
    ];
    const schema = yup.object({
      name: yup.string().required(),
      email: yup.string().required().email(),
      phone: yup.string().nullable(true).phone(),
      password: yup.string().test(
          'empty-or-6-characters-check',
          'Password must be at least 6 characters',
          password => !password || password.length >= 6,
      ),
      password_confirmation: yup.string()
          .when('password', {
            is: (val) => val,
            then: (schema) => schema.min(6).oneOf([yup.ref("password")], "Passwords do not match"),
            otherwise: (schema) => schema.min(0),
          }),

      title: yup.string().required().max(255),
      type: yup.string().required().max(10),
      long_title: yup.string().nullable(true),
      opf: yup.string().nullable(true),
      inn: yup.string().nullable(true),
      ogrn: yup.string().nullable(true),
      okpo: yup.string().nullable(true),
      address: yup.string().nullable(true),
      oktmo: yup.string().nullable(true),
      okved: yup.string().nullable(true),
      pfr: yup.string().nullable(true),
      rs: yup.string().nullable(true),
      bank: yup.string().nullable(true),
      bank_address: yup.string().nullable(true),
      bik: yup.string().nullable(true),
      ks: yup.string().nullable(true),
      company_phone: yup.string().nullable(true),
      mail: yup.string().nullable(true),
      kpp: yup.string().nullable(true),
      okato: yup.string().nullable(true),

      foot_today: yup.number().min(0).max(99999).nullable(true),
      foot: yup.number().min(0).max(99999).nullable(true),
      car_today: yup.number().min(0).max(99999).nullable(true),
      car: yup.number().min(0).max(99999).nullable(true),
    });

    return {
      schema,
      companyFields,
      userFields,
      tarifFields,
      client: {
        foot_today: null,
        foot: null,
        car_today: null,
        car: null,
      }
    }
  },

  computed: {
    open() {
      return !!this.$route.params.id
    },
  },

  methods: {
    ...mapActions({
      fetchClients: "client/fetchClients",
      fetchClient: "client/fetchClient"
    }),
    handleClose() {
      this.$router.push({name: this.$route.name, query: this.$route.query, params: {id: null}})
    },
    onSubmit(values, actions) {
      let prom = null
      if (this.$route.params.id && this.$route.params.id !== 'create') {
        prom = ApiService.updateClient(this.$route.params.id, values)
      } else {
        prom = ApiService.createClient(values)
      }

      prom.then(async (res) => {
        console.log('res', res)
        this.$notify({
          type: 'success',
          title: 'Данные клиентов обновлены'
        })
        await this.fetchClients()
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
      let data = await this.fetchClient(this.$route.params.id)
      this.client = {
        ...omit(data, ['company', 'tarif']),
        ...omit(data.company, ['phone']),
        ...data.tarif,
        'company_phone': data.company ? data.company.phone : null
      }
    }
  }
}
</script>
