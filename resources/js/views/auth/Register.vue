<template>
  <div class="flex flex-col items-center justify-center min-h-screen bg-zinc-200">
    <div class="mx-auto max-w-sm w-full p-10 rounded-lg bg-white shadow-md">
      <h1 class="font-bold text-lg">Регистрация</h1>
      <Form
          @submit="onSubmit"
          :validation-schema="schema"
          class="flex flex-col gap-3 mt-4"
      >
        <CommonInput
            name="name"
            type="text"
            label="Ваше имя"
            placeholder="Your Name"
        />
        <CommonInput
            name="email"
            type="email"
            label="E-mail"
            placeholder="Ваш Email"
        />
        <CommonInput
            name="password"
            type="password"
            label="Пароль"
            placeholder="Your password"
        />
        <CommonInput
            name="password_confirmation"
            type="password"
            label="Подтвердите пароль"
            placeholder="Type it again"
        />

        <button class="submit-btn block px-4 py-2 bg-violet-500 rounded-md text-white font-bold mt-4 hover:bg-violet-600 outline-none" type="submit">Зарегистрироваться</button>
      </Form>
    </div>
  </div>
</template>

<script>
import {Form} from "vee-validate";
import * as Yup from "yup";
import CommonInput from "../../components/common/CommonInput";
import AuthService from "../../services/AuthService";
import {getError} from "../../utils/helpers";

export default {
  name: "App",

  components: {
    CommonInput,
    Form,
  },

  setup() {
    function onSubmit(values, actions) {
      AuthService.registerUser(values)
          .then(() => this.$router.push({ name: 'Home'}))
          .catch((error) => {
            const errors = getError(error)
            actions.setErrors(errors);
          });
    }

    // Using yup to generate a validation schema
    // https://vee-validate.logaretm.com/v4/guide/validation#validation-schemas-with-yup
    const schema = Yup.object().shape({
      name: Yup.string().required(),
      email: Yup.string().email().required(),
      password: Yup.string().min(6).required(),
      password_confirmation: Yup.string()
          .required()
          .oneOf([Yup.ref("password")], "Passwords do not match"),
    });

    return {
      onSubmit,
      onInvalidSubmit,
      schema,
    };
  },
};
</script>
