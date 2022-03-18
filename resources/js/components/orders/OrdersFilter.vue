<template>
  <div>
    <Form
        @submit="onSubmit"
        :validation-schema="schema"
        :initial-values="search"
        class="flex flex-col md:flex-row gap-2"
        v-slot="{ values }"
    >
      <CustomSelect :multiple="true" name="statuses" :searchable="false" placeholder="Фильтр по оплате" :clearable="true" class="w-52"
                    :value="$route.query.payment"
                    @change="handlePaymentsChange" :options="payments"/>
      <CustomSelect :multiple="true" name="statuses" :searchable="false" placeholder="Фильтр по статусу" class="w-52"
                    :value="$route.query.status"
                    @change="handleStatusesChange" :options="statuses"/>
      <div
          class="relative datepicker"
      >
        <Datepicker :model-value="setInitialDates()" @update:modelValue="handleDateChange"
                    format="dd.MM.yyyy" :auto-apply="true" name="delivery_date" locale="ru"
                    :month-change-on-scroll="false" placeholder="Фильтр по дате"
                    :range="true" teleport=".datepicker" position="left" :auto-position="false"
                    :enable-time-picker="false"
                    :alt-position="((el) => {
      return {
        top: '120%', left: 0, transform: 0
      }
    })"></Datepicker>
      </div>
      <!--      <CustomSelect :multiple="true" name="cod" placeholder="Фильтр по наложенному платежу" class="w-52"-->
      <!--                    :value="$route.query.cod"-->
      <!--                    @change="handleCodChange" :options="codes"/>-->
    </Form>
  </div>
</template>

<script>
import * as yup from "yup";
import Datepicker from 'vue3-date-time-picker';
import CommonInput from "../common/CommonInput";
import {Form} from "vee-validate";
import CommonButton from "../common/CommonButton";
import {SearchIcon} from "@heroicons/vue/outline";
import CustomSelect from "../common/CustomSelect";
import {mapActions} from "vuex";
import {omit} from "lodash";
import {DateTime} from "luxon";

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
      payments: [
        {
          label: 'Ожидает оплаты',
          value: "pending"
        },
        {
          label: "Оплачен",
          value: 'payed'
        },
      ],
    }
  },

  components: {
    Form,
    CommonInput,
    CommonButton,
    SearchIcon,
    CustomSelect,
    Datepicker
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
      this.$router.push({name: this.$route.name, query: {search: values.search}})
    },
    async handleStatusesChange(val) {
      await this.$router.push({name: this.$route.name, query: omit({...this.$route.query, status: val}, ['page'])})
      await this.fetchOrders()
    },
    async handlePaymentsChange(val) {
      await this.$router.push({name: this.$route.name, query: omit({...this.$route.query, payment: val}, ['page'])})
      await this.fetchOrders()
    },
    async handleDateChange(val) {
      console.log('val', val)
      let delivery_date = {}
      if (val) {
        delivery_date = {
          delivery_date: val.map(item => DateTime.fromJSDate(item).toFormat('dd.MM.yyyy'))
        }
      }
      let query = val ? {...this.$route.query, ...delivery_date} : {...omit(this.$route.query, ['delivery_date'])}
      await this.$router.push({
        name: this.$route.name,
        query: omit({
          ...query,
        }, ['page'])
      })
      await this.fetchOrders()
    },
    setInitialDates() {
      return  this.$route.query.delivery_date ? this.$route.query.delivery_date.map(item => DateTime.fromFormat(item, 'dd.MM.yyyy').toJSDate()) : null
    }
  }
}
</script>
