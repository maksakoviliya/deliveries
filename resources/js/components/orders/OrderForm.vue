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
              v-slot="{ values, setFieldValue }"
              :initial-values="order"
              class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Форма заказа</DialogTitle>
              <div class="grid md:grid-cols-2 gap-4 mt-4 ">
                <div class="bg-gray-50 rounded-lg px-4 py-5 shadow flex flex-col gap-2">
                  <h4 class="font-medium"> Получатель: </h4>
                  <CommonSelect name="recipient_id"
                                key="id"
                                label="Выберите из ваших получателей или введите вручную"
                                :disabled="viewMode"
                                label-key="name"
                                value-key="id"
                                @input="handleSelectRecipient(setFieldValue)"
                                :options="recipients"/>
                  <CommonInput name="name"
                               label="ФИО или наименование ИП/ООО"
                               :disabled="viewMode"
                               placeholder="ФИО или наименование ИП/ООО"/>
                  <CommonInput name="phone"
                               label="Телефон"
                               :disabled="viewMode"
                               placeholder="Телефон"/>
                  <CommonInput name="address"
                               label="Адрес доставки"
                               :disabled="viewMode"
                               placeholder="Адрес доставки"/>
                  <CommonInput name="product_name"
                               label="Наименование товара"
                               :disabled="viewMode"
                               placeholder="Наименование товара"/>
                  <h4 class="text-sm font-medium text-gray-600 mt-4">Ваш тариф:</h4>
                  <dl v-if="user.tarif" class="text-gray-500 text-sm">
                    <div class="grid grid-cols-2 gap-3">
                      <dt>Пешком сеогдня:</dt>
                      <dd>{{ user.tarif.foot_today }}₽</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                      <dt>Пешком:</dt>
                      <dd>{{ user.tarif.foot }}₽</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                      <dt>На авто сегодня:</dt>
                      <dd>{{ user.tarif.car_today }}₽</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                      <dt>На авто:</dt>
                      <dd>{{ user.tarif.car }}₽</dd>
                    </div>
                  </dl>
                </div>
                <div class="flex flex-col gap-2">
                  <CommonDatepicker name="delivery_date" :disabled="viewMode"
                                    @change="handleChangeDate($event, setFieldValue)">
                    <template v-slot:label>
                      <div class="flex items-center gap-2 mb-1">
                        <label for="delivery_date" class="block text-sm font-medium">Дата доставки</label>
                        <input type="checkbox" :value="true" class="hidden" v-model="values.today" name="today">
                        <button type="button" class="text-xs px-2 py-0.5 rounded-full block" v-if="!viewMode"
                                :class="values.today ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                                @click="setToday(setFieldValue)">Сегодня
                        </button>
                      </div>
                    </template>
                  </CommonDatepicker>
                  <RangeTimeSlider name="delivery_interval" :disabled="viewMode"
                                   :value="values.delivery_interval" label="Время доставки"/>
                  <CustomSelect name="type"
                                label="Тип доставки"
                                :disabled="viewMode"
                                :value="values.type"
                                @change="handleChangeType($event, setFieldValue)"
                                :options="types"/>
                  <CommonInput name="assessed_value"
                               label="Оценочная стоимость"
                               :disabled="viewMode"
                               placeholder="Оценочная стоимость"/>
                  <CommonCheckbox name="cod"
                                  :disabled="viewMode"
                                  label="Наложенный платеж"/>
                  <CommonInput name="cod_price"
                               v-show="values.cod"
                               label="Сумма для оплаты"
                               :disabled="viewMode"
                               placeholder="Сумма для оплаты"/>
                  <CommonSelect name="payment_type"
                                label="Тип оплаты"
                                :disabled="viewMode"
                                :options="payment_types"/>
                  <CommonInput name="quantity"
                               type="number"
                               label="Количество (шт)"
                               :disabled="viewMode"
                               placeholder="Количество единиц товара"/>
                  <CommonInput name="weight"
                               label="Общий вес (кг)"
                               :disabled="viewMode"
                               placeholder="Общий вес"/>
                  <CommonInput name="comment"
                               label="Комментарий"
                               :disabled="viewMode"
                               placeholder="Комментарий"/>

                  <input name="price" class="hidden" v-model="cost">
                </div>
              </div>
            </div>
            <div
                class="bg-gray-50 border-t border-gray-200 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse items-center gap-2">
              <CommonButton type="submit" color="success" v-if="!$route.params.view">
                Оформить заказ
              </CommonButton>
              <CommonButton type="button" color="outline-gray" @click="handleClose">
                Отменить
              </CommonButton>
              <div class="mr-auto">
                <b> Итоговая стоимость доставки</b>: {{ cost }}₽
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
import "yup-phone";
import {mapActions, mapGetters} from "vuex";
import CommonSelect from "../common/CommonSelect";
import CommonInput from "../common/CommonInput";
import CommonDatepicker from "../common/CommonDatepicker";
import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";
import CommonCheckbox from "../common/CommonCheckbox";
import CustomSelect from "../common/CustomSelect";
import RangeTimeSlider from "../common/RangeTimeSlider";
import {omit} from "lodash";

