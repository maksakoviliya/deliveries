<template>
  <Popover class="relative bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="flex justify-between items-center py-6 md:justify-start md:space-x-10">
        <div class="flex justify-start">
          <LogoLink/>
        </div>
        <div class="-mr-2 -my-2 md:hidden">
          <PopoverButton
              class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
            <span class="sr-only">Open menu</span>
            <MenuIcon class="h-6 w-6" aria-hidden="true"/>
          </PopoverButton>
        </div>
        <PopoverGroup as="nav" class="hidden md:flex mr-auto space-x-10 text-gray-500">
          <router-link :to="{name: 'home'}" class="text-base font-medium hover:text-gray-900"
                       active-class="text-gray-900"> Заказы
          </router-link>
          <router-link :to="{name: 'acts'}" class="text-base font-medium hover:text-gray-900"
                       active-class="text-gray-900"> Акты
          </router-link>
          <!--          <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900"> Docs </a>-->

        </PopoverGroup>
        <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0 gap-3">
          <router-link :to="{name: 'dashboard'}"
                       class="flex items-center font-medium hover:text-gray-900 text-gray-500 gap-2"
                       v-if="user && user.isAdmin">
            <IdentificationIcon class="w-5 h-5"/>
            Админ панель
          </router-link>
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
                  <div class="relative grid gap-6 bg-white px-4 py-5 sm:gap-8 sm:p-8">
                    <router-link :to="{name: 'profile'}"
                                 class="-m-3 p-3 flex items-center gap-3 text-sm font-medium rounded-lg hover:bg-gray-50 text-right">
                      <UserIcon class="h-5"></UserIcon>
                      Профиль
                    </router-link>
                    <hr/>
                    <button @click="showModalLogoutConfirmation = true"
                            class="-m-3 p-3 flex items-center gap-3 text-sm font-medium rounded-lg hover:bg-gray-50 text-right">
                      <LogoutIcon class="h-5"></LogoutIcon>
                      Выход
                    </button>
                  </div>
                </div>
              </PopoverPanel>
            </transition>
          </Popover>
        </div>
      </div>
    </div>

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
              <router-link :to="{name: 'home'}"
                           class="-m-3 p-3 flex items-center justify-center gap-3 text-sm font-medium rounded-lg hover:bg-gray-50 text-right"
                           active-class="text-gray-900"> Заказы
              </router-link>
              <router-link :to="{name: 'acts'}"
                           class="-m-3 p-3 flex items-center justify-center gap-3 text-sm font-medium rounded-lg hover:bg-gray-50 text-right"
                           active-class="text-gray-900"> Акты
              </router-link>
            </div>
            <hr>
            <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-center">
              <router-link :to="{name: 'profile'}"
                           class="-m-3 p-3 flex items-center gap-3 text-sm font-medium justify-center rounded-lg hover:bg-gray-50 text-right">
                <UserIcon class="h-5"></UserIcon>
                Профиль
              </router-link>
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

    <LogoutComponent :open="showModalLogoutConfirmation" @close="showModalLogoutConfirmation = false" @submit="logout"/>
  </Popover>
</template>

<script>
import {Popover, PopoverButton, PopoverGroup, PopoverPanel} from "@headlessui/vue";
import {
  IdentificationIcon,
  LogoutIcon,
  MenuIcon, UserIcon,
  XIcon,
} from '@heroicons/vue/outline'
import {ChevronDownIcon, GlobeIcon} from '@heroicons/vue/solid'
import {mapActions, mapGetters} from "vuex";
import LogoutComponent from "./LogoutComponent";
import LogoLink from "./LogoLink";

export default {
  name: "Navbar",

  components: {
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
    XIcon,
    LogoutIcon,
    MenuIcon,
    UserIcon,
    ChevronDownIcon,
    GlobeIcon,
    LogoutComponent,
    LogoLink,
    IdentificationIcon
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
