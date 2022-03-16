<template>
  <div>
  </div>
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
<!--  <CustomSelect :multiple="true" name="statuses" placeholder="Статус заказа" class="w-40" :value="$route.query.status"-->
<!--                @change="handleStatusesChange" :options="statuses"/>-->

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
import CustomSelect from "../common/CustomSelect";
import {mapActions} from "vuex";

export default {
  name: "OrdersSearch",

  data() {
    const schema = yup.object({
      search: yup.string().max(255),
    });

    return {
      schema,
      statuses: [
        {
          label: "В обработке",
          value: 'processing'
        },
        {
          label: "В работе",
          value: 'work'
        },
        {
          label: "Доставлен",
          value: 'delivered'
        },
        {
          label: "Не доставлен",
          value: 'undelivered'
        },
      ]
    }
  },

  components: {
    Form,
    CommonInput,
    CommonButton,
    SearchIcon,
    CustomSelect
  },

  computed: {
    search: {
      get() {
        return {search: this.$route.query.search}
      },
      set(val) {
        this.$router.push({name: this.$route.name, query: {search: val}})
      }
    }
  },

  methods: {
    ...mapActions({
      fetchOrders: "order/fetchOrders"
    }),
    onSubmit(values) {
      console.log('Search')
      this.$router.push({name: this.$route.name, query: {search: values.search}})
    },
    async handleStatusesChange(val) {
      await this.$router.push({name: this.$route.name, query: {...this.$route.query, status: val}})
      await this.fetchOrders()
    }
  }
}
</script>