const {DateTime} = require("luxon");

const order = {
  recipient_id: null,
  name: "",
  address: null,
  phone: null,
  product_name: null,
  type: 'foot',
  today: true,
  delivery_date: DateTime.now(),
  delivery_interval: [
    9, 18
  ],
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
    RangeTimeSlider,
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
    CustomSelect,
  },

  data() {
    const schema = yup.object({
      name: yup.string().required(),
      phone: yup.string().required().length(11).matches(/^7\d+$/, 'Не верный формат номера'),
      address: yup.string().required(),
      product_name: yup.string().required(),
      assessed_value: yup.string().required(),
      delivery_date: yup.string().required(),
      delivery_interval: yup.array().max(2).required(),
      weight: yup.number().required(),
      quantity: yup.number().required().min(0),
      // today: yup.boolean(),
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
      todayDelivery: 'today',
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
      if(this.$route.params.id && this.$route.params.id !== 'create') {
        return this.order.price
      } else {
        return this.user.tarif[this.deliveryType + (this.todayDelivery ? `_${this.todayDelivery}` : '')]
      }
    },
    viewMode() {
      return this.$route.params.view === 'view'
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
    handleChangeType(value, setFieldValue) {
      this.deliveryType = value
      setFieldValue('price', this.cost)
    },
    handleChangeDate(value, setFieldValue) {
      let isToday = DateTime.fromJSDate(value) >= DateTime.now().startOf('day') && DateTime.now().endOf('day') > DateTime.fromJSDate(value)
      this.todayDelivery = isToday ? 'today' : false
      setFieldValue('today', isToday)
      setFieldValue('price', this.cost)
    },
    onSubmit(values, actions) {
      values.price = this.cost
      ApiService.createOrder(values)
          .then(async (res) => {
            this.$notify({
              type: 'success',
              title: 'Заказ создан'
            })
            await this.handleClose()
            await this.fetchOrders()
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
    handleSelectRecipient(setFieldValue) {
      const {
        id,
        name,
        phone,
        address,
        product_name
      } = this.recipients.find(item => parseInt(item.id) === parseInt(event.target.value))

      setFieldValue('recipient_id', id)
      setFieldValue('name', name)
      setFieldValue('phone', phone)
      setFieldValue('address', address)
      setFieldValue('product_name', product_name)
    },
    async setOrder(id) {
      this.fetchOrder(id)
          .then(res => {
            this.order = {...this.order, ...omit(res, this.$route.params.view ? [] : ['delivery_date', 'today'])}
          })
          .catch(e => {
            this.$notify({
              type: 'error',
              title: 'Возникла ошибка!',
            })
          })
    },
    setToday(setFieldValue) {
      this.todayDelivery = 'today'
      setFieldValue('delivery_date', DateTime.now())
      setFieldValue('today', true)
      setFieldValue('price', this.cost)
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