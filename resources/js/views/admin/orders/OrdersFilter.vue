<template>
  <div>
  </div>
  <Form
      @submit="onSubmit"
      :validation-schema="schema"
      :initial-values="search"
      class="flex gap-2"
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
import {Form} from "vee-validate";
import {SearchIcon} from "@heroicons/vue/outline";
import {mapActions} from "vuex";
import CommonInput from "../../../components/common/CommonInput";
import CommonButton from "../../../components/common/CommonButton";
import CustomSelect from "../../../components/common/CustomSelect";
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
