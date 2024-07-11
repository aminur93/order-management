<script>
import {mapActions, mapState} from "vuex";
import router from "@/router";

export default {
  name: "CustomerEdit",

  data(){
    return{}
  },

  computed: {
    ...mapState({
      editCustomer: state => state.customer.customer,
      message: state => state.customer.success_message,
      errors: state => state.customer.errors,
      success_status: state => state.customer.success_status,
      error_status: state => state.customer.error_status
    })
  },

  mounted() {
    this.getEditSingleCustomer(this.$route.params.id)
  },

  methods: {
    ...mapActions({
      getEditSingleCustomer: "customer/GetSingleCustomer"
    }),

    updateCustomer: async function(){
      try {
        let id = this.$route.params.id;
        let formData = new FormData();

        formData.append('first_name', this.editCustomer.first_name);
        formData.append('last_name', this.editCustomer.last_name);
        formData.append('email', this.editCustomer.email);
        formData.append('phone', this.editCustomer.phone);
        formData.append('address', this.editCustomer.address);

        await this.$store.dispatch('customer/UpdateCustomer', {id:id, data:formData}).then(() => {

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

            this.getEditSingleCustomer(id)

            setTimeout(function () {
              router.push({path: '/customer'});
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
  },
}
</script>

<template>
  <div id="edit">
    <v-row class="mx-5 mt-5">
      <v-col cols="12">
        <v-row>
          <v-col cols="12" md="12" sm="12" lg="12">
            <v-card>
              <v-card-title><h3>Edit Customer</h3></v-card-title>

              <v-divider></v-divider>

              <v-card-text>
                <v-form v-on:submit.prevent="updateCustomer">

                  <v-col cols="12">
                    <v-row wrap>

                      <v-col cols="12" class="d-flex">
                        <v-row wrap>
                          <v-col cols="12" md="6" sm="6" lg="6">
                            <v-text-field
                                type="text"
                                v-model="editCustomer.first_name"
                                label="First Name"
                                persistent-hint
                                variant="outlined"
                                required
                            ></v-text-field>
                            <p v-if="errors.first_name" class="error custom_error">{{errors.first_name[0]}}</p>
                          </v-col>

                          <v-col cols="12" md="6" sm="6" lg="6">
                            <v-text-field
                                type="text"
                                v-model="editCustomer.last_name"
                                label="Last Name"
                                persistent-hint
                                variant="outlined"
                                required
                            ></v-text-field>
                            <p v-if="errors.last_name" class="error custom_error">{{errors.last_name[0]}}</p>
                          </v-col>
                        </v-row>
                      </v-col>

                      <v-col cols="12" class="d-flex">
                        <v-row wrap>
                          <v-col cols="12" md="6" sm="6" lg="6">
                            <v-text-field
                                type="email"
                                v-model="editCustomer.email"
                                label="Email"
                                persistent-hint
                                variant="outlined"
                                required
                            ></v-text-field>
                            <p v-if="errors.email" class="error custom_error">{{errors.email[0]}}</p>
                          </v-col>

                          <v-col cols="12" md="6" sm="6" lg="6">
                            <v-text-field
                                type="number"
                                v-model="editCustomer.phone"
                                label="Phone"
                                persistent-hint
                                variant="outlined"
                                required
                            ></v-text-field>
                            <p v-if="errors.phone" class="error custom_error">{{errors.phone[0]}}</p>
                          </v-col>
                        </v-row>
                      </v-col>

                      <v-col cols="12" md="8" sm="12" lg="12">
                        <v-textarea
                            v-model="editCustomer.address"
                            label="Address"
                            variant="outlined"
                        ></v-textarea>
                        <p v-if="errors.address" class="error custom_error">{{errors.address[0]}}</p>
                      </v-col>

                    </v-row>

                    <v-row wrap>
                      <v-col cols="12" md="8" sm="12" lg="12" :class="['d-flex', 'justify-end']">
                        <v-btn
                            flat
                            color="primary"
                            class="custom-btn mr-2"
                            router
                            to="/customer"
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
.error{
  color: red;
}
</style>