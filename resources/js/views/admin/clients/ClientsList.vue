<template>
<div class="py-8 px-12 w-full h-full">

  <div>
    <h1 class="text-gray-900 font-semibold text-2xl">Список клиентов</h1>
  </div>
  <div
      class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-6 py-4 bg-white mt-5 flex gap-4 justify-between items-center">
    <CommonButton class="whitespace-nowrap ml-auto" color="success" component="router-link"
                  :to="{name: 'clients', params: {id: 'create'}, query: $route.query}">
      <template v-slot:icon>
        <PlusIcon class="-ml-1 mr-2 h-4 w-4"></PlusIcon>
      </template>
      Новый клиент
    </CommonButton>
  </div>
  <div class="flex flex-col mt-5">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-bottom inline-block min-w-full sm:px-6 lg:px-8">
        <div v-if="clients.length" class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                ID
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Имя
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Контакты
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Компания
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Заказы
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Тариф
              </th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Edit</span>
              </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="client in clients" :key="client.id">
              <td class="px-6 py-2 whitespace-nowrap">
                {{ client.id }}
              </td>
              <td class="px-6 py-2">
                <div class="text-xs text-gray-500">{{ client.name }}</div>
              </td>
              <td class="px-6 py-2">
                <div class="text-xs text-gray-500">
                    <div class="text-sm font-medium text-gray-900">
                      {{ client.email }}
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ client.phone }}
                    </div>
                </div>
              </td>
              <td class="px-6 py-2">
                <div class="text-xs text-gray-500">{{ client.company ? client.company.title : ''  }}</div>
              </td>
              <td class="px-6 py-2">
                <div class="text-xs text-gray-500">{{ client.orders_count }}</div>
              </td>
              <td class="px-6 py-2">
                <div class="text-xs text-gray-500">{{ client.status }}</div>
              </td>
              <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex gap-2">
                  <router-link :to="{name: $route.name, params: { id: client.id }, query: $route.query}" class="text-indigo-600 hover:text-indigo-900">
                    <PencilAltIcon class="w-4 h-4" />
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
          Клиентов пока нет
        </div>
      </div>
    </div>
  </div>

  <ClientForm :key="$route.params.id" />

</div>
</template>

<script>
import CommonButton from "../../../components/common/CommonButton";
import {mapActions, mapGetters} from "vuex";
import {PencilAltIcon, PlusIcon, TrashIcon} from "@heroicons/vue/outline";
import ClientForm from "./ClientForm";

export default {
  name: "ClientsList",

  components: {
    CommonButton,
    PlusIcon,
    PencilAltIcon,
    TrashIcon,
    ClientForm
  },

  computed: {
    ...mapGetters({
      clients: "client/clients"
    })
  },

  methods: {
    ...mapActions({
      fetchClients: "client/fetchClients"
    })
  },

  async mounted() {
    await this.fetchClients()
  }
}
</script>