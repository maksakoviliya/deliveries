<template>
  <div
      class="w-full relative"
  >
    <label :for="name" class="block text-sm font-medium" v-if="label">{{ label }}</label>
    <vSelect :name="name"
             :id="name" :label="labelKey" :clearable="false" :class="selectClass" :model-value="options.find(item => item[valueKey] === value)" :options="options"
             @option:selected="handleValueChange"/>
    <p class="absolute top-full leading-tight w-full overflow-ellipsis text-red-400 text-xs font-medium"
       v-show="errorMessage || meta.valid">
      {{ errorMessage || successMessage }}
    </p>
  </div>
</template>

<script>
import {useField} from "vee-validate";
import vSelect from "vue-select";

export default {
  name: "CustomSelect",

  components: {
    vSelect,
  },

  props: {
    value: {
      type: [String, Number],
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
    },
    selectClass: {
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
      emit('change', val[props.valueKey])
      handleChange(val[props.valueKey])
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