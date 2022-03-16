<template>
  <div
      class="w-full relative datepicker"
  >
    <label :for="name" class="block text-sm font-medium" v-if="label">{{ label }}</label>

    <Slider :model-value="value" :min="min" :max="max" :id="name" class="mt-10" :format="format" :merge="2" @change="handleValueChange" />

        <p class="absolute top-full leading-tight w-full overflow-ellipsis text-red-400 text-xs font-medium"
           v-show="errorMessage || meta.valid">
          {{ errorMessage || successMessage }}
        </p>
  </div>
</template>

<script>
import Slider from '@vueform/slider'
import {useField} from "vee-validate";

export default {
  components: {
    Slider,
  },

  props: {
    type: {
      type: String,
      default: "text",
    },
    min: {
      default: 0
    },
    max: {
      default: 24
    },
    value: {
      default: [
        9, 18
      ],
    },
    format: {
      default: () => {
        return {
          suffix: ":00"
        }
      }
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
  },

  setup(props, {emit}) {
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
}
</script>

<style src="@vueform/slider/themes/default.css"></style>
<style>
:root {
  --slider-connect-bg: #3989ff;
  --slider-tooltip-bg: #3989ff;
  --slider-handle-ring-color: #3989ff30;
}
</style>

