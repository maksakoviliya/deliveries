<template>
  <div
      class="w-full relative"
  >
    <label :for="name" class="block text-sm font-medium" v-if="label">{{ label }}</label>
    <select
        class="block px-3 py-2 rounded border w-full outline-2 outline-indigo-300"
        :class="{ 'border-red-400': !!errorMessage, 'bg-gray-100': disabled }"
        :name="name"
        :id="name"
        :disabled="disabled"
        :value="inputValue"
        @input="handleChange"
        @blur="handleBlur"
    >
      <option v-for="option in options" :key="option[key]" :value="option[valueKey]">{{ option[labelKey] }}</option>
    </select>

    <p class="absolute top-full leading-tight w-full overflow-ellipsis text-red-400 text-xs font-medium"
       v-show="errorMessage || meta.valid">
      {{ errorMessage || successMessage }}
    </p>
  </div>
</template>

<script>
import {useField} from "vee-validate";

export default {
  props: {
    value: {
      type: String,
      default: "",
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
    disabled: {
      type: Boolean,
      default: false,
    },
    options: {
      type: Array,
      required: true,
    },
    key: {
      type: String,
      default: 'key'
    },
    labelKey: {
      type: String,
      default: 'label'
    },
    valueKey: {
      type: String,
      default: 'value'
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