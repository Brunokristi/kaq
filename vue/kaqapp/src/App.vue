<template>
  <div id="app">
    <AppNavbar />
    <router-view />
    <AppBottomNavbar />
  </div>
</template>

<script>
import AppNavbar from './components/AppNavbar.vue';
import AppBottomNavbar from './components/AppBottomNavbar.vue';

export default {
  components: {
    AppNavbar,
    AppBottomNavbar,
    },
};
</script>

<style>
/* Import Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Krona+One&family=Inter:wght@400;700&display=swap');

body {
  padding: 46px 10rem;
  margin: 0;
  box-sizing: border-box;
  font-family: 'Inter', sans-serif;
}

h1, h2, h3 {
  text-transform: uppercase;
  color: #000;
}

h2 {
  font-size: 0.9rem !important;
  font-weight: 400 !important;
}

h1 {
  font-size: 1.3rem !important;
}

h3 {
  font-size: 1rem !important;
  text-transform: uppercase;
}

p {
  font-size: 0.9rem !important;
}

@media (max-width: 768px) {
  body {
    padding: 46px 1rem;
  }
}
</style>

