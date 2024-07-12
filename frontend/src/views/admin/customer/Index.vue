<script>
import {mapState} from "vuex";
import {http, httpFile} from "@/service/HttpService";
import { saveAs } from 'file-saver';

export default {
  name: "CustomerIndex",

  data(){
    return{
      totalCustomer: 0,
      customers: [],
      loading: true,
      options: {},
      search: '',
      headers: [
        { title: 'ID', key: 'id', sortable: false },
        { title: 'First Name', key: 'first_name' },
        { title: 'Last Name', key: 'last_name' },
        { title: 'Email', key: 'email' },
        { title: 'Phone', key: 'phone' },
        { title: 'Address', key: 'address' },
        { title: 'Actions', key: 'actions', align: 'center', sortable: false },
      ],

      dialog: false,
      file: null
    }
  },

  computed: {
    startIndex() {
      let currentPage = this.options.page;
      let itemsPerPage = this.options.itemsPerPage;

      return (currentPage - 1) * itemsPerPage + 1;
    },

    ...mapState({
      message: state => state.customer.success_message,
      errors: state => state.customer.errors,
      success_status: state => state.customer.success_status,
      error_status: state => state.customer.error_status
    })
  },

  watch: {
    options: {
      handler () {
        this.getAllCustomers()
      },
      deep: true,
    },

    search: {
      handler () {
        this.getAllCustomers()
      },
    },
  },

  mounted() {
    this.getAllCustomers();
  },

  methods: {
    getAllCustomers(){
      this.loading = true

      const { sortBy, sortDesc, page, itemsPerPage } = this.options

      http().get('http://localhost:8000/api/v1/admin/customer', {
        params: {
          sortBy: sortBy[0],
          sortDesc: sortDesc,
          page: page,
          itemsPerPage: itemsPerPage,
          search: this.search
        }
      }).then((result) => {
        this.customers = result.data.data.data;
        this.totalCustomer = result.data.data.total;
        this.loading = false;
      }).catch((err) => {
        console.log(err);
      })
    },

    calculateIndex(item) {
      return this.startIndex + item;
    },

    deleteCustomer: async function(id){
      try {
        await this.$store.dispatch("customer/DeleteCustomer", id).then(() => {
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

            this.getAllCustomers();
          }
        })
      }catch (e) {
        this.$swal.fire({
          icon: 'error',
          text: 'Oops',
          title: 'Something wen wrong!!!',
        });
      }
    },

    customerExport: async function(){
      try {
        const response = await httpFile().get('/v1/admin/customer-download', {
          responseType: 'blob', // Important for handling binary data
        });

        const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        saveAs(blob, 'customers.xlsx');

        this.$swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          title: 'Export successful',
          showConfirmButton: false,
          timer: 1500
        });
      }catch (e) {
        console.error('Export failed:', e);
        this.$swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Export failed',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },

    customerImport: async function(){
      if (!this.file) {
        // Handle case where no file is selected
        this.$swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Please select a file to import!',
        });
        return;
      }

      const formData = new FormData();
      formData.append('file', this.file);

      try {
        await httpFile().post('/v1/admin/customer/import', formData);

        this.$swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          title: 'Import successful',
          showConfirmButton: false,
          timer: 1500
        });

        this.dialog = false;

        this.getAllCustomers();

        // Optionally refresh data or perform other actions after successful import
      } catch (error) {
        console.error('Import failed:', error);
        this.$swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: 'Import failed',
          showConfirmButton: false,
          timer: 1500
        });
      } finally {
        // Reset file input to allow re-import of the same file
        this.file = null;
      }
    },
  }
}
</script>

<template>
  <div id="index">
    <v-row class="mx-5">

      <v-col cols="12" class="pa-6">

        <v-row wrap>
          <v-col cols="6">
            <h1 :class="['text-subtitle-2', 'text-grey', 'mt-5']">Customers</h1>
          </v-col>
        </v-row>

        <v-row wrap>
          <v-col cols="12">
            <v-card elevation="8">
              <v-row>
                <v-col col="6">
                  <v-card-title :class="['text-subtitle-1']">All Customers Lists</v-card-title>
                </v-col>

                <v-col cols="6">
                  <v-card-actions class="justify-end">
                    <v-btn color="success" router to="/add-customer">
                      <v-icon small left>mdi-plus</v-icon>
                      <span>Add New</span>
                    </v-btn>

                    <v-btn color="primary" @click="dialog = true">
                      <v-icon small left>mdi mdi-import</v-icon>
                      <span>Import</span>
                    </v-btn>

                    <v-btn color="info" @click="customerExport">
                      <v-icon small left>mdi mdi-file-export</v-icon>
                      <span>Export</span>
                    </v-btn>
                  </v-card-actions>
                </v-col>
              </v-row>

              <v-divider></v-divider>

              <v-card-text>
                <v-card-title class="d-flex align-center pe-2" style="justify-content: space-between">

                  <h1 :class="['text-subtitle-1', 'text-black']">Customers</h1>

                  <v-spacer></v-spacer>

                  <v-text-field
                      v-model="search"
                      density="compact"
                      label="Search"
                      prepend-inner-icon="mdi-magnify"
                      variant="solo-filled"
                      flat
                      hide-details
                      single-line
                  ></v-text-field>
                </v-card-title>


                <v-data-table-server
                    :headers="headers"
                    :items="customers"
                    :search="search"
                    v-model:options="options"
                    :items-length="totalCustomer"
                    :loading="loading"
                    item-value="name"
                    class="elevation-4"
                    fixed-header
                >
                  <template v-slot:[`item.id`]="{ index }">
                    <td>{{ calculateIndex(index) }}</td>
                  </template>


                  <template v-slot:[`item.actions`]="{ item }">
                    <v-row align="center" justify="center">
                      <td :class="['mx-2']">
                        <v-btn color="warning" icon="mdi-pencil" size="x-small" router :to="`/edit-customer/${item.id}`"></v-btn>
                      </td>

                      <td>
                        <v-btn color="red" icon="mdi-delete" size="x-small" @click="deleteCustomer(item.id)"></v-btn>
                      </td>
                    </v-row>
                  </template>
                </v-data-table-server>

                <v-dialog v-model="dialog" width="50%" height="600px">
                  <v-row class="mx-5 mt-5">
                    <v-col cols="12">
                      <v-row>
                        <v-col cols="12" md="12" sm="12" lg="12">
                          <v-card>
                            <v-card-title><h3>Customer Import</h3></v-card-title>

                            <v-divider></v-divider>

                            <v-card-text>
                              <v-form v-on:submit.prevent="customerImport">

                                <v-col cols="12">
                                  <v-row wrap>

                                    <v-col cols="12" class="d-flex">
                                      <v-row wrap>
                                        <v-col cols="12" md="8" sm="4" lg="12">
                                          <v-file-input
                                              v-model="file"
                                              label="File"
                                              persistent-hint
                                              variant="outlined"
                                              accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                          ></v-file-input>
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
                                          @click="dialog = false"
                                      >
                                        Close
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
                </v-dialog>

              </v-card-text>

            </v-card>
          </v-col>
        </v-row>

      </v-col>
    </v-row>
  </div>
</template>

<style scoped>

</style>