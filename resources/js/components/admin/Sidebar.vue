<template>
  <div class="w-48 h-screen bg-gray-200 shadow flex flex-col items-center p-5">
    <LogoLink />
    <div class="mt-10 mb-6"></div>
    <router-link :to="link.to" :active-class="'text-primary'" class="flex items-center bg-zinc-100 w-full px-4 py-2 mt-4 rounded-lg shadow text-sm gap-2 font-medium text-gray-700 hover:text-gray-900 hover:shadow-md hover:bg-zinc-150" v-for="link in links" :key="link.id">
      <component :is="link.icon" class="w-5 h-5 " />
      {{ link.label }}
    </router-link>
  </div>
</template>

<script>
import LogoLink from "../common/LogoLink";
import {AtSymbolIcon, LightningBoltIcon, UserIcon} from "@heroicons/vue/outline";
export default {
  name: "Sidebar",

  components: {
    LogoLink,
    UserIcon,
    LightningBoltIcon,
    AtSymbolIcon
  },

  data() {
    return {
      links: [
        {
          id: 1,
          label: 'Клиенты',
          icon: 'UserIcon',
          to: {name: 'clients'}
        },
        {
          id: 2,
          label: 'Заказы',
          icon: 'LightningBoltIcon',
          to: {name: 'orders'}
        },
        {
          id: 3,
          label: 'Курьеры',
          icon: 'AtSymbolIcon',
          to: {name: 'couriers'}
        }
      ]
    }
  }
}
</script>