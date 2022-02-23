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
              v-slot="{ values }"
              :initial-values="order"
              class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Форма заказа</DialogTitle>
              <div class="grid md:grid-cols-2 gap-4 mt-4 ">
                <div>
                  <div class="bg-gray-50 rounded-lg px-4 py-5 shadow flex flex-col gap-2">
                    <h4 class="font-medium"> Получатель: </h4>
                    <CommonSelect name="recipient_id"
                                  key="id"
                                  label="Выберите из ваших получателей или введите вручную"
                                  label-key="name"
                                  value-key="id"
                                  @input="handleSelectRecipient"
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

                  <CommonSelect name="type"
                                label="Тип доставки"
                                class="mt-2"
                                :options="types"/>
                </div>
                <div>asd</div>
              </div>
            </div>
            <div class="bg-gray-50 border-t border-gray-200 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
              <CommonButton type="submit" color="success">
                Оформить заказ
              </CommonButton>
              <CommonButton type="button" color="outline-gray" @click="$emit('close')">
                Отменить
              </CommonButton>
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

export default {
  name: "OrderForm",

  components: {
    Dialog,
    Form,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    LogoutIcon,
    CommonButton,
    CommonSelect,
    CommonInput
  },

  data() {
    const schema = yup.object({
      name: yup.string().required(),
    });

    const order = {
      recipient_id: null,
      name: null,
      address: null,
      phone: null,
      product_name: null,
      type: 'foot',
      delivery_from: null,
      delivery_to: null,
      assessed_value: null,
      cod: null,
      payment_type: null,
      comment: null,
    }

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
      ]
    }
  },

  computed: {
    ...mapGetters({
      recipients: "order/recipients"
    }),
    open() {
      return !!this.$route.params.id
    },
  },

  methods: {
    ...mapActions({
      fetchRecipients: "order/fetchRecipients",
      fetchOrder: "order/fetchOrder",
    }),
    handleClose() {
      this.$router.push({name: this.$route.name, query: this.$route.query, params: {id: null}})
    },
    onSubmit(values) {
      console.log('values', values)
    },
    handleSelectRecipient(event) {
      const {
        id,
        name,
        phone,
        address,
        product_name
      } = this.recipients.find(item => parseInt(item.id) === parseInt(event.target.value))

      this.order.recipient_id = id
      this.order.name = name
      this.order.phone = phone
      this.order.address = address
      this.order.product_name = product_name
    },
    async setOrder(id) {
      this.fetchOrder(id)
          .then(res => {
            console.log('res', res)
          })
          .catch(e => {
            console.log('e', e)
          })
    }
  },

  async mounted() {
    await this.fetchRecipients()
    if (this.$route.params.id !== 'create') {
      await this.setOrder(this.$route.params.id)
    }
  }
}
</script>