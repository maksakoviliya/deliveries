<template>
  <Popper>
    <button
        type="button"
        :ref="`${order.id}_popover`"
        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="colors[order.status]"> {{ texts[order.status] }}
    </button>

    <template #content v-if="showForm">
      <div class="bg-white rounded-lg shadow-lg p-4">
        <Form :initial-values="setInitialStatus(order)" @submit="handleStatusChange" :validation-schema="schema" class="flex items-center gap-2">
          <CommonSelect name="status" :options="statuses" :value="order.status" />
          <input name="order_id" class="hidden" v-model="order.id">
          <CommonButton type="submit">
            <CheckIcon class="w-4 h-4" />
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
  name: "OrderStatus",

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
      colors: {
        processing: 'bg-gray-100 text-gray-800',
        work: 'bg-indigo-100 text-indigo-800',
        delivered: 'bg-green-100 text-green-800',
        undelivered: 'bg-red-100 text-red-800',
      },
      texts: {
        processing: 'В обработке',
        work: 'В работе',
        delivered: 'Доставлен',
        undelivered: 'Не доставлен',
      },
      statuses: [
        {
          key: 'processing',
          value: 'processing',
          label: 'В обработке'
        },
        {
          key: 'work',
          value: 'work',
          label: 'В работе'
        },
        {
          key: 'delivered',
          value: 'delivered',
          label:  'Доставлен'
        },
        {
          key: 'undelivered',
          value: 'undelivered',
          label: 'Не доставлен'
        }
      ],
      schema: {
        status: yup.string().required(),
        order_id: yup.number().required()
      }
    }
  },

  methods: {
    ...mapActions({
      setOrderStatus: "order/setOrderStatus",
      fetchOrders: "order/fetchOrders",
    }),
    async handleStatusChange(values) {
      this.setOrderStatus(values).then(() => {
        this.$notify({
          type: 'success',
          text: 'Статус заказа обновлен'
        })
        this.$refs[`${values.order_id}_popover`].click()
        this.fetchOrders()
      }).catch(() => {
        this.$notify({
          type: 'error',
          text: 'Произошла ошибка!'
        })
      })
    },
    setInitialStatus(order) {
      return {
        status: order.status,
        order_id: order.id
      }
    }
  }
}
</script>