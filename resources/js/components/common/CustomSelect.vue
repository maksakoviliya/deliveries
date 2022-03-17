<template>
  <div
      class="w-full relative"
  >
    <label :for="name" class="block text-sm font-medium" v-if="label">{{ label }}</label>
    <vSelect :name="name"
             :multiple="multiple"
             :id="name" :label="labelKey" :clearable="false" :class="selectClass" :placeholder="placeholder" :disabled="disabled"
             :model-value="multiple ? options.filter(item => value.includes(item[valueKey])) : options.find(item => item[valueKey] === value)" :options="options"
             @update:modelValue="handleValueChange"/>
    <p class="absolute top-full leading-tight w-full overflow-ellipsis text-red-400 text-xs font-medium"
       v-show="errorMessage || meta.valid">
      {{ errorMessage || successMessage }}
    </p>
  </div>
</template>

<script>
import {useField} from "vee-validate";
import vSelect from "vue-select";
import 'vue-select/dist/vue-select.css';

export default {
  name: "CustomSelect",

  components: {
    vSelect,
  },

  props: {
    value: {
      type: [String, Number, Array],
      default: "",
    },
    name: {
      type: String,
      required: true,
    },
    multiple: {
      default: false
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
    },
    selectClass: {
      type: String,
    },
    placeholder: {
      type: String,
    }
  },

  setup(props, {emit}) {
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

    const handleValueChange = (val) => {
      let result = props.multiple ? val.map(item => item[props.valueKey]) : val[props.valueKey]
      emit('change', result)
      handleChange(result)
    }
    return {
      handleValueChange,
      handleBlur,
      errorMessage,
      inputValue,
      meta,
    };
  },
};
</script>