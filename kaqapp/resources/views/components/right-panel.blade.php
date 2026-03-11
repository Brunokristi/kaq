<aside id="right-panel" class="w-full lg:w-[320px] border-t lg:border-t-0 lg:border-l border-black flex flex-col min-h-0 flex-shrink-0 relative">
    <div id="resize-handle" class="hidden lg:block absolute left-0 top-0 h-full w-1 cursor-col-resize hover:bg-black transition-colors z-50"></div>

    <div class="p-4 border-b border-black bg-white">
        <div class="flex items-center justify-center h-60">
            <img
                id="qr-image"
                src="{{ asset('assets/placeholder.svg') }}"
                alt="QR Code"
                class="max-h-full"
            >
        </div>
    </div>

    <div class="flex-1 min-h-0 overflow-y-auto border-b border-black">
        <div class="p-4">
            <form class="space-y-5" id="style-form">
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
                            class="h-8 flex-1 border border-black px-2 text-sm uppercase outline-none"
                        >

                        <input
                            type="color"
                            id="pixelColor"
                            value="#47663B"
                            class="h-8 w-12 bg-white"
                        >
                    </div>
                </div>

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
                            class="h-8 flex-1 border border-black px-2 text-sm uppercase outline-none"
                        >

                        <input
                            type="color"
                            id="backgroundColor"
                            value="#ffffff"
                            class="h-8 w-12 bg-white"
                        >
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="pixelSize" class="text-xs uppercase tracking-wide">Pixel size</label>
                    <input type="range" id="pixelSize" min="1" max="10" value="10" class="slider w-full">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="borderSize" class="text-xs uppercase tracking-wide">Border size</label>
                    <input type="range" id="borderSize" min="1" max="10" value="4" class="slider w-full">
                </div>

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