<template>
  <div
      class="relative datepicker-top"
  >
    <slot name="label">
      <label :for="name" class="block text-sm font-medium" v-if="label">{{ label }}</label>
    </slot>

    <Datepicker :id="name" :name="name" :model-value="inputValue" :minDate="minDate" :disabled="disabled" @update:modelValue="handleValueChange"
                :format="format" :auto-apply="autoApply" locale="ru" :month-change-on-scroll="false"
                :range="range" teleport=".datepicker-top" position="left" :auto-position="false" :enable-time-picker="enableTimePicker"
                :alt-position="((el) => {
      return {
        top: '120%', left: 0, transform: 0
      }
    })"></Datepicker>
    <p class="absolute top-full leading-tight w-full overflow-ellipsis text-red-400 text-xs font-medium"
       v-show="errorMessage || meta.valid">
      {{ errorMessage || successMessage }}
    </p>
  </div>
</template>

<script>
import Datepicker from 'vue3-date-time-picker';
import 'vue3-date-time-picker/dist/main.css'
import {useField} from "vee-validate";

export default {
  name: "CommonDatepicker",

  props: {
    type: {
      type: String,
      default: "text",
    },
    autoApply: {
      type: Boolean,
      default: true
    },
    disabled: {
      type: Boolean,
      default: false
    },
    enableTimePicker: {
      type: Boolean,
      default: false
    },
    range: {
      type: Boolean,
      default: false
    },
    format: {
      type: String,
      default: "dd.MM.yyyy"
    },
    value: {
      type: [String, Array],
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
    placeholder: {
      type: String,
      default: "",
    },
    minDate: {
      default: new Date(new Date(new Date().setHours(0, 0, 0, 0)).toString().split('GMT')[0] + ' UTC').toISOString()
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
      emit('change', val)
      handleChange(val)
    }

    return {
      handleValueChange,
      handleBlur,
      errorMessage,
      inputValue,
      meta,
    };
  },

  components: {Datepicker},
}
</script>