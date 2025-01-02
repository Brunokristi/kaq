<template>
  <nav class="navbar fixed-bottom navbar-light justify-content-end">
    <button>docs</button>
    <router-link to="/contact" class="navbar-link">get in touch</router-link>
    <button>our mission</button>
  </nav>
</template>

<script>
export default {
  name: "AppBottomNavbar",
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Krona+One&family=Inter:wght@400;700&display=swap');

/* Navbar Styles */
.navbar {
  padding: 0.5rem 1rem;
  border-top: solid 1px #000;
  background-color: #fff;
}

/* Button Styles */
.navbar button {
  cursor: pointer;
  background-color: transparent;
  margin-left: 1rem;
  padding: 0.3rem 1rem;
  border: solid 1px #47663B;
  border-radius: 50px;
  color: #47663B;
  font-family: 'Krona One', sans-serif;
  font-size: 0.7rem;
}

.navbar button:hover {
  background-color: #47663B;
  color: #fff;
}

/* Router Link Styles */
.navbar-link {
  display: inline-block;
  cursor: pointer;
  margin-left: 1rem;
  padding: 0.3rem 1rem;
  border: solid 1px #47663B;
  border-radius: 50px;
  color: #47663B;
  font-family: 'Krona One', sans-serif;
  font-size: 0.7rem;
  text-decoration: none;
  text-align: center;
}

.navbar-link:hover {
  background-color: #47663B;
  color: #fff;
}
</style>
