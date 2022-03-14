<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div>
    <div>
      <h1 class="text-gray-900 font-semibold text-2xl">Список заказов</h1>
    </div>
    <div
        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-6 py-4 bg-white mt-5 flex gap-4 justify-between items-center">
      <OrdersSearch v-if="orders.length"/>
      <CommonButton class="whitespace-nowrap ml-auto" color="success" component="router-link"
                    v-if="user.tarif"
                    :to="{name: 'home', params: {id: 'create'}, query: $route.query}">
        <template v-slot:icon>
          <PlusIcon class="-ml-1 mr-2 h-4 w-4"></PlusIcon>
        </template>
        Новый заказ
      </CommonButton>
      <p v-else class="text-sm text-gray-400">Пока вы не можете создавть заказы</p>
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
                  Время доставки
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Наложенный платеж
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Тип оплаты
                </th>
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
                    {{ `${parseDate(order.delivery_interval[0])} - ${parseDate(order.delivery_interval[1])}` }}
                  </div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.cod ? 'Да' : 'Нет' }}</div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.payment_type === 'card' ? 'Карта' : 'Наличные' }}</div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">
                    <div class="text-xs text-gray-500 w-[120px]" v-if="order.courier">
                      <div class="text-sm font-medium text-gray-900">
                        {{ order.courier.name }}
                      </div>
                      <div class="text-sm text-gray-500">
                        {{ order.courier.phone }}
                      </div>
                    </div>
                    <span v-else>Не назначен</span>
                  </div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.price ? `${order.price}₽` : '' }}</div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.act_id }}</div>
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                  <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                      :class="getColorOfStatus(order.status)"> {{ getTextOfStatus(order.status) }} </span>
                </td>
                <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex gap-2">
                    <router-link :to="{name: $route.name, params: { id: order.id }, query: $route.query}"
                                 class="text-indigo-600 hover:text-indigo-900">
                      <RefreshIcon class="w-4 h-4"/>
                    </router-link>
                    <button @click="showModalDeleteForm(order)" v-if="order.status === 'processing'" class="text-red-600 hover:text-red-900">
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
import OrdersSearch from "./orders/OrdersSearch";
import CommonButton from "./common/CommonButton";
import {PlusIcon, RefreshIcon, TrashIcon} from "@heroicons/vue/outline";
import OrderForm from "./orders/OrderForm";
import {mapActions, mapGetters} from "vuex";
import DeleteConfirmation from "./orders/DeleteConfirmation";
import ApiService from "../services/ApiService";
import {getError} from "../utils/helpers";

const {DateTime} = require("luxon");

export default {
  components: {OrdersSearch, CommonButton, PlusIcon, OrderForm, RefreshIcon, TrashIcon, DeleteConfirmation},

  methods: {
    ...mapActions({
      fetchOrders: "order/fetchOrders"
    }),
    parseDate(date) {
      return DateTime.fromISO(date).toFormat('dd.MM.yy HH:mm')
    },
    getTextOfStatus(status) {
      switch (status) {
        case 'processing':
          return 'В обработке'
        case 'work':
          return 'В работе'
        case 'delivered':
          return 'Доставлен'
        case 'undelivered':
          return 'Не доставлен'
        default:
          return status
      }
    },
    getColorOfStatus(status) {
      switch (status) {
        case 'processing':
          return 'bg-gray-100 text-gray-800'
        case 'work':
          return 'bg-indigo-100 text-indigo-800'
        case 'delivered':
          return 'bg-green-100 text-green-800'
        case 'undelivered':
          return 'bg-red-100 text-red-800'
        default:
          return status
      }
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
        await this.fetchOrders()
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

  data() {
    return {
      showDeleteConfirmation: false,
      deletingItem: null
    }
  },

  computed: {
    ...mapGetters({
      orders: "order/orders",
      user: "auth/authUser"
    }),
    filter() {
      return {
        search: this.$route.query.search
      }
    }
  },

  async mounted() {
    await this.fetchOrders(this.filter)
  }

}
</script>