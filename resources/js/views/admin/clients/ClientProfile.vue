<template>
  <div>
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">Профиль пользователя</h3>
<!--      <p class="mt-1 max-w-2xl text-sm text-gray-500">Здесь указывается ваша контактная информация.</p>-->
    </div>
      <dl>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center"
             :class="i % 2 === 0 ? 'bg-white' : 'bg-gray-100'" v-for="(field, i) in fields"
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
</template>

<script>
import CommonInput from "../../../components/common/CommonInput";
import {Form} from "vee-validate";
import CommonButton from "../../../components/common/CommonButton";
import * as yup from 'yup';
import "yup-phone";
import {CheckIcon} from "@heroicons/vue/outline";
import ApiService from "../../../services/ApiService";
import {getError} from "../../../utils/helpers";
import {mapActions} from "vuex";

const emptyClient = {
  name: "",
  phone: "",
  email: "",
  password: "",
  password_confirmation: "",
}

export default {
  name: "ClientProfile",

  components: {
    CommonInput,
    Form,
    CommonButton,
    CheckIcon
  },

  data() {
    const schema = yup.object({
      name: yup.string().required(),
      email: yup.string().required().email(),
      phone: yup.string().required().length(11).matches(/^7\d+$/, 'Не верный формат номера'),
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
    });

    return {
      client: emptyClient,
      schema,
      fields: [
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
      ]
    }
  },

  methods: {
    ...mapActions({
      fetchClient: "client/fetchClient"
    }),
    onSubmit(values, actions) {
      //   ApiService.updateUser(values)
      //       .then(() => {
      //         this.getAuthUser()
      //         this.$notify({
      //           type: 'success',
      //           title: 'Профиль обновлен'
      //         })
      //       })
      //       .catch((error) => {
      //         const errors = getError(error)
      //         actions.setErrors(errors);
      //         this.$notify({
      //           type: 'error',
      //           title: 'Возникла ошибка!',
      //         })
      //       });
    },
    setClient() {
      if (this.$route.params.id && this.$route.params.id !== 'create') {
        this.fetchClient(this.$route.params.id)
          .then(res => {
            this.client = res
          })
      }
    }
  },

  async mounted() {
    await this.setClient()
  }
}
</script>
