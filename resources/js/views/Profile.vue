<template>
  <div>
    <Navbar/>

    <div class="max-w-4xl mx-auto mt-10 flex flex-col md:flex-row gap-5 px-3 items-stretch">
      <UserProfile class="md:w-1/2" />

      <CompanyData class="md:w-1/2" />
    </div>
  </div>
</template>

<script>
import UserProfile from "../components/user/UserProfile";
import Navbar from "../components/common/Navbar";
import CompanyData from "../components/user/CompanyData";

export default {
  name: "Profile",

  components: {
    UserProfile,
    Navbar,
    CompanyData
  }
}
</script>

<style scoped>

</style>