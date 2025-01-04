<nav class="navbar fixed-bottom navbar-light justify-content-end">
    <a href="{{ route('create') }}" class="navbar-link dark">Create</a>
    <a href="#" class="navbar-link">Docs</a>
    <a href="{{ route('contact') }}" class="navbar-link">Get in Touch</a>
    <a href="{{ route('mission') }}" class="navbar-link">Our Mission</a>

</nav>

<style>
@import url('https://fonts.googleapis.com/css2?family=Krona+One&family=Inter:wght@400;700&display=swap');

/* Navbar Styles */
.navbar {
    padding: 0.5rem 1rem;
    border-top: solid 1px #000;
    background-color: #fff;
    height: 46px;
}

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

.navbar-link.dark {
    color: #fff;
    background-color: #47663B;
}

.navbar-link:hover {
    background-color: #47663B;
    color: #fff;
}
</style>
