<template>
<div class="fixed top-0 right-0 left-48 bg-white shadow-md z-10 px-14 py-3">
  <div class="flex justify-end">
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

  <LogoutComponent :open="showModalLogoutConfirmation" @close="showModalLogoutConfirmation = false" @submit="logout"/>
</div>
</template>

<script>
import {Popover, PopoverButton, PopoverGroup, PopoverPanel} from "@headlessui/vue";
import {ChevronDownIcon, LogoutIcon, UserIcon} from "@heroicons/vue/outline";
import LogoutComponent from "../common/LogoutComponent";
import {mapActions, mapGetters} from "vuex";

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