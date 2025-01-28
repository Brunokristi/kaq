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
                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" value="png" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio1">PNG</label>

                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" value="svg" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">SVG</label>
                        </div>

                        <!-- Standard Buttons -->
                        <button class="btn btn-dark mb-0 download-button">Download</button>
                        <button class="btn btn-dark mb-0 copy-button">Copy</button>
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
        let qrCodeBaseUrl = '/qrcode';

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
                        if (!mainContent) {
                            console.error("Main content container not found.");
                            return;
                        }

                        mainContent.innerHTML = `
                            <h2>${data.name}</h2>
                            <div class="trim" id="text">
                                ${data.description}
                            </div>
                            <button id="toggle-button" class="btn btn-link p-0">more</button> 
                            <h3 style="margin-bottom: 30px">DATA</h3>
                            <form id="dynamic-form">
                                ${data.form_fields.map(field => `
                                    <div class="field-holder">
                                        <input 
                                            type="${field.type}" 
                                            class="form-control" 
                                            id="${field.label.toLowerCase().replace(/\s+/g, '_')}" 
                                            name="${field.label.toLowerCase().replace(/\s+/g, '_')}" 
                                            ${field.required ? 'required' : ''}
                                            value="${field.value || ''}"
                                        >
                                        <label for="${field.label.toLowerCase().replace(/\s+/g, '_')}" class="form-label">
                                            ${field.label}
                                        </label>
                                    </div>
                                `).join('')}
                            </form>
                        `;

                        qrCodeBaseUrl = data.url;

                        // Attach the toggle button listener after content is updated
                        const text = document.getElementById("text");
                        const toggleButton = document.getElementById("toggle-button");

                        if (toggleButton && text) {
                            toggleButton.addEventListener("click", () => {
                                if (text.classList.contains("trim")) {
                                    text.classList.remove("trim");
                                    toggleButton.textContent = "less";
                                } else {
                                    text.classList.add("trim");
                                    toggleButton.textContent = "more";
                                }
                            });
                        }

                        // Attach listeners to form fields for changes
                        attachFormListeners(typeId);
                    })
                    .catch(error => {
                        console.error('Error fetching content:', error);
                    });
            });
        });

        const attachFormListeners = () => {
            const form = document.getElementById('dynamic-form');
            if (!form) return;

            form.querySelectorAll('input, textarea').forEach(field => {
                // Apply 'has-value' class for prefilled inputs
                if (field.value.trim() !== "") {
                    field.classList.add('has-value');
                }

                // Add event listener to update class dynamically
                field.addEventListener('input', () => {
                    if (field.value.trim() !== "") {
                        field.classList.add('has-value');
                    } else {
                        field.classList.remove('has-value');
                    }
                });

                if (field.name === 'phone') {
                    field.addEventListener('input', () => {
                        field.value = field.value.replace(/\s+/g, ''); // Remove all whitespace
                    });
                }
            });

            // Attach event listener to form fields for dynamic QR code update
            form.addEventListener('input', updateQrCode);
        };


        // Update QR code dynamically
        const updateQrCode = () => {
            const formData = {};
            const typeId = document.querySelector('.nav-link.active')?.getAttribute('data-id') || null;

            // Collect form data
            document.querySelectorAll('#dynamic-form input').forEach(field => {
                formData[field.name] = field.value;
            });

            // Collect styling data
            const styleData = {
                format: document.querySelector('input[name="btnradio"]:checked')?.value || 'png',
                fill: document.getElementById('pixelColor')?.value || '#000000',
                background: document.getElementById('backgroundColor')?.value || '#ffffff',
                box_size: document.getElementById('pixelSize')?.value || 10,
                border: document.getElementById('borderSize')?.value || 4,
            };

            const queryParams = new URLSearchParams({
                ...formData,
                ...styleData,
                typeId: typeId,
            }).toString();

            const qrCodeUrl = `http://127.0.0.1:5001${qrCodeBaseUrl}?${queryParams}`;
            console.log(qrCodeUrl);
            const qrCodeImage = document.querySelector('.col-3 img');
            if (qrCodeImage) {
                qrCodeImage.src = qrCodeUrl;
            }
        };

        // Attach event listeners to static controls
        document.querySelectorAll('#pixelColor, #backgroundColor, #pixelSize, #borderSize, #btnradio1, #btnradio2').forEach(control => {
            control.addEventListener('input', updateQrCode);
        });

        // Initial QR code update
        updateQrCode();

        const downloadButton = document.querySelector('.download-button');
        const copyButton = document.querySelector('.copy-button');
        const qrCodeImage = document.querySelector('.col-3 img');

        downloadButton.addEventListener('click', () => {
            if (qrCodeImage && qrCodeImage.src) {
                fetch(qrCodeImage.src)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.blob();
                    })
                    .then(blob => {
                        const url = URL.createObjectURL(blob); // Create a temporary URL for the blob
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'qrcode.png'; // Set the default filename
                        document.body.appendChild(link); // Append link to the DOM
                        link.click(); // Trigger the download
                        link.remove(); // Clean up
                        URL.revokeObjectURL(url); // Revoke the object URL to free memory
                    })
                    .catch(error => {
                        console.error('Failed to download the image:', error);
                        alert('Failed to download the QR code image.');
                    });
            } else {
                alert('QR code not available.');
            }
        });

        // Copy Button Functionality
        copyButton.addEventListener('click', () => {
            if (qrCodeImage && qrCodeImage.src) {
                fetch(qrCodeImage.src)
                    .then(response => response.blob())
                    .then(blob => {
                        const item = new ClipboardItem({ 'image/png': blob });
                        navigator.clipboard.write([item])
                            .then(() => {
                                alert('QR code image copied to clipboard!');
                            })
                            .catch(err => {
                                console.error('Failed to copy image:', err);
                                alert('Failed to copy the QR code image.');
                            });
                    })
                    .catch(err => {
                        console.error('Failed to fetch image for copying:', err);
                        alert('Failed to fetch QR code image.');
                    });
            } else {
                alert('QR code not generated yet.');
            }
        });
    });
</script>

@endsection
