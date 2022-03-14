<template>
  <div class="py-8 px-12 w-full h-full">

    <div>
      <h1 class="text-gray-900 font-semibold text-2xl">Список заказов</h1>
    </div>
    <div
        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-6 py-4 bg-white mt-5 flex gap-4 justify-between items-center">
      Тут будет фильтр
    </div>
    <div class="flex flex-col mt-5">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-bottom inline-block min-w-full sm:px-6 lg:px-8">
          <div v-if="orders.length" class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  ID
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Пользователь
                </th>
                <!--                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
                <!--                  Время доставки-->
                <!--                </th>-->
                <!--                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
                <!--                  Наложенный платеж-->
                <!--                </th>-->
                <!--                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
                <!--                  Тип оплаты-->
                <!--                </th>-->
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Курьер
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Стоимость доставки
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  АПП
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Статус
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="order in orders" :key="order.id">
                <td class="px-6 py-2 whitespace-nowrap">
                  {{ order.id }}
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">
                    <div class="text-sm font-medium text-gray-900">
                      {{ order.client.name }}
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ order.client.phone }}
                    </div>
                  </div>
                </td>
                <!--                <td class="px-6 py-2">-->
                <!--                  <div class="text-xs text-gray-500">{{ `${parseDate(order.delivery_interval[0])} - ${parseDate(order.delivery_interval[1])}`  }}</div>-->
                <!--                </td>-->
                <!--                <td class="px-6 py-2">-->
                <!--                  <div class="text-xs text-gray-500">{{ order.cod ? 'Да' : 'Нет'  }}</div>-->
                <!--                </td>-->
                <!--                <td class="px-6 py-2">-->
                <!--                  <div class="text-xs text-gray-500">{{ order.payment_type === 'card' ? 'Карта' : 'Безнал'  }}</div>-->
                <!--                </td>-->
                <td class="px-6 py-2">
                  <CourierSetter :order="order"/>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.price ? `${order.price}₽` : '' }}</div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.act_id }}</div>
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                  <OrderStatus :order="order"/>
                </td>
                <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex gap-2">
                    <router-link :to="{name: $route.name, params: { id: order.id }, query: $route.query}"
                                 class="text-indigo-600 hover:text-indigo-900">
                      <PencilAltIcon class="w-4 h-4"/>
                    </router-link>
                    <button @click="showModalDeleteForm(order)" class="text-red-600 hover:text-red-900">
                      <TrashIcon class="w-4 h-4"/>
                    </button>
                  </div>
                </td>
              </tr>
              </tbody>
              <tfoot class="bg-gray-50">
              <tr>
                <th colspan="9" scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Тут будет пагинация
                </th>
              </tr>
              </tfoot>
            </table>
          </div>
          <div class="text-3xl my-16 font-semibold text-gray-300 text-center" v-else>
            Заказов пока нет
          </div>
        </div>
      </div>
    </div>

    <OrderForm :key="$route.params.id"/>

    <DeleteConfirmation :open="showDeleteConfirmation" @submit="handleDelete" @close="handleCloseDeleteForm">
      <template v-slot:title>Удаление заказа!</template>
      <template v-slot:description>Вы действительно хотите безвозвратно удалить заказ? Заказ также перестанет
        отображаться и у клиента.
      </template>
    </DeleteConfirmation>

  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {DateTime} from "luxon";
import {CheckIcon, PencilAltIcon, TrashIcon} from "@heroicons/vue/outline";
import DeleteConfirmation from "../../../components/orders/DeleteConfirmation";
import ApiService from "../../../services/ApiService";
import {getError} from "../../../utils/helpers";
import OrderForm from "./OrderForm";
import CommonSelect from "../../../components/common/CommonSelect";
import {Form} from "vee-validate";
import CommonButton from "../../../components/common/CommonButton";
import OrderStatus from "./OrderStatus";
import CourierSetter from "./CourierSetter";

export default {
  name: "OrdersList",

  components: {
    PencilAltIcon,
    TrashIcon,
    DeleteConfirmation,
    OrderForm,
    CommonSelect,
    Form,
    CheckIcon,
    CommonButton,
    OrderStatus,
    CourierSetter
  },

  computed: {
    ...mapGetters({
      orders: "order/allOrders"
    })
  },

  data() {
    return {
      showDeleteConfirmation: false,
      deletingItem: null,
    }
  },

  methods: {
    ...mapActions({
      fetchAllOrders: "order/fetchAllOrders",
      fetchCouriers: "courier/fetchCouriers"
    }),
    parseDate(date) {
      return DateTime.fromISO(date).toFormat('dd.MM.yy HH:mm')
    },
    showModalDeleteForm(client) {
      this.deletingItem = client
      this.showDeleteConfirmation = true
    },
    handleCloseDeleteForm() {
      this.deletingItem = null
      this.showDeleteConfirmation = false
    },
    handleDelete() {
      ApiService.removeOrder(this.deletingItem.id).then(async () => {
        this.$notify({
          type: 'warning',
          title: 'Данные заказов обновлены'
        })
        this.handleCloseDeleteForm()
        await this.fetchAllOrders()
      })
          .catch((error) => {
            this.$notify({
              type: 'error',
              title: 'Возникла ошибка!',
            })
            const errors = getError(error)
            actions.setErrors(errors);
          });
    },
  },

  async mounted() {
    await this.fetchAllOrders()
    await this.fetchCouriers()
  }
}
</script>
