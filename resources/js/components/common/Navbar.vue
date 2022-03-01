<template>
  <Popover class="relative bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="flex justify-between items-center py-6 md:justify-start md:space-x-10">
        <div class="flex justify-start">
          <router-link :to="{name: 'home'}">
            <span class="sr-only">Workflow</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10" fill="none" viewBox="0 0 764 269">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M0 113.471c4.088-8.649 9.9-12.977 17.437-12.983-1.453-12.352 6.04-19.773 22.475-22.267 9.484-2.364 30.193-2.323 43.222.124-4.034 3.208-3.744 16.608-3.495 22.267 1.024 23.257 14.103 87.004 50.363 114.316-31.527-55.141-67.54-135.661 5.922-145.85C248.298 53.494 301.025 2.418 302.192 0c-27.627 91.147-100.708 105.333-111.126 111.034-11.86 6.488 50.735.39 103.953-21.924-12.988 21.901-36.662 48.79-98.707 60.814-41.839 8.109 30.825 101.226 63.882 118.514C158.188 249.38 78.63 184.031 44.12 133.862c-4.322-6.282-10.205-11.027-17.198-14.184-8.04-3.631-14.583-10.355-26.922-6.207Z"
                    fill="#3989FF"/>
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M17.436 100.488C9.9 100.494 4.087 104.822 0 113.471c12.338-4.148 18.881 2.576 26.921 6.207 6.993 3.158 12.877 7.902 17.198 14.184 17.743 25.794 47.395 55.601 85.883 81.066-36.26-27.312-49.34-91.059-50.364-114.316-.249-5.659-.539-19.059 3.495-22.267-13.029-2.447-33.738-2.488-43.221-.124-16.435 2.494-23.928 9.916-22.476 22.267Z"
                    fill="#2A2A2A"/>
              <path
                  d="m382.259 120.802-6.578 10.875c-6.652-4.964-14.655-7.447-24.01-7.447-9.794 0-14.691 2.325-14.691 6.974 0 1.734.621 2.995 1.863 3.783 1.316.709 3.326 1.221 6.03 1.537l18.2 2.246c13.96 1.812 20.94 8.353 20.94 19.622 0 7.092-2.851 12.412-8.552 15.958-5.701 3.546-13.339 5.319-22.913 5.319-12.133 0-22.585-3.507-31.356-10.52l6.469-11.466c8.04 6.068 16.847 9.102 26.422 9.102 5.043 0 9.063-.67 12.059-2.01 3.07-1.418 4.605-3.467 4.605-6.147 0-1.812-.512-3.152-1.535-4.019-1.023-.945-2.814-1.576-5.372-1.891l-20.392-2.482c-6.505-.788-11.475-2.68-14.91-5.674-3.362-2.995-5.043-7.408-5.043-13.239 0-6.62 2.631-11.624 7.893-15.013 5.336-3.467 12.097-5.201 20.283-5.201 12.352 0 22.548 3.231 30.588 9.693ZM393.813 112.646h13.595v24.114h17.651l15.239-24.114h15.787l-19.405 30.261 20.831 35.107h-16.226l-15.897-27.778h-17.98v27.778h-13.595v-65.368ZM461.212 112.646h15.678l19.405 34.871h.877l18.748-34.871h15.678l-28.505 49.056v16.312h-13.485v-16.312l-28.396-49.056ZM540.385 112.646h31.245c8.698 0 16.299 3.073 22.804 9.22 6.578 6.147 9.867 13.948 9.867 23.405s-3.289 17.298-9.867 23.523c-6.505 6.147-14.106 9.22-22.804 9.22h-31.245v-65.368Zm13.704 13.357v38.536h17.541c5.482 0 10.014-1.813 13.595-5.438 3.581-3.625 5.372-8.235 5.372-13.83 0-5.595-1.791-10.205-5.372-13.83s-8.113-5.438-13.595-5.438h-17.541ZM614.152 112.646h55.037v13.357h-41.333v12.057h37.166v13.358h-37.166v13.003h42.867v13.593h-56.571v-65.368ZM680.96 112.646h13.705v52.011h41.77v13.357H680.96v-65.368ZM746.523 161.82c1.9-2.049 4.202-3.073 6.907-3.073 2.704 0 5.006 1.024 6.907 3.073 1.9 1.97 2.85 4.413 2.85 7.329 0 2.837-.95 5.24-2.85 7.21-1.901 1.892-4.203 2.837-6.907 2.837-2.705 0-5.007-.945-6.907-2.837-1.828-1.97-2.741-4.373-2.741-7.21 0-2.916.913-5.359 2.741-7.329Z"
                  fill="#2A2A2A"/>
            </svg>
          </router-link>
        </div>
        <div class="-mr-2 -my-2 md:hidden">
          <PopoverButton
              class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
            <span class="sr-only">Open menu</span>
            <MenuIcon class="h-6 w-6" aria-hidden="true"/>
          </PopoverButton>
        </div>
        <PopoverGroup as="nav" class="hidden md:flex mr-auto space-x-10">
          <router-link :to="{name: 'home'}" class="text-base font-medium text-gray-500 hover:text-gray-900"
                       active-class="text-gray-900"> Заказы
          </router-link>
          <router-link :to="{name: 'acts'}" class="text-base font-medium text-gray-500 hover:text-gray-900"
                       active-class="text-gray-900"> Акты
          </router-link>
          <!--          <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900"> Docs </a>-->

        </PopoverGroup>
        <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">

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
      <PopoverPanel focus class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
          <div class="pt-5 pb-6 px-5">
            <div class="flex items-center justify-between">
              <div>
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                     alt="Workflow"/>
              </div>
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
            <div class="grid grid-cols-2 gap-y-4 gap-x-8">
              <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700"> Pricing </a>

              <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700"> Docs </a>
            </div>
            <div>
              <a href="#"
                 class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Sign up </a>
              <p class="mt-6 text-center text-base font-medium text-gray-500">
                Existing customer?
                {{ ' ' }}
                <a href="#" class="text-indigo-600 hover:text-indigo-500"> Sign in </a>
              </p>
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
  LogoutIcon,
  MenuIcon, UserIcon,
  XIcon,
} from '@heroicons/vue/outline'
import {ChevronDownIcon, GlobeIcon} from '@heroicons/vue/solid'
import {mapActions, mapGetters} from "vuex";
import LogoutComponent from "./LogoutComponent";

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
    LogoutComponent
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
