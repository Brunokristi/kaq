@extends('layouts.app')

@section('title', 'KAQ Dashboard - Create QR Codes')

@section('content')
<div class="create">
    <div class="container-fluid d-flex flex-column overflow-none">
        <div class="row flex-grow-1">

            <div class="col-3 p-4 overflow-scroll full-height pt-3">
                <h5>Contacts</h5>
                <nav class="nav flex-column mb-4">
                    <a class="nav-link" href="#">Vcard - digital business card</a>
                    <a class="nav-link" href="#">Email</a>
                    <a class="nav-link" href="#">Phone</a>
                    <a class="nav-link" href="#">WhatsApp</a>
                    <a class="nav-link" href="#">Discord</a>
                    <a class="nav-link" href="#">Messenger</a>
                    <a class="nav-link border" href="#">Complete Solution</a>
                </nav>
                <h5>Finances</h5>
                <nav class="nav flex-column mb-4">
                    <a class="nav-link" href="#">Vcard - online business card</a>
                    <a class="nav-link" href="#">Email</a>
                    <a class="nav-link" href="#">Phone</a>
                    <a class="nav-link" href="#">WhatsApp</a>
                    <a class="nav-link" href="#">Discord</a>
                    <a class="nav-link" href="#">Messenger</a>
                    <a class="nav-link border" href="#">Complete Solution</a>
                </nav>
                <h5>Finances</h5>
                <nav class="nav flex-column mb-4">
                    <a class="nav-link" href="#">Vcard - online business card</a>
                    <a class="nav-link" href="#">Email</a>
                    <a class="nav-link" href="#">Phone</a>
                    <a class="nav-link" href="#">WhatsApp</a>
                    <a class="nav-link" href="#">Discord</a>
                    <a class="nav-link" href="#">Messenger</a>
                    <a class="nav-link border" href="#">Complete Solution</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-6 p-4 overflow-auto full-height bordered">
                <h2>VCARD</h2>
                <p class="trim" id="text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in aliquet orci. Sed consequat accumsan velit, et feugiat quam pretium vitae. Morbi vitae sapien turpis. Vestibulum a ligula est. Suspendisse pharetra mattis leo eu aliquet. Curabitur laoreet lorem leo, a elementum quam accumsan non. In at auctor ante, ut elementum leo. Nulla eu lobortis quam. Donec dapibus, felis malesuada suscipit vulputate, risus velit eleifend elit, sit amet porta massa felis et erat. Nam lobortis ultrices justo, in maximus enim feugiat ac. Donec nisi lacus, mollis vitae augue rhoncus, suscipit ullamcorper erat. Fusce quis dictum mi. Vivamus laoreet sapien ut euismod aliquam.
                </p>
                <button id="toggle-button" class="btn btn-link p-0">more</button>                
                <h3 style="margin-bottom: 2rem;">DATA</h3>
                <form>
                    <div class="field-holder">
                        <input type="text" class="form-control" id="name">
                        <label for="name" class="form-label">Name</label>
                    </div>
                    <div class="field-holder">
                        <input type="text" class="form-control" id="surname">
                        <label for="surname" class="form-label">Surname</label>
                    </div>
                    <div class="field-holder">
                        <input type="text" class="form-control" id="number">
                        <label for="number" class="form-label">Number</label>
                    </div>
                </form>
            </div>

            <!-- QR Code Section -->
            <div class="col-3 text-center p-0">
                <div class="p-4 half-height overflow-auto">
                    <img src="https://via.placeholder.com/150" alt="QR Code" class="img-fluid">
                    <div class="d-flex align-items-center justify-content-between my-3">
                        <!-- Radio Toggle Buttons -->
                        <div class="btn-group me-2" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio1">PNG</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">SVG</label>
                        </div>

                        <!-- Standard Buttons -->
                        <button class="btn btn-dark me-2">Download</button>
                        <button class="btn btn-dark">Copy</button>
                    </div>
                </div>

                <div class=" p-4 half-height overflow-auto bordered-top">
                    <h5>STYLE</h5>
                    <form>
                        <div class="mb-3 d-flex align-items-center overflow-auto hafl-height">
                            <label for="pixelColor" class="form-label me-2">Pixel color</label>
                            <input type="color" class="color-input" id="pixelColor">
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <label for="backgroundColor" class="form-label me-2">Background color</label>
                            <input type="color" class="color-input" id="backgroundColor">
                        </div>
                        <div class="mb-3">
                            <label for="pixelSize" class="form-label">Pixel size</label>
                            <input type="range" class="slider" id="pixelSize" min="1" max="10">
                        </div>
                        <div class="mb-3">
                            <label for="borderSize" class="form-label">Border size</label>
                            <input type="range" class="slider" id="borderSize" min="1" max="10">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const text = document.getElementById("text");
        const toggleButton = document.getElementById("toggle-button");

        toggleButton.addEventListener("click", () => {
            if (text.classList.contains("trim")) {
                text.classList.remove("trim");
                toggleButton.textContent = "less";
            } else {
                text.classList.add("trim");
                toggleButton.textContent = "more";
            }
        });
    });

    document.querySelectorAll('.field-holder input, .field-holder textarea').forEach(field => {
        field.addEventListener('input', () => {
            if (field.value.trim() !== "") {
                field.classList.add('has-value');
            } else {
                field.classList.remove('has-value');
            }
        });

        // Initialize class on page load for prefilled values
        if (field.value.trim() !== "") {
            field.classList.add('has-value');
        }
    });
</script>
@endsection
