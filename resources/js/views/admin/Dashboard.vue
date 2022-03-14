<template>
<div class="flex h-screen overflow-hidden">
  <Sidebar />
  <div class="h-screen overflow-auto w-full">
    <Navbar />
    <div class="ml-48 mt-10">
      <router-view />
    </div>
  </div>
</div>
</template>

<script>
import Sidebar from "../../components/admin/Sidebar";
import Navbar from "../../components/admin/Navbar";

export default {
  name: "Dashboard",
  components: {
    Sidebar,
    Navbar
  }

}
</script>
