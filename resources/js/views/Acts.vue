<template>
  <div>
    <Navbar />
    <ActsList class="max-w-6xl mx-auto px-3 md:px-10 mt-10" />
  </div>
</template>

<script>
import Navbar from "../components/common/Navbar";
import ActsList from "../components/acts/ActsList";

export default {
  name: "Acts",

  components: {
    Navbar,
    ActsList
  }
}
</script>