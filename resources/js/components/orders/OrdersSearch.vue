<template>
  <div>Тут будет фильтр</div>
<!--  <Form-->
<!--      @submit="onSubmit"-->
<!--      :validation-schema="schema"-->
<!--      :initial-values="search"-->
<!--      class="flex gap-2"-->
<!--      v-slot="{ values }"-->
<!--  >-->
<!--    <CommonInput-->
<!--        name="search"-->
<!--        type="text"-->
<!--        placeholder="Поиск по заказам"-->
<!--    />-->
<!--    <CommonButton>-->
<!--      <template v-slot:icon>-->
<!--        <SearchIcon class="-ml-1 mr-2 h-5 w-5"></SearchIcon>-->
<!--      </template>-->
<!--      Поиск-->
<!--    </CommonButton>-->
<!--  </Form>-->
</template>

<script>
import * as yup from "yup";
import CommonInput from "../common/CommonInput";
import {Form} from "vee-validate";
import CommonButton from "../common/CommonButton";
import {SearchIcon} from "@heroicons/vue/outline";

export default {
  name: "OrdersSearch",

  data() {
    const schema = yup.object({
      search: yup.string().max(255),
    });

    return {
      schema
    }
  },

  components: {
    Form,
    CommonInput,
    CommonButton,
    SearchIcon
  },

  computed: {
    search: {
      get() {
        return { search: this.$route.query.search }
      },
      set(val) {
        this.$router.push({ name: this.$route.name, query: { search: val } })
      }
    }
  },

  methods: {
    onSubmit(values) {
      console.log('Search')
      this.$router.push({ name: this.$route.name, query: { search: values.search } })
    }
  }
}
</script>
