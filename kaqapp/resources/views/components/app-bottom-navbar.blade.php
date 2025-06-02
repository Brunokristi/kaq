<nav class="navbar fixed-bottom navbar-light justify-content-end">
    <a href="{{ route('create') }}" class="navbar-link dark">
        <span class="navbar-label">Create</span>
    </a>
    <a href="{{ route('documentation') }}" class="navbar-link">
        <i class="bi bi-file-earmark-text mobile-icon"></i>
        <span class="navbar-label">Docs</span>
    </a>
    <a href="{{ route('contact') }}" class="navbar-link">
        <i class="bi bi-envelope mobile-icon"></i>
        <span class="navbar-label">Get in Touch</span>
    </a>
    <a href="{{ route('mission') }}" class="navbar-link">
        <i class="bi bi-info-circle mobile-icon"></i>
        <span class="navbar-label">Our Mission</span>
    </a>
</nav>


<style>
@import url('https://fonts.googleapis.com/css2?family=Krona+One&family=Inter:wght@400;700&display=swap');

.navbar {
    padding: 0.5rem 1rem;
    border-top: solid 1px #000;
    background-color: #fff;
    height: 46px;
}

.navbar-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
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

.mobile-icon {
    font-size: 1.1rem;
    margin-right: 0.5rem;
    display: none;
}

@media (max-width: 576px) {
    .navbar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
    }
    .navbar-label {
        display: none;
    }

    .navbar-link:first-of-type .navbar-label {
        display: inline-block;
    }


    .navbar-link {
        padding: 2px;
        width: 15%;
        height: 30px;
        border-radius: 20px;
        margin-left: 0.4rem;
    }

    .navbar-link:first-of-type {
        width: 30%;
    }

    .mobile-icon {
        margin-right: 0;
        font-size: 1.2rem;
        display: inline-block;
    }
}
</style>
