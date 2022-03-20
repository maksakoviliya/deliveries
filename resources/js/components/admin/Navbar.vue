<template>
  <div class="fixed top-0 right-0 left-0 md:left-48 bg-white shadow-md z-10 px-3 md:px-14 py-3">
    <div class="flex justify-between md:justify-end">
      <Popover class="-mr-2 -my-2 md:hidden">
        <PopoverButton
            class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
          <span class="sr-only">Open menu</span>
          <MenuIcon class="h-6 w-6" aria-hidden="true"/>
        </PopoverButton>

        <transition enter-active-class="duration-200 ease-out" enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in"
                    leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
          <PopoverPanel focus class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden z-20">
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
              <div class="pt-5 pb-6 px-5">
                <div class="flex items-center justify-between">
                  <LogoLink class="h-8 w-auto"/>
                  <div class="-mr-2">
                    <PopoverButton
                        class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                      <span class="sr-only">Close menu</span>
                      <XIcon class="h-6 w-6" aria-hidden="true"/>
                    </PopoverButton>
                  </div>
                </div>
              </div>
              <div class="py-6 px-5 space-y-6">
                <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-center">
                  <router-link :to="{name: 'clients'}"
                               class="-m-3 p-3 flex items-center justify-center gap-3 text-sm font-medium rounded-lg hover:bg-gray-50 text-right"
                               active-class="text-gray-900"> Клиенты
                  </router-link>
                  <router-link :to="{name: 'orders'}"
                               class="-m-3 p-3 flex items-center justify-center gap-3 text-sm font-medium rounded-lg hover:bg-gray-50 text-right"
                               active-class="text-gray-900"> Заказы
                  </router-link>
                  <router-link :to="{name: 'couriers'}"
                               class="-m-3 p-3 flex items-center justify-center gap-3 text-sm font-medium rounded-lg hover:bg-gray-50 text-right"
                               active-class="text-gray-900"> Курьеры
                  </router-link>
                  <router-link :to="{name: 'allActs'}"
                               class="-m-3 p-3 flex items-center justify-center gap-3 text-sm font-medium rounded-lg hover:bg-gray-50 text-right"
                               active-class="text-gray-900"> Акты
                  </router-link>
                </div>
                <hr>
                <div class="grid grid-cols-1 gap-y-4 gap-x-8 text-center">
<!--                  <router-link :to="{name: 'profile'}"-->
<!--                               class="-m-3 p-3 flex items-center gap-3 text-sm font-medium justify-center rounded-lg hover:bg-gray-50 text-right">-->
<!--                    <UserIcon class="h-5"></UserIcon>-->
<!--                    Профиль-->
<!--                  </router-link>-->
                  <button @click="showModalLogoutConfirmation = true"
                          class="-m-3 p-3 flex items-center gap-3 text-sm font-medium justify-center rounded-lg hover:bg-gray-50 text-right">
                    <LogoutIcon class="h-5"></LogoutIcon>
                    Выход
                  </button>
                </div>
              </div>
            </div>
          </PopoverPanel>
        </transition>
      </Popover>

      <Popover class="relative" v-slot="{ open }">
        <PopoverButton
            :class="[open ? 'text-gray-900' : 'text-gray-500', 'group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 outline-none']">
          <span v-if="user && user.name">{{ user.name }}</span>
          <ChevronDownIcon
              :class="[open ? 'text-gray-600' : 'text-gray-400', 'ml-2 h-5 w-5 group-hover:text-gray-500']"
              aria-hidden="true"/>
        </PopoverButton>

        <transition enter-active-class="transition ease-out duration-200"
                    enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition ease-in duration-150"
                    leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
          <PopoverPanel class="absolute z-10 -ml-4 mt-3 transform px-2 w-64 sm:px-0 lg:ml-0 md:right-0">
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
              <div class="relative grid gap-6 bg-white sm:gap-4 sm:p-4">
                <button @click="showModalLogoutConfirmation = true"
                        class="md:-m-3 p-3 flex items-center gap-3 text-sm font-medium rounded-lg hover:bg-gray-50 text-right">
                  <LogoutIcon class="h-5"></LogoutIcon>
                  Выход
                </button>
              </div>
            </div>
          </PopoverPanel>
        </transition>
      </Popover>
    </div>

    <LogoutComponent :open="showModalLogoutConfirmation" @close="showModalLogoutConfirmation = false" @submit="logout"/>
  </div>
</template>

<script>
import {Popover, PopoverButton, PopoverGroup, PopoverPanel} from "@headlessui/vue";
import {ChevronDownIcon, LogoutIcon, MenuIcon, UserIcon, XIcon} from "@heroicons/vue/outline";
import LogoutComponent from "../common/LogoutComponent";
import {mapActions, mapGetters} from "vuex";
import LogoLink from "../common/LogoLink";

export default {
  name: "Navbar",

  components: {
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
    ChevronDownIcon,
    UserIcon,
    LogoutIcon,
    LogoutComponent,
    MenuIcon,
    LogoLink,
    XIcon
  },

  computed: {
    ...mapGetters({
      user: 'auth/authUser'
    })
  },


  data() {
    return {
      showModalLogoutConfirmation: false
    }
  },

  methods: {
    ...mapActions({
      logout: "auth/logout"
    })
  }
}
</script>