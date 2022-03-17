<template>
  <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
    <div>
            <p class="text-sm text-gray-700">
<!--              Результаты с-->
<!--              {{ ' ' }}-->
<!--              <span class="font-medium">1</span>-->
<!--              {{ ' ' }}-->
<!--              по-->
<!--              {{ ' ' }}-->
<!--              <span class="font-medium">10</span>-->
<!--              {{ ' ' }}-->
<!--              из-->
<!--              {{ ' ' }}-->
              <span class="font-medium">Всего: {{ meta.total }}</span>
            </p>
    </div>
    <div>
      <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
        <router-link :to="{ name: $route.name, params: $route.params, query: {...$route.query, page: meta.current_page - 1} }"
                     :class="{'pointer-events-none': meta.current_page === 1}"
           class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
          <span class="sr-only">Previous</span>
          <ChevronLeftIcon class="h-5 w-5" aria-hidden="true"/>
        </router-link>
        <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
        <!--        <a href="#" aria-current="page" class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium"> 1 </a>-->
        <router-link :to="{ name: $route.name, params: $route.params, query: {...$route.query, page} }"
           class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"
           :class="{'z-10 bg-indigo-50 border-indigo-500 text-indigo-600': page === meta.current_page}"
           v-for="page in meta.last_page" :key="page">
          {{ page }} </router-link>
        <!--        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium"> 3 </a>-->
        <!--        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"> ... </span>-->
        <!--        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium"> 8 </a>-->
        <!--        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"> 9 </a>-->
        <!--        <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"> 10 </a>-->
        <router-link :to="{ name: $route.name, params: $route.params, query: {...$route.query, page: meta.current_page + 1} }"
                     :class="{'pointer-events-none': meta.current_page === meta.last_page}"
           class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
          <span class="sr-only">Next</span>
          <ChevronRightIcon class="h-5 w-5" aria-hidden="true"/>
        </router-link>
      </nav>
    </div>
  </div>
</template>

<script>
import {ChevronLeftIcon, ChevronRightIcon} from "@heroicons/vue/outline";

export default {
  name: "Pagination",

  props: {
    meta: {
      required: true
    },
  },

  watch: {
    '$route.query.page': {
      handler: function() {
        this.$emit('pageChange')
      },
      deep: true,
    }
  },

  components: {
    ChevronLeftIcon,
    ChevronRightIcon,
  },
}
</script>
