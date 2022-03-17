<template>
  <div>
  </div>
  <Form
      @submit="onSubmit"
      :validation-schema="schema"
      :initial-values="search"
      class="flex flex-col md:flex-row gap-2"
      v-slot="{ values }"
  >
    <CustomSelect :multiple="true" name="statuses" placeholder="Фильтр по статусу" class="w-52" :value="$route.query.status"
                  @change="handleStatusesChange" :options="statuses"/>
    <CustomSelect :multiple="true" name="cod" placeholder="Фильтр по наложенному платежу" class="w-52" :value="$route.query.cod"
                  @change="handleCodChange" :options="codes"/>
  </Form>
</template>

<script>
import * as yup from "yup";
import CommonInput from "../common/CommonInput";
import {Form} from "vee-validate";
import CommonButton from "../common/CommonButton";
import {SearchIcon} from "@heroicons/vue/outline";
import CustomSelect from "../common/CustomSelect";
import {mapActions} from "vuex";
import {omit} from "lodash";

export default {
  name: "OrdersFilter",

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
      ],
      codes: [
        {
          label: "Да",
          value: 'yes'
        },
        {
          label: "Нет",
          value: 'no'
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
      await this.$router.push({name: this.$route.name, query: omit({...this.$route.query, status: val}, ['page'])})
      await this.fetchOrders()
    },
    async handleCodChange(val) {
      await this.$router.push({name: this.$route.name, query: omit({...this.$route.query, cod: val}, ['page'])})
      await this.fetchOrders()
    }
  }
}
</script>
