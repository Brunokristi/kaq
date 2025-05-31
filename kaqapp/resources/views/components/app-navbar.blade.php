<nav class="navbar fixed-top navbar-light">
    <a href="/"><img src="{{ asset('assets/logo_green-white.svg') }}" class="logo" height="30" alt="Logo"></a>
    <img src="{{ asset('assets/donate_button.svg') }}" height="30" alt="Support Us">
</nav>

<div id="donate-popup" class="donate-modal">
    <div class="donate-content">
        <h3>Fuel the Mission</h3>
        <p>You like what we do? Throw some love our way</p>
        <img src="{{ asset('assets/qrcode.png') }}" alt="Donate QR Code" class="qr-img">
        <h3>THX <3</h3>
    </div>
</div>
<style>
.navbar {
    padding: 0.5rem 1rem;
    border-bottom: solid 1px #000;
    background-color: #fff;
}

.navbar img {
    cursor: pointer;
}

#donate-popup {
    display: none;
}

.donate-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center;
    align-items: center;
}

.donate-content {
    background-color: #fff;
    padding: 2rem;
    text-align: center;
    max-width: 400px;
    position: relative;
    border: 1px solid #000;
}

.qr-img {
    width: 200px;
    height: auto;
    margin: 1rem 0;
}

.close-btn {
    position: absolute;
    top: 0.5rem;
    right: 1rem;
    font-size: 1.5rem;
    cursor: pointer;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const donateBtn = document.querySelector('img[alt="Support Us"]');
        const modal = document.getElementById('donate-popup');

        donateBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>

