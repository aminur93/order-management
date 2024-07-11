<template>
  <v-app>
    <router-view></router-view>
  </v-app>
</template>

<script>
export default {
  name: 'App',

  mounted: function () {
    let elHtml = document.getElementsByTagName("html")[0];
    elHtml.style.overflowY = "auto";
  },

  unmounted: function () {
    let elHtml = document.getElementsByTagName("html")[0];
    elHtml.style.overflowY = null;
  },
}
</script>

<style>
#app {
  background: #f5f5f5;
}

/* ===== Scrollbar CSS ===== */

*::-webkit-scrollbar-track
{
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  border-radius: 10px;
  background-color: #F5F5F5;
}

*::-webkit-scrollbar
{
  width: 12px;
  background-color: #F5F5F5;
}

*::-webkit-scrollbar-thumb
{
  border-radius: 10px;
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
  background-color: #D62929;
}
</style>

