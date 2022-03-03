<template>
<div class="flex max-h-screen overflow-hidden">
  <Sidebar />
  <div class="h-screen overflow-auto w-full">
    <router-view />
  </div>
</div>
</template>

<script>
import Sidebar from "../../components/admin/Sidebar";

export default {
  name: "Dashboard",
  components: {
    Sidebar
  }

}
</script>
