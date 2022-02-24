<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div>
    <div>
      <h1 class="text-gray-900 font-semibold text-2xl">Список заказов</h1>
    </div>
    <div
        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-6 py-4 bg-white mt-5 flex gap-4 justify-between">
      <OrdersSearch/>
      <CommonButton class="whitespace-nowrap" color="success" component="router-link"
                    :to="{name: 'home', params: {id: 'create'}, query: $route.query}">
        <template v-slot:icon>
          <PlusIcon class="-ml-1 mr-2 h-4 w-4"></PlusIcon>
        </template>
        Добавить заказ
      </CommonButton>
    </div>
    <div class="flex flex-col mt-5">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Name
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Title
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Role
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
<!--              <tr v-for="person in people" :key="person.email">-->
<!--                <td class="px-6 py-4 whitespace-nowrap">-->
<!--                  <div class="flex items-center">-->
<!--                    <div class="flex-shrink-0 h-10 w-10">-->
<!--                      <img class="h-10 w-10 rounded-full" :src="person.image" alt=""/>-->
<!--                    </div>-->
<!--                    <div class="ml-4">-->
<!--                      <div class="text-sm font-medium text-gray-900">-->
<!--                        {{ person.name }}-->
<!--                      </div>-->
<!--                      <div class="text-sm text-gray-500">-->
<!--                        {{ person.email }}-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                </td>-->
<!--                <td class="px-6 py-4 whitespace-nowrap">-->
<!--                  <div class="text-sm text-gray-900">{{ person.title }}</div>-->
<!--                  <div class="text-sm text-gray-500">{{ person.department }}</div>-->
<!--                </td>-->
<!--                <td class="px-6 py-4 whitespace-nowrap">-->
<!--                  <span-->
<!--                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> Active </span>-->
<!--                </td>-->
<!--                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-->
<!--                  {{ person.role }}-->
<!--                </td>-->
<!--                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">-->
<!--                  <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>-->
<!--                </td>-->
<!--              </tr>-->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <OrderForm />
  </div>
</template>

<script>
import OrdersSearch from "./orders/OrdersSearch";
import CommonButton from "./common/CommonButton";
import {PlusIcon} from "@heroicons/vue/outline";
import OrderForm from "./orders/OrderForm";
import {mapActions} from "vuex";

export default {
  components: {OrdersSearch, CommonButton, PlusIcon, OrderForm },

  methods: {
    ...mapActions({
      fetchOrders: "order/fetchOrders"
    })
  },

  computed: {
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