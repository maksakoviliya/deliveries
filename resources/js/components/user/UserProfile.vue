<template>
  <div class="bg-white shadow overflow-hidden rounded-lg">
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">Профиль пользователя</h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500">Здесь указывается ваша контактная информация.</p>
    </div>
    <Form
        @submit="onSubmit"
        :validation-schema="schema"
        :initial-values="authUser"
        class="border-t border-gray-200"
    >
      <dl>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center" :class="i % 2 === 0 ? 'bg-white' : 'bg-gray-100'" v-for="(field, i) in fields"
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
          <CommonButton>
            <template v-slot:icon>
              <CheckIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true"/>
            </template>
            Изменить
          </CommonButton>
      </span>
      </div>
    </Form>
  </div>
</template>

<script>
import {CheckIcon, PaperClipIcon} from '@heroicons/vue/solid'
import {mapActions, mapGetters} from "vuex";
import * as yup from 'yup';
import CommonInput from "../common/CommonInput";
import {Form} from "vee-validate";
import "yup-phone";
import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";
import CommonButton from "../common/CommonButton";

export default {
  components: {
    PaperClipIcon,
    CommonInput,
    Form,
    CheckIcon,
    CommonButton
  },

  data() {
    const schema = yup.object({
      name: yup.string().required(),
      // phone: yup.string().nullable(true).phone(),
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
      user: this.authUser,
      schema,
      fields: [
        {
          key: 'name',
          label: 'Имя',
          placeholder: "Ваше имя",
          type: "text"
        },
        {
          key: 'phone',
          label: 'Телефон',
          disabled: true,
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

  computed: {
    ...mapGetters({
      authUser: "auth/authUser"
    }),
  },

  methods: {
    ...mapActions({
      getAuthUser: "auth/getAuthUser"
    }),
    onSubmit(values, actions) {
      ApiService.updateUser(values)
          .then(() => {
            this.getAuthUser()
            this.$notify({
              type: 'success',
              title: 'Профиль обновлен'
            })
          })
          .catch((error) => {
            const errors = getError(error)
            actions.setErrors(errors);
            this.$notify({
              type: 'error',
              title: 'Возникла ошибка!',
            })
          });
    }
  }
}
</script>