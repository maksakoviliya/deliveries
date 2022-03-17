<template>
  <div
      class="w-full relative"
  >

    <Field v-slot="{ field }"  :name="name" type="checkbox" :value="true">
      <label :for="name" class="block text-sm font-medium" v-if="label">
        <input type="checkbox" :id="name" :name="name" :disabled="disabled" v-bind="field" :value="true" />
        {{ label }}
      </label>
    </Field>

    <ErrorMessage :name="name" />
<!--    <p class="absolute top-full leading-tight w-full overflow-ellipsis text-red-400 text-xs font-medium" v-show="errorMessage || meta.valid">-->
<!--      {{ errorMessage || successMessage }}-->
<!--    </p>-->
  </div>
</template>

<script>
import {ErrorMessage, Field} from "vee-validate";

export default {
  props: {
    name: {
      type: String,
      required: true,
    },
    label: {
      type: String,
      required: false,
    },
    disabled: {
      type: Boolean,
      default: false
    },
  },


  components: {
    Field,
    ErrorMessage
  },
};
</script>