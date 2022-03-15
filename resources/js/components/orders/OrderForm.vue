<template>
  <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="fixed z-10 inset-0 overflow-y-auto" @close="handleClose">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                         leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
        </TransitionChild>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <TransitionChild as="template" enter="ease-out duration-300"
                         enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                         leave-from="opacity-100 translate-y-0 sm:scale-100"
                         leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
          <Form
              @submit="onSubmit"
              :validation-schema="schema"
              v-slot="{ values, setValues }"
              :initial-values="order"
              class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Форма заказа</DialogTitle>
              <div class="grid md:grid-cols-2 gap-4 mt-4 ">
                <div class="bg-gray-50 rounded-lg px-4 py-5 shadow flex flex-col gap-2">
                  <h4 class="font-medium" > Получатель: </h4>
                  <CommonSelect name="recipient_id"
                                key="id"
                                label="Выберите из ваших получателей или введите вручную"
                                label-key="name"
                                value-key="id"
                                @input="handleSelectRecipient(setValues)"
                                :options="recipients"/>
                  <CommonInput name="name"
                               label="ФИО или наименование ИП/ООО"
                               placeholder="ФИО или наименование ИП/ООО"/>
                  <CommonInput name="phone"
                               label="Телефон"
                               placeholder="Телефон"/>
                  <CommonInput name="address"
                               label="Адрес доставки"
                               placeholder="Адрес доставки"/>
                  <CommonInput name="product_name"
                               label="Наименование товара"
                               placeholder="Наименование товара"/>
                </div>
                <div class="flex flex-col gap-2">
                  <CommonDatepicker name="delivery_interval" label="Дата доставки" @change="handleChangeDate" />
                  <CustomSelect name="type"
                                label="Тип доставки"
                                @change="handleChangeType"
                                :options="types"/>
                  <CommonInput name="assessed_value"
                               label="Оценочная стоимость"
                               placeholder="Оценочная стоимость"/>
                  <CommonCheckbox name="cod"
                                  label="Наложенный платеж"/>
                  <CommonInput name="cod_price"
                               v-show="values.cod"
                               label="Сумма для оплаты"
                               placeholder="Сумма для оплаты"/>
                  <CommonSelect name="payment_type"
                                label="Тип оплаты"
                                :options="payment_types"/>
                  <CommonInput name="quantity"
                               type="number"
                               label="Количество (шт)"
                               placeholder="Количество единиц товара"/>
                  <CommonInput name="weight"
                               label="Общий вес (кг)"
                               placeholder="Общий вес"/>
                  <CommonInput name="comment"
                               label="Комментарий"
                               placeholder="Комментарий"/>

                  <input name="price" class="hidden" v-model="cost">
                </div>
              </div>
            </div>
            <div class="bg-gray-50 border-t border-gray-200 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse items-center gap-2">
              <CommonButton type="submit" color="success">
                Оформить заказ
              </CommonButton>
              <CommonButton type="button" color="outline-gray" @click="handleClose">
                Отменить
              </CommonButton>
              <div class="mr-auto">
                <b>Стоимость доставки</b>: {{ cost }}₽
              </div>
            </div>
          </Form>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import {Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {LogoutIcon} from "@heroicons/vue/outline";
import CommonButton from "../common/CommonButton";
import {Form} from "vee-validate";
import * as yup from "yup";
import {mapActions, mapGetters} from "vuex";
import CommonSelect from "../common/CommonSelect";
import CommonInput from "../common/CommonInput";
import CommonDatepicker from "../common/CommonDatepicker";
import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";
import CommonCheckbox from "../common/CommonCheckbox";
import CustomSelect from "../common/CustomSelect";
const { DateTime } = require("luxon");

const order = {
  recipient_id: null,
  name: "",
  address: null,
  phone: null,
  product_name: null,
  type: 'foot',
  delivery_interval: null,
  assessed_value: null,
  cod: false,
  cod_price: null,
  quantity: 1,
  payment_type: 'card',
  comment: null,
  weight: null,
}

export default {
  name: "OrderForm",

  components: {
    CommonCheckbox,
    Dialog,
    Form,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    LogoutIcon,
    CommonButton,
    CommonSelect,
    CommonInput,
    CommonDatepicker,
    CustomSelect
  },

  data() {
    const schema = yup.object({
      name: yup.string().required(),
      phone: yup.string().required(),
      address: yup.string().required(),
      product_name: yup.string().required(),
      assessed_value: yup.string().required(),
      delivery_interval: yup.array().required(),
      weight: yup.number().required(),
      quantity: yup.number().required().min(0),
      cod: yup.boolean(),
      cod_price: yup.number().when('cod', {
        is: (val) => val,
        then: (schema) => schema.required(),
        otherwise: (schema) => schema.nullable(true),
      }),
    });

    return {
      schema,
      order,
      types: [
        {
          key: 'foot',
          value: 'foot',
          label: 'Пешком',
        },
        {
          key: 'car',
          value: 'car',
          label: 'На автомобиле',
        },
      ],
      payment_types: [
        {
          key: 'cash',
          value: 'cash',
          label: 'Наличными',
        },
        {
          key: 'card',
          value: 'card',
          label: 'Безналичный',
        },
      ],
      todayDelivery: false,
      deliveryType: 'foot',
    }
  },

  computed: {
    ...mapGetters({
      recipients: "order/recipients",
      user: 'auth/authUser'
    }),
    open() {
      return !!this.$route.params.id
    },
    cost() {
      return this.user.tarif[this.deliveryType + (this.todayDelivery ? `_${this.todayDelivery}` : '')]
    }
  },

  methods: {
    ...mapActions({
      fetchRecipients: "order/fetchRecipients",
      fetchOrder: "order/fetchOrder",
      fetchOrders: "order/fetchOrders"
    }),
    handleClose() {
      this.$router.push({name: this.$route.name, query: this.$route.query, params: {id: null}})
    },
    handleChangeType(value) {
      this.deliveryType = value
    },
    handleChangeDate(val) {
      let isToday = DateTime.fromJSDate(val[0]) <= DateTime.now() &&  DateTime.now() < DateTime.fromJSDate(val[1])
      this.todayDelivery = isToday ? 'today' : false
    },
    onSubmit(values, actions) {
     values.price = this.cost
      ApiService.createOrder(values)
          .then(async (res) => {
            this.$notify({
              type: 'success',
              title: 'Заказ создан'
            })
            await this.fetchOrders()
            this.handleClose()
            this.$emit('close')
          })
          .catch((error) => {
            const errors = getError(error)
            actions.setErrors(errors);
            this.$notify({
              type: 'error',
              title: 'Возникла ошибка!',
            })
          });
    },
    handleSelectRecipient(setValues) {
      const {
        id,
        name,
        phone,
        address,
        product_name
      } = this.recipients.find(item => parseInt(item.id) === parseInt(event.target.value))

      setValues({
        id,
        name,
        phone,
        address,
        product_name,
      })

      // this.$refs.myForm.setValues({
      //   recipient_id: id,
      //   name: name,
      //   phone: phone,
      //   address: address,
      //   product_name: product_name,
      // })
    },
    async setOrder(id) {
      this.fetchOrder(id)
          .then(res => {
            this.order = {...this.order, ...res}
          })
          .catch(e => {
            this.$notify({
              type: 'error',
              title: 'Возникла ошибка!',
            })
          })
    }
  },

  async mounted() {
    await this.fetchRecipients()
    if (this.$route.params.id && this.$route.params.id !== 'create') {
      await this.setOrder(this.$route.params.id)
    }
  }
}
</script>