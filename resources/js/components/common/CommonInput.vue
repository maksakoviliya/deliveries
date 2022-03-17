<template>
  <div
      class="w-full relative"
  >
    <label :for="name" class="block text-sm font-medium leading-tight" v-if="label">{{ label }}</label>
    <input
        class="block px-3 py-2 rounded border w-full outline-2 outline-indigo-300"
        :class="{ 'border-red-400': !!errorMessage }"
        :name="name"
        :id="name"
        :type="type"
        :value="inputValue"
        :placeholder="placeholder"
        @input="handleChange"
        :disabled="disabled"
        @blur="handleBlur"
    />

    <p class="absolute top-full leading-tight w-full overflow-ellipsis text-red-400 text-xs font-medium" v-show="errorMessage || meta.valid">
      {{ errorMessage || successMessage }}
    </p>
  </div>
</template>

<script>
import { useField } from "vee-validate";

export default {
  props: {
    type: {
      type: String,
      default: "text",
    },
    value: {
      type: [String, Number],
      default: "",
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    name: {
      type: String,
      required: true,
    },
    label: {
      type: String,
      required: false,
    },
    successMessage: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    checkboxValue: {
      required: false
    }
  },

  watch: {
    value(val) {
      this.inputValue = this.value
    }
  },

  setup(props) {
    // we don't provide any rules here because we are using form-level validation
    // https://vee-validate.logaretm.com/v4/guide/validation#form-level-validation
    const {
      value: inputValue,
      errorMessage,
      handleBlur,
      handleChange,
      meta,
    } = useField(props.name, undefined, {
      initialValue: props.value,
    });

    return {
      handleChange,
      handleBlur,
      errorMessage,
      inputValue,
      meta,
    };
  },
};
</script>