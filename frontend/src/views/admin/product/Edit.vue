<script>
import {mapActions, mapState} from "vuex";
import router from "@/router";

export default {
  name: "ProductEdit",

  data(){
    return{
      image: '',
      imagePreview: '',
    }
  },

  computed: {
    ...mapState({
      editSingleProduct: state => state.product.product,
      message: state => state.product.success_message,
      errors: state => state.product.errors,
      success_status: state => state.product.success_status,
      error_status: state => state.product.error_status
    })
  },

  mounted() {
    this.getEditSingleProduct(this.$route.params.id);
  },

  methods: {
    ...mapActions({
      getEditSingleProduct: "product/GetSingleProduct"
    }),

    getImageSrc(image) {
      const src = `${this.$store.state.serverPath}/storage/${image}`;
      return src;
    },

    previewNIDImage() {
      const file = this.image;
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreview = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        this.imagePreview = '';
      }
    },

    updateProduct: async function(){
      try {
        let id = this.$route.params.id;
        let formData = new FormData();

        formData.append('name', this.editSingleProduct.name);
        formData.append('price', this.editSingleProduct.price);
        formData.append('description', this.editSingleProduct.description);
        formData.append('image', this.image);
        formData.append('_method', 'PUT');

        await this.$store.dispatch('product/UpdateProduct', {id:id, data:formData}).then(() => {

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

            this.getEditSingleProduct(id);
            this.imagePreview = null;

            setTimeout(function () {
              router.push({path: '/product'});
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
              <v-card-title><h3>Edit Product</h3></v-card-title>

              <v-divider></v-divider>

              <v-card-text>
                <v-form v-on:submit.prevent="updateProduct">

                  <v-col cols="12">
                    <v-row wrap>

                      <v-col cols="12" class="d-flex">
                        <v-row wrap>
                          <v-col cols="12" md="6" sm="6" lg="6">
                            <v-text-field
                                type="text"
                                v-model="editSingleProduct.name"
                                label="Name"
                                persistent-hint
                                variant="outlined"
                                required
                            ></v-text-field>
                            <p v-if="errors.name" class="error custom_error">{{errors.name[0]}}</p>
                          </v-col>

                          <v-col cols="12" md="6" sm="6" lg="6">
                            <v-text-field
                                type="text"
                                v-model="editSingleProduct.price"
                                label="Price"
                                persistent-hint
                                variant="outlined"
                                required
                            ></v-text-field>
                            <p v-if="errors.price" class="error custom_error">{{errors.price[0]}}</p>
                          </v-col>
                        </v-row>
                      </v-col>

                      <v-col cols="12" md="8" sm="12" lg="12">
                        <v-textarea
                            v-model="editSingleProduct.description"
                            label="description"
                            variant="outlined"
                        ></v-textarea>
                        <p v-if="errors.description" class="error custom_error">{{errors.description[0]}}</p>
                      </v-col>

                      <v-col cols="12" class="d-flex">
                        <v-row wrap>
                          <v-col cols="12" md="6" sm="6" lg="6">
                            <v-file-input
                                v-model="image"
                                label="Image"
                                persistent-hint
                                variant="outlined"
                                @change="previewNIDImage"
                            ></v-file-input>
                            <p v-if="errors.image" class="error custom_error">{{errors.image[0]}}</p>
                          </v-col>

                          <v-col cols="12" md="6" sm="6" lg="6">
                            <div v-if="imagePreview">
                              <img :src="imagePreview" alt="Image Preview" style="width: 100%; height: 400px" />
                            </div>
                            <div v-else>
                              <img :src="getImageSrc(editSingleProduct.image)" alt="" width="100%" height="400px">
                            </div>
                          </v-col>
                        </v-row>
                      </v-col>

                    </v-row>

                    <v-row wrap>
                      <v-col cols="12" md="8" sm="12" lg="12" :class="['d-flex', 'justify-end']">
                        <v-btn
                            flat
                            color="primary"
                            class="custom-btn mr-2"
                            router
                            to="/product"
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