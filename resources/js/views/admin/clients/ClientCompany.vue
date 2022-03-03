<template>
  <div>
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">Данные о компании</h3>
      <!--      <p class="mt-1 max-w-2xl text-sm text-gray-500">Здесь указывается ваша контактная информация.</p>-->
    </div>
    <div>
      <dl>
        <template v-for="(field, i) in fields">

          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center"
               :class="i % 2 === 0 ? 'bg-white' : 'bg-gray-100'"
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
</template>

<script>
import {CheckIcon, PaperClipIcon} from "@heroicons/vue/solid";
import CommonInput from "../../../components/common/CommonInput";
import {Form} from "vee-validate";
import {ViewGridAddIcon} from "@heroicons/vue/outline";
import CommonSelect from "../../../components/common/CommonSelect";
import CommonButton from "../../../components/common/CommonButton";
import * as yup from "yup";
import {getError} from "../../../utils/helpers";

export default {
  name: "ClientCompany",

  components: {
    PaperClipIcon,
    CommonInput,
    Form,
    CheckIcon,
    ViewGridAddIcon,
    CommonSelect,
    CommonButton
  },

  data() {
    const schema = yup.object({
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
      phone: yup.string().nullable(true),
      // phone: yup.string().nullable(true).phone(),
      mail: yup.string().nullable(true),
      kpp: yup.string().nullable(true),
      okato: yup.string().nullable(true),
      // email: yup.string().required().email(),
      // phone: yup.string().nullable(true).phone(),
      // password: yup.string().test(
      //     'empty-or-6-characters-check',
      //     'Password must be at least 6 characters',
      //     password => !password || password.length >= 6,
      // ),
      // password_confirmation: Yup.string()
      //     .when('password', {
      //       is: (val) => val,
      //       then: (schema) => schema.min(6).oneOf([yup.ref("password")], "Passwords do not match"),
      //       otherwise: (schema) => schema.min(0),
      //     }),
    });
    const fields = [
      {
        key: 'title',
        label: 'Название',
        placeholder: "Ваше имя",
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
        key: 'phone',
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

    return {
      schema,
      fields,
      company: {}
    }
  },

  methods: {
    onSubmit(values, actions) {
      console.log('ss')
      // try {
      //   if (this.company && this.company.id) {
      //     values.id = this.company.id
      //   }
      //   this.setCompany(values)
      //   this.$notify({
      //     type: 'success',
      //     title: 'Данные обновлены!',
      //   })
      // } catch (error) {
      //   const errors = getError(error)
      //   actions.setErrors(errors);
      //   this.$notify({
      //     type: 'error',
      //     title: 'Возникла ошибка!',
      //   })
      // }
    }
  }
}
</script>