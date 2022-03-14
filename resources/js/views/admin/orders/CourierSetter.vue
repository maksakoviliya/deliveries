<template>
  <Popper>
    <button
        type="button"
        :ref="`${order.id}_courier_popover`"
        class="text-xs text-gray-500">
      {{ order.courier ? order.courier.name : 'Не назначен' }}
    </button>

    <template #content>
      <div class="bg-white rounded-lg shadow-lg p-4">
        <Form :initial-values="setInitialCourier(order)" @submit="handleStatusChange" :validation-schema="schema"
              class="flex items-center gap-2">
          <CustomSelect name="courier_id" :value="order.courier ? order.courier.id : null" :options="couriers" label-key="name" value-key="id" />
          <input name="order_id" class="hidden" v-model="order.id">
          <CommonButton>
            <CheckIcon class="w-4 h-4" />
          </CommonButton>
        </Form>
      </div>
    </template>
  </Popper>
</template>

<script>
import Popper from "vue3-popper";
import 'vue-select/dist/vue-select.css';
import {mapActions, mapGetters} from "vuex";
import CommonButton from "../../../components/common/CommonButton";
import {CheckIcon} from "@heroicons/vue/outline";
import {Form} from "vee-validate";
import * as yup from "yup";
import CustomSelect from "../../../components/common/CustomSelect";

export default {
  name: "CourierSetter",

  props: {
    order: {
      required: true
    }
  },

  components: {
    CustomSelect,
    Form,
    Popper,
    CommonButton,
    CheckIcon,
  },

  data() {
    return {
      schema: {
        courier_id: yup.number().required(),
        order_id: yup.number().required()
      }
    }
  },

  computed: {
    ...mapGetters({
      couriers: "courier/couriers"
    })
  },

  methods: {
    ...mapActions({
      setOrderCourier: "order/setOrderCourier",
      fetchAllOrders: "order/fetchAllOrders",
    }),
    setInitialCourier(order) {
      return {
        courier_id: order.courier ? order.courier.id : null,
        order_id: order.id
      }
    },
    async handleStatusChange(values) {
      this.setOrderCourier(values).then(() => {
        this.$notify({
          type: 'success',
          text: 'Данные заказа обновлены'
        })
        this.$refs[`${values.order_id}_courier_popover`].click()
        this.fetchAllOrders()
      })
    },
  }
}
</script>
