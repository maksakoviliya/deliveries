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
              <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900 flex items-center gap-2">
                <h2>Заказа №{{ `${order.id} от ${parseDate(order.created_at)}` }}</h2>
                <OrderStatus :order="order" :show-form="false"/>
              </DialogTitle>
              <div class="grid md:grid-cols-2 gap-4 mt-4 ">
                <div class="bg-gray-50 rounded-lg px-4 py-5 shadow flex flex-col gap-2">
                  <h4 class="font-medium"> Получатель: </h4>
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
                  <CommonSelect label="Статус" name="status" :options="statuses"/>
                  <CustomSelect name="courier_id" label="Курьер" :value="order.courier_id ? order.courier_id : null"
                                :options="couriers" label-key="name" value-key="id"/>
                  <CommonDatepicker name="delivery_interval" label="Дата доставки" @change="handleChangeDate"/>
                  <CommonSelect name="type"
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
            <div
                class="bg-gray-50 border-t border-gray-200 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse items-center gap-2">
              <CommonButton type="submit" color="success">
                Изменить заказ
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
import {Form} from "vee-validate";
import * as yup from "yup";
import {mapActions, mapGetters} from "vuex";
import CommonCheckbox from "../../../components/common/CommonCheckbox";
import CommonButton from "../../../components/common/CommonButton";
import CommonSelect from "../../../components/common/CommonSelect";
import CommonInput from "../../../components/common/CommonInput";
import CommonDatepicker from "../../../components/common/CommonDatepicker";
import ApiService from "../../../services/ApiService";
import {omit, pick} from "lodash";
import OrderStatus from "./OrderStatus";
import CustomSelect from "../../../components/common/CustomSelect";

const {DateTime} = require("luxon");

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
  payment_type: 'card',
  comment: null,
  quantity: null,
  weight: null,
  status: 'processing',
  courier_id: null
}

export default {
  name: "OrderForm",

  components: {
    CustomSelect,
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
    OrderStatus,
  },

  data() {
    const schema = yup.object({
      name: yup.string().required(),
      phone: yup.string().required(),
      address: yup.string().required(),
      product_name: yup.string().required(),
      assessed_value: yup.string().required(),
      delivery_interval: yup.array(),
      weight: yup.number().required(),
      quantity: yup.number().required().min(0),
      cod: yup.boolean(),
      status: yup.string().required(),
      courier_id: yup.number().nullable(true),
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
      statuses: [
        {
          key: 'processing',
          value: 'processing',
          label: 'В обработке'
        },
        {
          key: 'work',
          value: 'work',
          label: 'В работе'
        },
        {
          key: 'delivered',
          value: 'delivered',
          label: 'Доставлен'
        },
        {
          key: 'undelivered',
          value: 'undelivered',
          label: 'Не доставлен'
        }
      ],
      todayDelivery: false,
      deliveryType: 'foot',
    }
  },

  computed: {
    ...mapGetters({
      recipients: "order/recipients",
      couriers: "courier/couriers",
      user: 'auth/authUser'
    }),
    open() {
      return !!this.$route.params.id
    },
    cost() {
      if (this.order.tarif) {
        return this.order.tarif[this.deliveryType + (this.todayDelivery ? `_${this.todayDelivery}` : '')]
      }
    }
  },

  methods: {
    ...mapActions({
      fetchRecipientsForUser: "order/fetchRecipientsForUser",
      fetchOrder: "order/fetchOrder",
      fetchOrders: "order/fetchOrders",
      fetchAllOrders: "order/fetchAllOrders",
    }),
    handleClose() {
      this.$router.push({name: this.$route.name, query: this.$route.query, params: {id: null}})
    },
    handleChangeType(event) {
      this.deliveryType = event.target.value
      return this.deliveryType
    },
    handleChangeDate(val) {
      let isToday = DateTime.fromJSDate(val[0]) <= DateTime.now() && DateTime.now() < DateTime.fromJSDate(val[1])
      this.todayDelivery = isToday ? 'today' : false
      return this.todayDelivery
    },
    onSubmit(values, actions) {
      values.price = this.cost
      ApiService.updateOrder(this.$route.params.id, values)
          .then(async (res) => {
            console.log('res', res)
            this.$notify({
              type: 'success',
              title: 'Заказ обновлен'
            })
            await this.fetchAllOrders()
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
            this.order = {
              ...omit(res, ['client']),
              ...pick(res.client, ['tarif']),
              client_id: res.client.id,
              courier_id: res.courier ? res.courier.id : null
            }
            this.todayDelivery = this.handleChangeDate(this.order.delivery_interval)
            this.deliveryType = this.order.type

            if (this.order.client_id) {
              this.fetchRecipientsForUser(this.order.client_id)
            }
          })
          .catch(e => {
            this.$notify({
              type: 'error',
              text: 'Возникла ошибка!'
            })
          })
    },
    parseDate(date) {
      return DateTime.fromISO(date).toFormat('dd.MM.yy HH:mm')
    },
  },

  async mounted() {
    if (this.$route.params.id && this.$route.params.id !== 'create') {
      await this.setOrder(this.$route.params.id)
    }
  }
}
</script>