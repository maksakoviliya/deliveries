<template>
  <div class="py-8 px-3 md:px-12 w-full h-full">

    <div>
      <h1 class="text-gray-900 font-semibold text-2xl">Список курьеров</h1>
    </div>
    <div
        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg px-6 py-4 bg-white mt-5 flex gap-4 justify-between items-center">
      <CommonButton class="whitespace-nowrap ml-auto" color="success" component="router-link"
                    :to="{name: $route.name, params: {id: 'create'}, query: $route.query}">
        <template v-slot:icon>
          <PlusIcon class="-ml-1 mr-2 h-4 w-4"></PlusIcon>
        </template>
        Новый курьер
      </CommonButton>
    </div>
    <div class="flex flex-col mt-5">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-bottom inline-block min-w-full sm:px-6 lg:px-8">
          <div v-if="couriers.length" class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
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
                  Заказы
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Комментарий
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="courier in couriers" :key="courier.id">
                <td class="px-6 py-2 whitespace-nowrap">
                  {{ courier.id }}
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">
                    <div class="text-sm font-medium text-gray-900">
                      {{ courier.name }}
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ courier.phone }}
                    </div>
                  </div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500">{{ courier.orders_count }}</div>
                </td>
                <td class="px-6 py-2">
                  <div class="text-xs text-gray-500 max-w-[200px] text-ellipsis overflow-hidden whitespace-nowrap">{{ courier.comment }}</div>
                </td>
                <td class="px-6 py-2 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex justify-end gap-2">
                    <router-link :to="{name: $route.name, params: { id: courier.id }, query: $route.query}" class="text-indigo-600 hover:text-indigo-900">
                      <PencilAltIcon class="w-4 h-4" />
                    </router-link>
                    <button @click="showModalDeleteForm(courier)" class="text-red-600 hover:text-red-900">
                      <TrashIcon class="w-4 h-4" />
                    </button>
                  </div>
                </td>
              </tr>
              </tbody>
<!--              <tfoot class="bg-gray-50">-->
<!--              <tr>-->
<!--                <th colspan="9" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">-->
<!--                  Тут будет пагинация-->
<!--                </th>-->
<!--              </tr>-->
<!--              </tfoot>-->
            </table>
          </div>
          <div class="text-3xl my-16 font-semibold text-gray-300 text-center" v-else>
            Курьеров пока нет
          </div>
        </div>
      </div>
    </div>

        <CourierForm :key="$route.params.id"/>

        <DeleteConfirmation :open="showDeleteConfirmation" @submit="handleDelete" @close="handleCloseDeleteForm">
          <template v-slot:title>Удаление курьера!</template>
          <template v-slot:description>Вы действительно хотите безвозвратно удалить курьера?</template>
        </DeleteConfirmation>

  </div>
</template>

<script>
import CommonButton from "../../../components/common/CommonButton";
import {PencilAltIcon, PlusIcon, TrashIcon} from "@heroicons/vue/outline";
import {mapActions, mapGetters} from "vuex";
import DeleteConfirmation from "../../../components/orders/DeleteConfirmation";
import ApiService from "../../../services/ApiService";
import {getError} from "../../../utils/helpers";
import CourierForm from "./CourierForm";

export default {
  name: "CouriersList",

  components: {
    CommonButton,
    PlusIcon,
    PencilAltIcon,
    TrashIcon,
    DeleteConfirmation,
    CourierForm
  },

  computed: {
    ...mapGetters({
      couriers: "courier/couriers"
    })
  },

  data() {
    return {
      showDeleteConfirmation: false,
      deletingItem: null
    }
  },

  methods: {
    ...mapActions({
      fetchCouriers: "courier/fetchCouriers"
    }),
    showModalDeleteForm(client) {
      this.deletingItem = client
      this.showDeleteConfirmation = true
    },
    handleCloseDeleteForm() {
      this.deletingItem = null
      this.showDeleteConfirmation = false
    },
    handleDelete() {
      ApiService.removeCourier(this.deletingItem.id).then(async () => {
        this.$notify({
          type: 'warning',
          title: 'Данные курьеров обновлены'
        })
        await this.fetchCouriers()
        this.handleCloseDeleteForm()
      })
          .catch((error) => {
            const errors = getError(error)
            actions.setErrors(errors);
            this.$notify({
              type: 'error',
              title: 'Возникла ошибка!',
            })
          });
    },
  },

  async mounted() {
    await this.fetchCouriers()
  }
}
</script>
