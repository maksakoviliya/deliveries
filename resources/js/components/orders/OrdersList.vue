<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div>

    <OrdersSelectedActions :open="!!selectedOrders.length"/>

    <div>
      <h1 class="text-gray-900 font-semibold text-2xl">Список заказов</h1>
    </div>
    <div
        class="shadow border-b border-gray-200 sm:rounded-lg px-3 py-4 bg-white mt-5 flex flex-col md:flex-row gap-4 justify-between items-center">
      <OrdersSearch />
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

    <div class="mt-5">
      <div v-if="orders.length" class="shadow overflow-auto border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              ID
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Интервал доставки
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Наложенный платеж
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Тип оплаты
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Курьер
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Стоимость доставки
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              АПП
            </th>
            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Оплата
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Статус
            </th>
            <th scope="col" class="relative px-3 py-3">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="order in orders" :key="order.id">
            <td class="px-3 py-2 whitespace-nowrap">
              <input
                  v-if="!order.act_id"
                  class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                  type="checkbox"
                  :value="order.id"
                  :checked="selectedOrders.findIndex(item => item.id === order.id) >= 0"
                  @input="selectOrder(order)"
              >
            </td>
            <td class="px-3 py-2 whitespace-nowrap">
              <span class="text-gray-400">#</span>{{ order.id }}
            </td>
            <td class="px-3 py-2">
              <div class="text-xs text-gray-500">
                {{ parseDate(order.delivery_date) }}
                <span class="text-gray-400 inline-block transform -translate-y-0.5">{{ parseTime(order.delivery_interval)}}</span>
              </div>
            </td>
            <td class="px-3 py-2">
              <div class="text-xs text-gray-500">{{ order.cod ? 'Да' : 'Нет' }}</div>
            </td>
            <td class="px-3 py-2">
              <div class="text-xs text-gray-500">{{ order.payment_type === 'card' ? 'Карта' : 'Наличные' }}</div>
            </td>
            <td class="px-3 py-2">
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
            <td class="px-3 py-2">
              <div class="text-xs text-gray-500">{{ order.price ? `${order.price}₽` : '' }}</div>
            </td>
            <td class="px-3 py-2">
              <div class="text-xs text-gray-500 flex items-center" v-if="order.act_id">
                <span class="text-gray-400">#</span>
                {{ order.act_id }}
                <span class="w-1 block"></span>
                <svg class="animate-spin h-4 w-4 text-indigo-600" v-if="loading && loadingItem && loadingItem === order.act_id" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <button @click="handlePrint(order.act_id)"
                        v-else
                        class="text-indigo-600 hover:text-indigo-900">
                  <DownloadIcon class="w-4 h-4"/>
                </button>
              </div>
            </td>
            <td class="px-3 py-2 whitespace-nowrap">
                  <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                      :class="getColorOfPayment(order.payment)"> {{ getTextOfPayment(order.payment) }} </span>
            </td>
            <td class="px-3 py-2 whitespace-nowrap">
                  <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                      :class="getColorOfStatus(order.status)"> {{ getTextOfStatus(order.status) }} </span>
            </td>
            <td class="px-3 py-2 whitespace-nowrap text-right text-sm font-medium">
              <div class="flex gap-2">
                <router-link :to="{name: $route.name, params: { id: order.id, view: 'view' }, query: $route.query}"
                             class="text-indigo-600 hover:text-indigo-900">
                  <EyeIcon class="w-4 h-4"/>
                </router-link>
                <router-link :to="{name: $route.name, params: { id: order.id }, query: $route.query}"
                             class="text-indigo-600 hover:text-indigo-900">
                  <DocumentDuplicateIcon class="w-4 h-4"/>
                </router-link>
                <button @click="showModalDeleteForm(order)" v-if="order.status === 'processing'"
                        class="text-red-600 hover:text-red-900">
                  <TrashIcon class="w-4 h-4"/>
                </button>
              </div>
            </td>
          </tr>
          </tbody>
          <tfoot class="bg-gray-50">
          <tr>
            <th colspan="11" scope="col"
                class="px-3 py-3 text-left text-xs font-medium text-gray-500">
              <Pagination :meta="ordersMeta" @pageChange="fetchOrders" />
            </th>
          </tr>
          </tfoot>
        </table>
      </div>
      <div class="text-3xl my-16 font-semibold text-gray-300 text-center" v-else>
        Заказов пока нет
      </div>
    </div>

    <OrderAnalytics v-if="orders.length" class="mt-5" />

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
import OrdersSearch from "./OrdersFilter";
import CommonButton from "../common/CommonButton";
import {PlusIcon, DocumentDuplicateIcon, TrashIcon, DownloadIcon, EyeIcon} from "@heroicons/vue/outline";
import OrderForm from "./OrderForm";
import {mapActions, mapGetters, mapMutations} from "vuex";
import DeleteConfirmation from "./DeleteConfirmation";
import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";
import OrdersSelectedActions from "./OrdersSelectedActions";
import OrderAnalytics from "./OrderAnalytics";
import Pagination from "../common/Pagination";

const {DateTime} = require("luxon");

export default {
  components: {
    Pagination,
    OrdersSearch,
    CommonButton,
    PlusIcon,
    OrderForm,
    DocumentDuplicateIcon,
    TrashIcon,
    DeleteConfirmation,
    OrdersSelectedActions,
    DownloadIcon,
    OrderAnalytics,
    EyeIcon,
  },

  methods: {
    ...mapActions({
      fetchOrders: "order/fetchOrders",
      selectOrder: "order/selectOrder",
      downloadAct: "act/downloadAct"
    }),
    parseDate(date) {
      return DateTime.fromISO(date).toFormat('dd.MM.yy')
    },
    parseTime(interval) {
      return `${interval[0]}:00 - ${interval[1]}:00`
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
    async handlePrint(act_id) {
      this.loading = true
      this.loadingItem = act_id
      this.downloadAct(act_id).then((res) => {
        let fileURL = window.URL.createObjectURL(new Blob([res.data]));
        let fileLink = document.createElement('a');

        fileLink.href = fileURL;
        fileLink.setAttribute('download', res.headers['content-disposition'].split('filename=')[1].split('"')[1]);
        document.body.appendChild(fileLink);

        fileLink.click();
      }).finally(() => {
        this.loading = false
        this.loadingItem = null
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
  },

  data() {
    return {
      loading: false,
      loadingItem: null,
      showDeleteConfirmation: false,
      deletingItem: null,
    }
  },

  computed: {
    ...mapGetters({
      orders: "order/orders",
      ordersMeta: "order/ordersMeta",
      user: "auth/authUser",
      selectedOrders: "order/selectedOrders"
    }),
    filter() {
      return {
        search: this.$route.query.search
      }
    },
  },

  mounted() {
    this.fetchOrders(this.filter)
  }

}
</script>