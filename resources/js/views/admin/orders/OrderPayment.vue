<template>
  <Popper>
    <button
        type="button"
        :ref="`${order.id}_popover`"
        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="getColorOfPayment(order.payment)"> {{ getTextOfPayment(order.payment) }}
    </button>

    <template #content v-if="showForm">
      <div class="bg-white rounded-lg shadow-lg p-4">
        <Form :initial-values="setInitialPayment(order)" @submit="handlePaymentChange" :validation-schema="schema"
              class="flex items-center gap-2">
          <CommonSelect name="payment" :options="payments" :value="order.payment"/>
          <input name="order_id" class="hidden" v-model="order.id">
          <CommonButton type="submit">
            <CheckIcon class="w-4 h-4"/>
          </CommonButton>
        </Form>
      </div>
    </template>
  </Popper>
</template>

<script>
import Popper from "vue3-popper";
import CommonSelect from "../../../components/common/CommonSelect";
import CommonButton from "../../../components/common/CommonButton";
import {CheckIcon} from "@heroicons/vue/outline";
import * as yup from "yup";
import {mapActions} from "vuex";
import {Form} from "vee-validate";

export default {
  name: "OrderPayment",

  props: {
    order: {
      required: true
    },
    showForm: {
      default: true
    }
  },

  components: {
    Form,
    Popper,
    CommonSelect,
    CommonButton,
    CheckIcon,
  },

  data() {
    return {
      payments: [
        {
          key: 'pending',
          value: 'pending',
          label: 'Ожидает'
        },
        {
          key: 'payed',
          value: 'payed',
          label: 'Оплачен'
        },
      ],
      schema: {
        payment: yup.string().required(),
        order_id: yup.number().required()
      }
    }
  },

  methods: {
    ...mapActions({
      setOrderPayment: "order/setOrderPayment",
      fetchAllOrders: "order/fetchAllOrders",
    }),
    async handlePaymentChange(values) {
      this.setOrderPayment(values).then(() => {
        this.$notify({
          type: 'success',
          text: 'Статус заказа обновлен'
        })
        this.$refs[`${values.order_id}_popover`].click()
        this.fetchAllOrders()
      }).catch(() => {
        this.$notify({
          type: 'error',
          text: 'Произошла ошибка!'
        })
      })
    },
    getTextOfPayment(status) {
      switch (status) {
        case 'pending': return 'Ожидает'
        case 'payed': return 'Оплачен'
        default: return status
      }
    },
    getColorOfPayment(status) {
      switch (status) {
        case 'pending': return 'bg-gray-100 text-gray-800'
        case 'payed': return 'bg-green-100 text-green-800'
        default: return status
      }
    },
    setInitialPayment(order) {
      return {
        payment: order.payment,
        order_id: order.id
      }
    }
  }
}
</script>