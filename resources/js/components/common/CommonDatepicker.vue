<template>
  <div
      class="w-full relative datepicker"
  >
    <label :for="name" class="block text-sm font-medium" v-if="label">{{ label }}</label>
    <!--    <Datepicker :id="name" :name="name" v-model="date" :class="{ 'border-red-400': !!errorMessage }"></Datepicker>-->

    <Datepicker :id="name" :name="name" :model-value="inputValue" :minDate="minDate" @update:modelValue="handleChange" format="dd.MM.yyyy HH:mm"
                :range="range" teleport=".datepicker" position="left" :auto-position="false" :start-time="{ hours: '12', minutes: '00' }"
                :alt-position="((el) => {
      return {
        top: '100%', left: 0, transform: 0
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
    range: {
      type: Boolean,
      default: true
    },
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
    placeholder: {
      type: String,
      default: "",
    },
    minDate: {
      default: new Date()
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

  components: {Datepicker},

  data() {
    return {
      date: null,
    };
  }
}
</script>