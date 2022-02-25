<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div>
    <Navbar />

    <OrdersList class="max-w-5xl mx-auto mt-10">

    </OrdersList>
  </div>
</template>

<script>
import {Popover} from '@headlessui/vue'
import OrdersList from "../components/OrdersList";
import Navbar from "../components/common/Navbar";

export default {
  components: {
    Popover,
    OrdersList,
    Navbar
  },
  setup() {
    return {}
  },
}
</script>