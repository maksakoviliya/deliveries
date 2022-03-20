<template>
  <div class="md:flex gap-4 text-gray-600" v-if="analytics">
    <div>
      <div>Доставлено: {{ analytics['delivered'] }} шт.</div>
      <div>Не доставлено: {{ analytics['undelivered'] }} шт.</div>
    </div>
    <div class="mt-4 md:mt-0">
      <div>Стоимость доставки: {{ analytics['price'] }}₽</div>
      <div>Оплачено: {{ analytics['payed'] }}₽</div>
      <div>Задолженность: {{ analytics['debt'] }}₽</div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
  name: "OrderAnalytics",

  data() {
    return {
      analytics: null
    }
  },

  methods: {
    ...mapActions({
      fetchOrdersAnalytics: "order/fetchOrdersAnalytics"
    })
  },

  async mounted() {
    this.analytics = await this.fetchOrdersAnalytics()
  }
}
</script>
