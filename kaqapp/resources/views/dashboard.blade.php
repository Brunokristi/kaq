@extends('layouts.app')

@section('title', 'KAQ Dashboard - Create QR Codes')

@section('content')
<div class="h-full min-h-0 flex">
      <div class="min-w-0 overflow-y-auto p-4">
          <div id="main-content" class="break-words">
              {{-- dynamic content loads here --}}
          </div>
      </div>

      <aside id="right-panel" class="border-l border-black flex flex-col min-h-0 flex-shrink-0 relative" style="width: 320px;">
        <div id="resize-handle" class="absolute left-0 top-0 h-full w-1 cursor-col-resize hover:bg-black transition-colors z-50"></div>
        {{-- QR preview --}}
        <div class="p-4 border-b border-black bg-white">
            <div class="flex items-center justify-center h-60">
                <img
                    id="qr-image"
                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Crect width='200' height='200' fill='white'/%3E%3Crect x='20' y='20' width='160' height='160' fill='none' stroke='black' stroke-width='4'/%3E%3C/svg%3E"
                    alt="QR Code"
                    class="max-h-full"
                >
            </div>
        </div>

        {{-- Style section --}}
        <div class="flex-1 min-h-0 overflow-y-auto border-b border-black">
            <div class="p-4">
            <form class="space-y-5" id="style-form">

                {{-- Pixel color --}}
                <div class="flex flex-col gap-2">
                    <label for="pixelColorHex" class="text-xs uppercase tracking-wide">
                        Pixel color
                    </label>

                    <div class="flex gap-2">
                        <input
                            type="text"
                            id="pixelColorHex"
                            value="#47663B"
                            maxlength="7"
                            pattern="^#[0-9A-Fa-f]{6}$"
                            class="h-8 flex-1 border border-black px-2 font-mono text-sm uppercase outline-none"
                        >

                        <input
                            type="color"
                            id="pixelColor"
                            value="#47663B"
                            class="h-8 w-12 border border-black bg-white"
                        >
                    </div>
                </div>

                {{-- Background color --}}
                <div class="flex flex-col gap-2">
                    <label for="backgroundColorHex" class="text-xs uppercase tracking-wide">
                        Background color
                    </label>

                    <div class="flex gap-2">
                        <input
                            type="text"
                            id="backgroundColorHex"
                            value="#FFFFFF"
                            maxlength="7"
                            pattern="^#[0-9A-Fa-f]{6}$"
                            class="h-8 flex-1 border border-black px-2 font-mono text-sm uppercase outline-none"
                        >

                        <input
                            type="color"
                            id="backgroundColor"
                            value="#ffffff"
                            class="h-8 w-12 border border-black bg-white"
                        >
                    </div>
                </div>

                {{-- Pixel size --}}
                <div class="flex flex-col gap-2">
                    <label for="pixelSize" class="text-xs uppercase tracking-wide">Pixel size</label>
                    <input type="range" id="pixelSize" min="1" max="10" value="10" class="slider w-full">
                </div>

                {{-- Border size --}}
                <div class="flex flex-col gap-2">
                    <label for="borderSize" class="text-xs uppercase tracking-wide">Border size</label>
                    <input type="range" id="borderSize" min="1" max="10" value="4" class="slider w-full">
                </div>

                {{-- Format --}}
                <div class="flex flex-col gap-2">
                  <span class="text-xs uppercase tracking-wide">Format</span>

                  <label class="flex items-center gap-2 text-xs cursor-pointer">
                      <input
                          type="radio"
                          name="format"
                          value="png"
                          class="h-4 w-4 accent-black"
                          checked
                      >
                      <span>PNG</span>
                  </label>

                  <label class="flex items-center gap-2 text-xs cursor-pointer">
                      <input
                          type="radio"
                          name="format"
                          value="svg"
                          class="h-4 w-4 accent-black"
                      >
                      <span>SVG</span>
                  </label>
                </div>
            </form>
            </div>
        </div>

        {{-- Bottom actions --}}
        <div>
            <div class="p-4 flex items-end justify-end gap-2">

                <button type="button" class="download-button border border-black px-3 py-2 text-xs hover:bg-black hover:text-white uppercase w-full">
                    Download
                </button>

                <button type="button" class="copy-button border border-black bg-black text-white px-3 py-2 text-xs hover:bg-white hover:text-black uppercase w-full">
                    Copy
                </button>
            </div>
        </div>

      </aside>
    
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let qrCodeBaseUrl = '/qrcode';
    const qrApiBaseUrl = @json(config('services.qr_api.base_url'));

    const sidebarLinks = Array.from(document.querySelectorAll('#sidebar a[data-id]'));
    const mainContent = document.getElementById('main-content');

    const isValidHex = (value) => /^#[0-9A-F]{6}$/.test(value);

    const normalizeHex = (value) => {
        let hex = (value || '').trim().toUpperCase();

        if (!hex) return '';
        if (!hex.startsWith('#')) hex = '#' + hex;

        return hex;
    };

    const updateSwatchSelection = (hexInputId, value) => {
        const hex = normalizeHex(value);

        document.querySelectorAll(`[data-target="${hexInputId}"] .color-swatch`).forEach(button => {
            const isActive = button.dataset.color.toUpperCase() === hex;
            button.classList.toggle('ring-2', isActive);
            button.classList.toggle('ring-black', isActive);
            button.classList.toggle('ring-offset-2', isActive);
        });
    };

    const setColorValue = (hexInputId, colorPickerId, value, triggerUpdate = true) => {
        const hexInput = document.getElementById(hexInputId);
        const colorPicker = document.getElementById(colorPickerId);

        if (!hexInput) return;

        const hex = normalizeHex(value);
        hexInput.value = hex;

        if (isValidHex(hex)) {
            if (colorPicker) {
                colorPicker.value = hex.toLowerCase();
            }

            updateSwatchSelection(hexInputId, hex);

            if (triggerUpdate) {
                updateQrCode();
            }
        } else {
            updateSwatchSelection(hexInputId, '');
        }
    };

    const syncColorInputs = (colorPickerId, hexInputId) => {
        const colorPicker = document.getElementById(colorPickerId);
        const hexInput = document.getElementById(hexInputId);

        if (!colorPicker || !hexInput) return;

        colorPicker.addEventListener('input', () => {
            setColorValue(hexInputId, colorPickerId, colorPicker.value, true);
        });

        hexInput.addEventListener('input', () => {
            hexInput.value = normalizeHex(hexInput.value);

            if (isValidHex(hexInput.value)) {
                colorPicker.value = hexInput.value.toLowerCase();
                updateSwatchSelection(hexInputId, hexInput.value);
                updateQrCode();
            } else {
                updateSwatchSelection(hexInputId, '');
            }
        });

        hexInput.addEventListener('blur', () => {
            const normalized = normalizeHex(hexInput.value);

            if (isValidHex(normalized)) {
                setColorValue(hexInputId, colorPickerId, normalized, true);
            }
        });

        updateSwatchSelection(hexInputId, hexInput.value);
    };

    const initColorPalettes = () => {
        document.querySelectorAll('[data-target][data-picker]').forEach(palette => {
            const targetId = palette.dataset.target;
            const pickerId = palette.dataset.picker;

            palette.querySelectorAll('[data-color]').forEach(button => {
                button.addEventListener('click', () => {
                    const color = button.dataset.color;
                    setColorValue(targetId, pickerId, color, true);
                });
            });
        });
    };

    const setActive = (clicked) => {
        sidebarLinks.forEach(link => link.classList.remove('active'));
        clicked.classList.add('active');
    };

    const attachFormListeners = () => {
        const form = document.getElementById('dynamic-form');
        if (!form) return;
        form.addEventListener('input', updateQrCode);
    };

    const updateQrCode = () => {
        const activeLink = document.querySelector('#sidebar a[data-id].active');
        const typeId = activeLink ? activeLink.getAttribute('data-id') : null;
        if (!typeId) return;

        const formData = {};
        document.querySelectorAll('#dynamic-form input, #dynamic-form textarea').forEach(field => {
            formData[field.name] = field.value;
        });

        const fill = normalizeHex(document.getElementById('pixelColorHex')?.value || '#47663B');
        const background = normalizeHex(document.getElementById('backgroundColorHex')?.value || '#FFFFFF');

        const styleData = {
            format: document.querySelector('input[name="format"]:checked')?.value || 'png',
            fill: isValidHex(fill) ? fill : '#47663B',
            background: isValidHex(background) ? background : '#FFFFFF',
            box_size: document.getElementById('pixelSize')?.value || 10,
            border: document.getElementById('borderSize')?.value || 4,
        };

        const queryParams = new URLSearchParams({
            ...formData,
            ...styleData,
            typeId: typeId,
        }).toString();

        const qrCodeUrl = `${qrApiBaseUrl}${qrCodeBaseUrl}?${queryParams}`;

        const qrCodeImage = document.getElementById('qr-image');
        if (qrCodeImage) {
            qrCodeImage.src = qrCodeUrl;
        }
    };

    syncColorInputs('pixelColor', 'pixelColorHex');
    syncColorInputs('backgroundColor', 'backgroundColorHex');
    initColorPalettes();

    sidebarLinks.forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();

            setActive(link);

            const typeId = link.getAttribute('data-id');

            fetch(`/api/types/${typeId}`)
                .then(async response => {
                    if (!response.ok) {
                        const text = await response.text();
                        throw new Error(`Failed to load type ${typeId}. HTTP ${response.status}. ${text.slice(0, 200)}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!mainContent) return;

                    mainContent.innerHTML = `
                        <h2 class="uppercase mb-4">${data.name}</h2>
                        <div class="mb-4" id="text">${data.description ?? ''}</div>
                        
                        <form id="dynamic-form">
                            ${(data.form_fields ?? []).map(field => `
                            <div class="mb-4">
                                                                <div class="flex justify-between items-center gap-2 mb-2 min-w-0">
                                                                        <label class="block text-small uppercase min-w-0 break-words">
                                      ${field.label ?? ''}
                                    </label>

                                    <div class="flex gap-2 items-center">
                                        ${field.required ? `<span class="text-brand text-[10px] leading-none cursor-pointer tooltip-trigger" data-tooltip="This field is required"><i class="bi bi-asterisk"></i></span>` : ''}
                                        ${field.help_text ? `<span class="text-brand text-[10px] leading-none cursor-pointer tooltip-trigger" data-tooltip="${field.help_text.replace(/"/g, '&quot;')}"><i class="bi bi-info-circle"></i></span>` : ''}
                                    </div>
                                </div>
                                    
                                <div>
                                    ${
                                        field.type === 'textarea'
                                            ? `<textarea
                                                class="w-full border border-black p-2 focus:outline-none  resize-none"
                                                id="${(field.label ?? '').toLowerCase().replace(/\s+/g, '_')}"
                                                name="${(field.label ?? '').toLowerCase().replace(/\s+/g, '_')}"
                                                placeholder="${field.placeholder || ''}"
                                                ${field.required ? 'required' : ''}
                                                rows="4"
                                            >${field.value || ''}</textarea>`
                                            : `<input
                                                type="${field.type}"
                                                class="w-full border border-black p-2 focus:outline-none"
                                                id="${(field.label ?? '').toLowerCase().replace(/\s+/g, '_')}"
                                                name="${(field.label ?? '').toLowerCase().replace(/\s+/g, '_')}"
                                                placeholder="${field.placeholder || ''}"
                                                ${field.required ? 'required' : ''}
                                                value="${field.value || ''}"
                                            >`
                                    }
                                </div>
                            </div>
                            `).join('')}
                        </form>
                    `;

                    qrCodeBaseUrl = data.url || '/qrcode';

                    const text = document.getElementById('text');
                    const toggleButton = document.getElementById('toggle-button');

                    if (toggleButton && text) {
                        toggleButton.addEventListener('click', () => {
                            const isTrimmed = text.classList.contains('trim');
                            text.classList.toggle('trim', !isTrimmed);
                            toggleButton.textContent = isTrimmed ? 'less' : 'more';
                        });
                    }

                    attachFormListeners();
                    updateQrCode();
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });

    document.querySelectorAll(
        '#pixelSize, #borderSize, input[name="format"]'
    ).forEach(control => {
        control.addEventListener('input', updateQrCode);
        control.addEventListener('change', updateQrCode);
    });

    if (sidebarLinks.length) {
        sidebarLinks[0].click();
    }

    // Resizable aside
    const resizeHandle = document.getElementById('resize-handle');
    const rightPanel = document.getElementById('right-panel');

    if (resizeHandle && rightPanel) {
        let startX, startWidth;

        resizeHandle.addEventListener('mousedown', (e) => {
            startX = e.clientX;
            startWidth = rightPanel.offsetWidth;
            document.body.style.cursor = 'col-resize';
            document.body.style.userSelect = 'none';

            const onMouseMove = (e) => {
                const delta = startX - e.clientX;
                const newWidth = Math.min(600, Math.max(240, startWidth + delta));
                rightPanel.style.width = newWidth + 'px';
            };

            const onMouseUp = () => {
                document.body.style.cursor = '';
                document.body.style.userSelect = '';
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            };

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
    }
});
</script>

<style>
    .tooltip-trigger {
        position: relative;
    }

    .tooltip-trigger::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 125%;
        right: 0;
        transform: none;
        background-color: black;
        color: white;
        padding: 6px 10px;
        font-size: 12px;
        white-space: normal;
        width: max-content;
        max-width: 200px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
        z-index: 1000;
        font-style: normal;
    }

    .tooltip-trigger::before {
        content: '';
        position: absolute;
        bottom: 120%;
        right: 6px;
        left: auto;
        transform: none;
        border: 5px solid transparent;
        border-top-color: black;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
        z-index: 1000;
    }

    .tooltip-trigger:hover::after,
    .tooltip-trigger:hover::before {
        opacity: 1;
    }
</style>
@endsection