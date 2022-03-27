<template>
  <div class="py-8 px-3 md:px-12 w-full h-full">

    <OrdersSelectedActions :open="!!selectedOrders.length" :actions="['pay']"/>

    <div>
      <h1 class="text-gray-900 font-semibold text-2xl">Список заказов</h1>
    </div>
    <div
        class="shadow border-b border-gray-200 sm:rounded-lg px-4 py-4 bg-white mt-5 flex gap-4 justify-between items-center">
      <OrdersFilter/>
    </div>
    <div class="flex flex-col mt-5">
      <div class="mt-5">
        <div v-if="orders.length" class="shadow overflow-auto border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <input
                    class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                    type="checkbox" @input="handleSelectAll" :value="true" :checked="selectedOrders.length === orders.filter(item => item.payment !== 'payed').length" ref="selectAll" :indeterminate="selectedOrders.length < orders.filter(item => item.payment !== 'payed').length && selectedOrders.length > 0">
              </th>
              <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                ID
              </th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Контрагент
              </th>
              <th scope="col"
                  class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Время доставки
              </th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Наложенный платеж
              </th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Тип оплаты
              </th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Курьер
              </th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Стоимость доставки
              </th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                АПП
              </th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Оплата
              </th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Статус
              </th>
              <th scope="col" class="relative px-4 py-3">
                <span class="sr-only">Edit</span>
              </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="order in orders" :key="order.id">
              <td class="px-3 py-2 whitespace-nowrap">
                <input
                    v-if="order.payment !== 'payed'"
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
              <td class="px-4 py-2">
                <div class="text-xs text-gray-500">
                  {{ order.client && order.client.company ? order.client.company.title : '' }}
                </div>
              </td>
              <td class="px-4 py-2">
                <div class="text-xs text-gray-500">
                  {{ parseDate(order.delivery_date) }}
                  <span
                      class="text-gray-400 inline-block transform -translate-y-0.5">{{
                      parseTime(order.delivery_interval)
                    }}</span>
                </div>
              </td>
              <td class="px-4 py-2">
                <div class="text-xs text-gray-500">{{ order.cod ? 'Да' : 'Нет' }}</div>
              </td>
              <td class="px-4 py-2">
                <div class="text-xs text-gray-500">{{ order.payment_type === 'card' ? 'Карта' : 'Безнал' }}</div>
              </td>
              <td class="px-4 py-2">
                <CourierSetter :order="order"/>
              </td>
              <td class="px-4 py-2">
                <div class="text-xs text-gray-500">{{ order.price ? `${order.price}₽` : '' }}</div>
              </td>
              <td class="px-3 py-2">
                <div class="text-xs text-gray-500 flex items-center" v-if="order.act_id">
                  <span class="text-gray-400">#</span>
                  {{ order.act_id }}
                  <span class="w-1 block"></span>
                  <button @click="handlePrint(order.act_id)"
                          v-if="!loading"
                          class="text-indigo-600 hover:text-indigo-900">
                    <DownloadIcon class="w-4 h-4"/>
                  </button>
                  <svg class="animate-spin h-4 w-4 text-indigo-600" v-else xmlns="http://www.w3.org/2000/svg"
                       fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                </div>
              </td>
              <td class="px-4 py-2 whitespace-nowrap">
                <OrderPayment :order="order"/>
              </td>
              <td class="px-4 py-2 whitespace-nowrap">
                <OrderStatus :order="order"/>
              </td>
              <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
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
              <th colspan="12" scope="col"
                  class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <Pagination :meta="ordersMeta"/>
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

    <OrderAnalytics class="mt-5"/>

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
import {mapActions, mapGetters, mapMutations} from "vuex";
import {DateTime} from "luxon";
import {CheckIcon, DownloadIcon, PencilAltIcon, TrashIcon} from "@heroicons/vue/outline";
import DeleteConfirmation from "../../../components/orders/DeleteConfirmation";
import ApiService from "../../../services/ApiService";
import {getError} from "../../../utils/helpers";
import OrderForm from "./OrderForm";
import CommonSelect from "../../../components/common/CommonSelect";
import {Form} from "vee-validate";
import CommonButton from "../../../components/common/CommonButton";
import OrderStatus from "./OrderStatus";
import CourierSetter from "./CourierSetter";
import OrderPayment from "./OrderPayment";
import OrdersSelectedActions from "../../../components/orders/OrdersSelectedActions";
import OrdersFilter from "./OrdersFilter";
import Pagination from "../../../components/common/Pagination";
import OrderAnalytics from "../../../components/orders/OrderAnalytics";

export default {
  name: "OrdersList",

  components: {
    OrdersFilter,
    PencilAltIcon,
    TrashIcon,
    DeleteConfirmation,
    OrderForm,
    CommonSelect,
    Form,
    CheckIcon,
    CommonButton,
    OrderStatus,
    CourierSetter,
    OrderPayment,
    DownloadIcon,
    OrdersSelectedActions,
    Pagination,
    OrderAnalytics
  },

  watch: {
    '$route.query.page': {
      handler: function () {
        console.log('$route.query.page')
        this.fetchOrders()
      },
      deep: true,
    }
  },

  computed: {
    ...mapGetters({
      orders: "order/orders",
      selectedOrders: "order/selectedOrders",
      ordersMeta: "order/ordersMeta",
      ordersAnalytics: "order/ordersAnalytics",
    }),
    // selectAll: {
    //   get: function () {
    //     return this.orders ? this.selectedOrders.length === this.orders.length : false;
    //   },
    //   set: function (value) {
    //     console.log('va', value)
    //     if (value) {
    //       this.orders.forEach(function (order) {
    //         selectOrder(order)
    //       });
    //     }
    //   }
    // }
  },

  data() {
    return {
      loading: false,
      showDeleteConfirmation: false,
      deletingItem: null,
    }
  },

  methods: {
    ...mapActions({
      fetchOrders: "order/fetchOrders",
      fetchCouriers: "courier/fetchCouriers",
      selectOrder: "order/selectOrder",
      downloadAct: "act/downloadAct"
    }),
    ...mapMutations({
      setSelectedOrders: "order/SET_SELECTED_ORDERS"
    }),
    parseDate(date) {
      return DateTime.fromISO(date).toFormat('dd.MM.yy')
    },
    parseTime(interval) {
      return `${interval[0]}:00 - ${interval[1]}:00`
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
      this.downloadAct(act_id).then((res) => {
        let fileURL = window.URL.createObjectURL(new Blob([res.data]));
        let fileLink = document.createElement('a');

        fileLink.href = fileURL;
        fileLink.setAttribute('download', res.headers['content-disposition'].split('filename=')[1].split('"')[1]);
        document.body.appendChild(fileLink);

        fileLink.click();
      }).finally(() => {
        this.loading = false
      })
    },
    handleSelectAll() {
      if(this.$refs.selectAll.checked) {
        this.setSelectedOrders(this.orders.filter(item => item.payment !== 'payed'))
      } else {
        this.setSelectedOrders([])
      }
    }
  },

  async mounted() {
    await this.fetchOrders()
    await this.fetchCouriers()
  }
}
</script>
