<template>
  <div class="w-48 h-screen bg-gray-200 shadow hidden md:flex flex-col items-center p-5 text-gray-700 flex-shrink-0 fixed left-0 inset-y-0">
    <LogoLink/>
    <div class="mt-10 mb-6"></div>
    <router-link :to="link.to"
                 v-slot="{ isActive }"
                 class="flex items-center bg-zinc-100 w-full px-4 py-2 mt-4 rounded-lg shadow text-sm gap-2 font-medium hover:text-gray-900 hover:shadow-md hover:bg-zinc-150"
                 active-class="text-primary hover:text-primary"
                 v-for="link in links" :key="link.id">
      <component :is="link.icon" class="w-5 h-5 "/>
      {{ link.label }}
    </router-link>
  </div>
</template>

<script>
import LogoLink from "../common/LogoLink";
import {AtSymbolIcon, ChartSquareBarIcon, DocumentTextIcon, LightningBoltIcon, UserIcon} from "@heroicons/vue/outline";

export default {
  name: "Sidebar",

  components: {
    LogoLink,
    UserIcon,
    LightningBoltIcon,
    AtSymbolIcon,
    ChartSquareBarIcon,
    DocumentTextIcon
  },

  data() {
    return {
      links: [
        // {
        //   id: 0,
        //   label: 'Дашборд',
        //   icon: 'ChartSquareBarIcon',
        //   to: {name: 'dashboard'}
        // },
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
        },
        {
          id: 4,
          label: 'Акты',
          icon: 'DocumentTextIcon',
          to: {name: 'allActs'}
        }
      ]
    }
  }
}
</script>