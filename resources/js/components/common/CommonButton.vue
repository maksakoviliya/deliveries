<template>
  <button :type="type"
          class="inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2"
          :class="classes">
    <slot name="icon"></slot>
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: "CommonButton",

  props: {
    type: {
      default: 'submit'
    },
    color: {
      type: String,
      default: 'primary'
    }
  },

  computed: {
    classes() {
      switch (this.color) {
        case 'primary':
          return 'border-transparent text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500'
        case 'success':
          return 'border-transparent text-white bg-green-600 hover:bg-green-700 focus:ring-green-500'
      }
    }
  }
}
</script>
