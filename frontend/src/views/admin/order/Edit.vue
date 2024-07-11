<script>
import {mapActions, mapState} from "vuex";
import router from "@/router";

export default {
  name: "OrderEdit",

  data(){
    return{
      orderItems: [
        {
          product_id: null,
          quantity: '',
          price: ''
        }
      ],
    }
  },

  computed: {
    ...mapState({
      editOrder: state => state.order.order,
      products: state => state.product.products,
      customers: state => state.customer.customers,
      message: state => state.order.success_message,
      errors: state => state.order.errors,
      success_status: state => state.order.success_status,
      error_status: state => state.order.error_status
    }),

    totalAmount() {
      if (Array.isArray(this.editOrder.order_items)) {
        return this.editOrder.order_items.reduce((sum, item) => sum + (item.price || 0), 0);
      }
      return 0;
    }
  },

  watch: {
    totalAmount(newVal) {
      this.editOrder.total_amount = newVal;
    }
  },

  mounted() {
    this.getAllCustomers();
    this.getAllProducts();
    this.getEditOrder(this.$route.params.id);
  },

  methods: {
    ...mapActions({
      getAllCustomers: "customer/GetAllCustomer",
      getAllProducts: "product/GetAllProduct",
      getEditOrder: "order/GetSingleOrder"
    }),

    addFormItem() {
      this.editOrder.order_items.push({
        product_id: null,
        quantity: '',
        price: ''
      });
    },
    removeFormItem(index) {
      if (this.editOrder.order_items.length > 1) {
        this.editOrder.order_items.splice(index, 1);
      }
    },

    updatePrice(index) {
      const item = this.editOrder.order_items[index];
      const product = this.products.find(p => p.id === item.product_id);

      if (product && item.quantity > 0) {
        item.price = product.price * item.quantity;
      } else {
        item.price = 0;
      }
    },

    updateOrder: async function(){
      try {
        let id = this.$route.params.id;
        let formData = new FormData();

        formData.append('customer_id', this.editOrder.customer_id);
        formData.append('total_amount', this.editOrder.total_amount);
        formData.append('status', this.editOrder.status);

        this.editOrder.order_items.forEach((item, index) => {
          formData.append(`orderItems[${index}][product_id]`, item.product_id);
          formData.append(`orderItems[${index}][quantity]`, item.quantity);
          formData.append(`orderItems[${index}][price]`, item.price);
        });

        await this.$store.dispatch('order/UpdateOrder', {id:id, data:formData}).then(() => {

          if (this.success_status === 200)
          {
            this.$swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: this.message,
              showConfirmButton: false,
              timer: 1500
            });

            this.getEditOrder(id);

            setTimeout(function () {
              router.push({path: '/order'});
            },2000)
          }
        })
      }catch (e) {
        if (this.error_status === 422)
        {
          console.log('error');
        }else {
          this.$swal.fire({
            icon: 'error',
            text: 'Oops',
            title: 'Something wen wrong!!!',
          });
        }
      }
    }
  }
}
</script>

<template>
  <div id="edit">
    <v-row class="mx-5 mt-5">
      <v-col cols="12">
        <v-row>
          <v-col cols="12" md="12" sm="12" lg="12">
            <v-card>
              <v-card-title><h3>Update Order</h3></v-card-title>

              <v-divider></v-divider>

              <v-card-text>
                <v-form v-on:submit.prevent="updateOrder">

                  <v-col cols="12">
                    <v-row wrap>

                      <v-col cols="12" class="d-flex">
                        <v-row wrap>
                          <v-col cols="12" md="8" sm="4" lg="12">
                            <v-select
                                variant="outlined"
                                v-model="editOrder.customer_id"
                                :items="customers"
                                item-title="first_name"
                                item-value="id"
                                label="select Customer"
                            ></v-select>
                            <p v-if="errors.customer_id" class="error custom_error">{{errors.customer_id[0]}}</p>
                          </v-col>
                        </v-row>
                      </v-col>

                      <v-col cols="12" class="d-flex" v-for="(item, index) in editOrder.order_items" :key="index">
                        <v-row wrap>

                          <v-col cols="12" md="3" sm="3" lg="3">
                            <v-select
                                variant="outlined"
                                :items="products"
                                item-title="name"
                                item-value="id"
                                label="select Product"
                                v-model="item.product_id"
                                @change="updatePrice(index)"
                            ></v-select>
                          </v-col>

                          <v-col cols="12" md="3" sm="3" lg="3">
                            <v-text-field
                                type="text"
                                label="Quantity"
                                persistent-hint
                                variant="outlined"
                                v-model="item.quantity"
                                @input="updatePrice(index)"
                            ></v-text-field>
                          </v-col>

                          <v-col cols="12" md="3" sm="3" lg="3">
                            <v-text-field
                                type="text"
                                label="Price"
                                persistent-hint
                                variant="outlined"
                                v-model="item.price"
                            ></v-text-field>
                          </v-col>

                          <v-col cols="12" md="3" sm="3" lg="3">
                            <v-btn
                                flat
                                color="success"
                                class="custom-btn mr-2"
                                @click="addFormItem"
                            >
                              <v-icon>mdi-plus</v-icon>
                            </v-btn>

                            <v-btn
                                flat
                                color="red"
                                class="custom-btn mr-2"
                                @click="removeFormItem(index)"
                            >
                              <v-icon>mdi-minus</v-icon>
                            </v-btn>
                          </v-col>
                        </v-row>
                      </v-col>

                      <v-col cols="12" md="8" sm="12" lg="12">
                        <v-text-field
                            type="text"
                            v-model="totalAmount"
                            label="Total Amount"
                            persistent-hint
                            variant="outlined"
                            required
                        ></v-text-field>
                        <p v-if="errors.total_amount" class="error custom_error">{{errors.total_amount[0]}}</p>
                      </v-col>

                      <v-col cols="12" md="8" sm="12" lg="12">
                        <v-checkbox
                            v-model="editOrder.status"
                            label="Status"
                        ></v-checkbox>
                        <p v-if="errors.status" class="error custom_error">{{errors.status}}</p>
                      </v-col>

                    </v-row>

                    <v-row wrap>
                      <v-col cols="12" md="8" sm="12" lg="12" :class="['d-flex', 'justify-end']">
                        <v-btn
                            flat
                            color="primary"
                            class="custom-btn mr-2"
                            router
                            to="/order"
                        >
                          Back
                        </v-btn>
                        <v-btn
                            flat
                            color="success"
                            type="submit"
                            class="custom-btn mr-2"
                        >
                          Submit
                        </v-btn>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-form>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </div>
</template>

<style scoped>
.custom-btn {
  margin-right: 10px;
  margin-top: 10px;
}
</style>