@extends('layouts.app')

@section('title', 'KAQ Dashboard - Create QR Codes')

@section('content')
<div class="create">
    <div class="container-fluid d-flex flex-column overflow-none">
        <div class="row flex-grow-1">

            <div class="col-3 p-4 overflow-scroll full-height pt-3">
                 @foreach($categories as $category)
                    <h5>{{ $category->name }}</h5>
                    <nav class="nav flex-column mb-4">
                        @foreach($category->qrCodeTypes as $type)
                            <a class="nav-link" href="#" data-id="{{ $type->id }}">{{ $type->name }}</a>
                        @endforeach
                    </nav>
                @endforeach
            </div>

            <!-- Main Content -->
            <div class="col-6 p-4 overflow-auto full-height bordered">
                <div id="main-content">
                    <h2>Select a type to view its details</h2>
                    <p>Click on a type from the sidebar to load content here.</p>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="col-3 text-center p-0">
                <div class="p-4 half-height d-flex flex-column overflow-none">
                    <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                        <img src="https://via.placeholder.com/150" alt="QR Code" class="img-fluid">
                    </div>

                    <div class="d-flex align-items-end justify-content-between my-3" style="gap: 1rem;">
                        <!-- Radio Toggle Buttons -->
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio1">PNG</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">SVG</label>
                        </div>

                        <!-- Standard Buttons -->
                        <button class="btn btn-dark mb-0">Download</button>
                        <button class="btn btn-dark mb-0">Copy</button>
                    </div>
                </div>

                <div class="d-flex flex-column p-4 rest overflow-auto bordered-top align-items-start">
                    <h3 class="mb-4">STYLE</h3>
                    <form class="w-100">
                        <div class="mb-3 d-flex flex-column">
                            <label for="pixelColor" class="style-label">Pixel color</label>
                            <input type="color" class="color-input w-100" id="pixelColor" value="#000000">
                        </div>
                        <div class="mb-4 d-flex flex-column">
                            <label for="backgroundColor" class="style-label">Background color</label>
                            <input type="color" class="color-input w-100" id="backgroundColor" value="#ffffff">
                        </div>
                        <div class="mb-5 d-flex flex-column">
                            <label for="pixelSize" class="style-label">Pixel size</label>
                            <input type="range" class="slider" id="pixelSize" min="1" max="10">
                        </div>
                        <div class="mb-5 d-flex flex-column">
                            <label for="borderSize" class="style-label">Border size</label>
                            <input type="range" class="slider" id="borderSize" min="1" max="10">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    // Attach click event to sidebar links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault(); // Prevent default link behavior

            const typeId = link.getAttribute('data-id'); // Get type ID

            // Fetch content from API
            fetch(`/api/types/${typeId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate main content
                    const mainContent = document.getElementById('main-content');
                    mainContent.innerHTML = `
                        <h2>${data.name}</h2>
                        <div class="trim" id="text">
                            ${data.description}
                        </div>
                        <button id="toggle-button" class="btn btn-link p-0">more</button> 
                        <h3 style= "margin-bottom: 30px">DATA</h3>
                        <form>
                            ${data.form_fields.map(field => `
                                <div class="field-holder">
                                    <input 
                                        type="${field.type}" 
                                        class="form-control" 
                                        id="${field.label.toLowerCase().replace(/\s+/g, '_')}" 
                                        name="${field.label.toLowerCase().replace(/\s+/g, '_')}" 
                                        ${field.required ? 'required' : ''}
                                    >
                                    <label for="${field.label.toLowerCase().replace(/\s+/g, '_')}" class="form-label">
                                        ${field.label}
                                    </label>
                                </div>
                            `).join('')}
                        </form>
                    `;

                    // Attach the toggle button listener after content is updated
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
                })
                .catch(error => {
                    console.error('Error fetching content:', error);
                });
        });
    });    
});


</script>
@endsection
