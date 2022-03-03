<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div>
    <div>
      <h1 class="text-gray-900 font-semibold text-2xl">Список заказов</h1>
    </div>
    <div
        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-6 py-4 bg-white mt-5 flex gap-4 justify-between items-center">
      <OrdersSearch v-if="orders.length" />
      <CommonButton class="whitespace-nowrap ml-auto" color="success" component="router-link"
                    :to="{name: 'home', params: {id: 'create'}, query: $route.query}">
        <template v-slot:icon>
          <PlusIcon class="-ml-1 mr-2 h-4 w-4"></PlusIcon>
        </template>
        Новый заказ
      </CommonButton>
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
              <tr v-for="(order, i) in orders" :key="order.id">
                <td class="px-6 py-2 whitespace-nowrap">
                  {{ i + 1 }}
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ `${parseDate(order.delivery_interval[0])} - ${parseDate(order.delivery_interval[1])}`  }}</div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.cod ? 'Да' : 'Нет'  }}</div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.payment_type === 'card' ? 'Карта' : 'Безнал'  }}</div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.courier_id ? 'courier' : 'Не назначен' }}</div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.price }}</div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ order.act_id }}</div>
                </td>
                <td class="px-6 py-2 whitespace-nowrap">
                  <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> {{ order.status }} </span>
                </td>
                <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex gap-2">
                    <router-link :to="{name: $route.name, params: { id: order.id }, query: $route.query}" class="text-indigo-600 hover:text-indigo-900">
                      <RefreshIcon class="w-4 h-4" />
                    </router-link>
                    <a href="#" class="text-red-600 hover:text-red-900">
                      <TrashIcon class="w-4 h-4" />
                    </a>
                  </div>
                </td>
              </tr>
              </tbody>
              <tfoot class="bg-gray-50">
              <tr>
                <th colspan="9" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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

    <OrderForm :key="$route.params.id" />
  </div>
</template>

<script>
import OrdersSearch from "./orders/OrdersSearch";
import CommonButton from "./common/CommonButton";
import {PlusIcon, RefreshIcon, TrashIcon} from "@heroicons/vue/outline";
import OrderForm from "./orders/OrderForm";
import {mapActions, mapGetters} from "vuex";
const { DateTime } = require("luxon");

export default {
  components: {OrdersSearch, CommonButton, PlusIcon, OrderForm, RefreshIcon, TrashIcon},

  methods: {
    ...mapActions({
      fetchOrders: "order/fetchOrders"
    }),
    parseDate(date) {
      console.log('date', date)
      return DateTime.fromISO(date).toFormat('d.M.yy HH:mm')
    }
  },

  computed: {
    ...mapGetters({
      orders: "order/orders"
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