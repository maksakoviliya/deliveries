<template>
  <component
      :is="component"
      :type="type"
      class="inline-flex items-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2"
      :class="classes">
    <slot name="icon"></slot>
    <slot></slot>
  </component>
</template>

<script>
export default {
  name: "CommonButton",

  props: {
    component: {
      type: String,
      default: 'button'
    },
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
        case 'danger':
          return 'border-transparent text-white bg-red-600 hover:bg-red-700 focus:ring-red-500'
        case 'outline-gray':
          return 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 focus:ring-indigo-500'
      }
    }
  }
}
</script>
