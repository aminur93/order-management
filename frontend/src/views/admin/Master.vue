<script>
import Layouts from "@/components/admin/Layouts.vue";
export default {
  name: "AdminMaster",
  components: {Layouts}
}
</script>

<template>
  <v-app>

    <Layouts />

    <v-main>
      <router-view></router-view>
    </v-main>

  </v-app>
</template>

<style scoped>

</style>