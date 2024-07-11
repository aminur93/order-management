<script>
export default {
  name: "AdminDashboard"
}
</script>

<template>
  <div id="dashboard">
    <v-container max-width="1080" fluid>
      <v-row class="mx-5">
        <v-col cols="12">

          <v-row wrap>
            <v-col cols="6">
              <h1 :class="['text-subtitle-1', 'text-grey']">Welcome Dashboard</h1>
            </v-col>
          </v-row>

          <v-row wrap>
            <v-col cols="12" sm="4" md="3">
              <v-card style="background-color: #D1EFF5;">
                <v-card-title>
                  <v-row :class="['justify-lg-space-between', 'mt-2', 'ml-2', 'mr-2']">
                    <h1 :class="['text-subtitle-1', 'text-black', 'font-weight-bold']">Total Pending</h1>
                    <v-icon large :class="['text-black']">mdi mdi-devices</v-icon>
                  </v-row>
                </v-card-title>
                <v-card-text>
                  <h1 :class="['text-black', 'mt-2', 'ml-2']">20</h1>

                  <v-divider></v-divider>

                  <v-row class="justify-center">
                    <v-btn small :class="['mt-5', 'mb-2', 'text-black']" style="background-color: #D1EFF5;"><v-icon> mdi-forwardburger</v-icon> G0</v-btn>
                  </v-row>

                </v-card-text>

              </v-card>
            </v-col>

            <v-col cols="12" sm="4" md="3">
              <v-card style="background-color: #F0F5D1;">
                <v-card-title>
                  <v-row :class="['justify-lg-space-between', 'mt-2', 'ml-2', 'mr-2']">
                    <h1 :class="['text-subtitle-1', 'text-black', 'font-weight-bold']">Total Rejected</h1>
                    <v-icon large :class="['text-black']">mdi mdi-devices</v-icon>
                  </v-row>
                </v-card-title>
                <v-card-text>
                  <h1 :class="['text-black', 'mt-2', 'ml-2']">20</h1>

                  <v-divider></v-divider>

                  <v-row class="justify-center">
                    <v-btn small :class="['mt-5', 'mb-2', 'text-black']" style="background-color: #F0F5D1;"><v-icon> mdi-forwardburger</v-icon> G0</v-btn>
                  </v-row>

                </v-card-text>

              </v-card>
            </v-col>

            <v-col cols="12" sm="4" md="3">
              <v-card style="background-color: #D1EEDB;">
                <v-card-title>
                  <v-row :class="['justify-lg-space-between', 'mt-2', 'ml-2', 'mr-2']">
                    <h1 :class="['text-subtitle-1', 'text-black', 'font-weight-bold']">Total Review</h1>
                    <v-icon large :class="['text-black']">mdi mdi-devices</v-icon>
                  </v-row>
                </v-card-title>
                <v-card-text>
                  <h1 :class="['text-black', 'mt-2', 'ml-2']">20</h1>

                  <v-divider></v-divider>

                  <v-row class="justify-center">
                    <v-btn small :class="['mt-5', 'mb-2', 'text-black']" style="background-color: #D1EEDB;"><v-icon> mdi-forwardburger</v-icon> G0</v-btn>
                  </v-row>

                </v-card-text>

              </v-card>
            </v-col>

            <v-col cols="12" sm="4" md="3">
              <v-card style="background-color: #f9df89;">
                <v-card-title>
                  <v-row :class="['justify-lg-space-between', 'mt-2', 'ml-2', 'mr-2']">
                    <h1 :class="['text-subtitle-1', 'text-black', 'font-weight-bold']">Total Approved</h1>
                    <v-icon large :class="['text-black']">mdi mdi-devices</v-icon>
                  </v-row>
                </v-card-title>
                <v-card-text>
                  <h1 :class="['text-black', 'mt-2', 'ml-2']">20</h1>

                  <v-divider></v-divider>

                  <v-row class="justify-center">
                    <v-btn small :class="['mt-5', 'mb-2', 'text-black']" style="background-color: #f9df89;"><v-icon> mdi-forwardburger</v-icon> G0</v-btn>
                  </v-row>

                </v-card-text>

              </v-card>
            </v-col>

          </v-row>

        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<style scoped>
.theme--light.v-data-table {
  background-color: #FFFFFF;
  color: #000000;
  border: 1px solid darkgray;
}
</style>