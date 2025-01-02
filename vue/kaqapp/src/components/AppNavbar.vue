<template>
  <nav class="navbar fixed-top navbar-light">
    <img src="@/assets/logo_green-white.svg" class="logo" height=30px alt="Logo"/>
    <img src="@/assets/donate_button.svg" height=30px alt="Support Us"/>
  </nav>
</template>

<script>
export default {
  name: "AppNavbar",
};
</script>


<style scoped>
.navbar {
  padding: 0.5rem 1rem;
  border-bottom: solid 1px #000;
  background-color: #fff;
}

.navbar img {
  cursor: pointer;
}
</style>