@extends('layouts.app')

@section('title', 'KAQ Dashboard - Create QR Codes')

@section('content')
<div class="h-full min-h-0">

  {{-- Desktop layout (content + right panel) --}}
  <div class="flex h-full min-h-0">

    {{-- Main content --}}
    <div class="flex-1 min-w-0 p-4">
        <div id="main-content">
            {{-- dynamic content loads here --}}
        </div>
    </div>

    {{-- Right panel --}}
    <aside class="w-80 shrink-0 border-l border-black flex flex-col">
        
        {{-- QR preview --}}
        <div class="p-4 border-b border-black">
            <div class="flex items-center justify-center h-60">
                <img id="qr-image"
                     src="https://via.placeholder.com/150"
                     alt="QR Code"
                     class="max-h-full">
            </div>
        </div>

        {{-- Style section --}}
        <div class="flex-1 p-4 overflow-y-auto border-b border-black">
            <h3 class="mb-4">STYLE</h3>

            <form class="space-y-5">
                <div class="flex flex-col gap-2">
                    <label for="pixelColor" class="text-xs uppercase tracking-wide">Pixel color</label>
                    <input type="color" id="pixelColor" value="#000000" class="h-10 w-full border border-black">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="backgroundColor" class="text-xs uppercase tracking-wide">Background color</label>
                    <input type="color" id="backgroundColor" value="#ffffff" class="h-10 w-full border border-black">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="pixelSize" class="text-xs uppercase tracking-wide">Pixel size</label>
                    <input type="range" id="pixelSize" min="1" max="10" class="w-full">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="borderSize" class="text-xs uppercase tracking-wide">Border size</label>
                    <input type="range" id="borderSize" min="1" max="10" class="w-full">
                </div>
            </form>
        </div>

        <div>
            <div class="p-4 flex items-end justify-between">
                <div class="inline-flex rounded-md border border-black overflow-hidden">
                    <label class="px-3 py-2 text-xs cursor-pointer">
                        <input type="radio" name="btnradio" id="btnradio1" value="png" class="sr-only peer" checked>
                        <span class="peer-checked:underline">PNG</span>
                    </label>

                    <label class="px-3 py-2 text-xs cursor-pointer border-l border-black">
                        <input type="radio" name="btnradio" id="btnradio2" value="svg" class="sr-only peer">
                        <span class="peer-checked:underline">SVG</span>
                    </label>
                </div>

                <button class="download-button border border-black px-3 py-2 text-xs hover:bg-black hover:text-white">
                    Download
                </button>

                <button class="copy-button border border-black px-3 py-2 text-xs hover:bg-black hover:text-white">
                    Copy
                </button>
            </div>
        </div>

    </aside>

</div>

  {{-- Mobile warning --}}
  <div class="md:hidden text-center p-6 border border-black">
    <h5 class="text-red-600">Please use a desktop device to generate QR codes.</h5>
    <p class="mt-2">QR code customization and downloads are available only on larger screens for the best experience.</p>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  let qrCodeBaseUrl = '/qrcode';

  // Sidebar links come from <x-sidebar />
  const sidebarLinks = Array.from(document.querySelectorAll('#sidebar a[data-id]'));
  const mainContent = document.getElementById('main-content');

  const setActive = (clicked) => {
    sidebarLinks.forEach(l => l.classList.remove('active'));
    clicked.classList.add('active');
  };

  sidebarLinks.forEach(link => {
    link.addEventListener('click', event => {
      event.preventDefault();

      setActive(link);

      const typeId = link.getAttribute('data-id');

      fetch(`/api/types/${typeId}`)
        .then(r => r.json())
        .then(data => {
          if (!mainContent) return;

          mainContent.innerHTML = `
            <h2>${data.name}</h2>
            <div class="trim" id="text">${data.description ?? ''}</div>
            <button id="toggle-button" class="underline text-sm mt-2">more</button>
            <h3 style="margin-bottom: 30px; margin-top: 20px;">DATA</h3>
            <form id="dynamic-form">
              ${(data.form_fields ?? []).map(field => `
                <div class="mb-4">
                  ${
                    field.type === 'textarea'
                      ? `<textarea
                          class="w-full border border-black p-2"
                          id="${(field.label ?? '').toLowerCase().replace(/\\s+/g, '_')}"
                          name="${(field.label ?? '').toLowerCase().replace(/\\s+/g, '_')}"
                          ${field.required ? 'required' : ''}
                          rows="4"
                        >${field.value || ''}</textarea>`
                      : `<input
                          type="${field.type}"
                          class="w-full border border-black p-2"
                          id="${(field.label ?? '').toLowerCase().replace(/\\s+/g, '_')}"
                          name="${(field.label ?? '').toLowerCase().replace(/\\s+/g, '_')}"
                          ${field.required ? 'required' : ''}
                          value="${field.value || ''}"
                        >`
                  }
                  <label class="block text-xs uppercase tracking-wide mt-2">
                    ${field.label ?? ''}
                  </label>
                </div>
              `).join('')}
            </form>
          `;

          qrCodeBaseUrl = data.url || '/qrcode';

          const text = document.getElementById("text");
          const toggleButton = document.getElementById("toggle-button");
          if (toggleButton && text) {
            toggleButton.addEventListener("click", () => {
              const isTrimmed = text.classList.contains("trim");
              text.classList.toggle("trim", !isTrimmed);
              toggleButton.textContent = isTrimmed ? "less" : "more";
            });
          }

          attachFormListeners();
          updateQrCode();
        })
        .catch(err => console.error(err));
    });
  });

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

    const qrCodeImage = document.getElementById('qr-image');
    if (qrCodeImage) qrCodeImage.src = qrCodeUrl;
  };

  document.querySelectorAll('#pixelColor, #backgroundColor, #pixelSize, #borderSize, #btnradio1, #btnradio2')
    .forEach(control => control.addEventListener('input', updateQrCode));

  // Auto-select first type
  if (sidebarLinks.length) sidebarLinks[0].click();
});
</script>
@endsection