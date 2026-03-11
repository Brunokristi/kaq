import '../css/dashboard.css';

document.addEventListener('DOMContentLoaded', () => {
    let qrCodeBaseUrl = '/qrcode';
    const qrApiBaseUrl = window.kaqDashboardConfig?.qrApiBaseUrl || '';

    const sidebarLinks = Array.from(document.querySelectorAll('#sidebar a[data-id]'));
    const mainContent = document.getElementById('main-content');

    if (!mainContent || !sidebarLinks.length) {
        return;
    }

    const isValidHex = (value) => /^#[0-9A-F]{6}$/.test(value);

    const showToast = (type, message, autoclose = 4000) => {
        if (window.kaqToast?.show) {
            window.kaqToast.show({ type, message, autoclose });
        }
    };

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

    const getMissingRequiredFields = () => {
        const missing = [];

        document.querySelectorAll('#dynamic-form [required]').forEach(field => {
            const value = (field.value || '').trim();
            if (value) {
                return;
            }

            const label = field.closest('.mb-4')?.querySelector('label')?.textContent?.trim() || field.name;
            missing.push(label);
        });

        return missing;
    };

    const updateQrCode = ({ notifyRequired = false } = {}) => {
        const activeLink = document.querySelector('#sidebar a[data-id].active');
        const typeId = activeLink ? activeLink.getAttribute('data-id') : null;
        if (!typeId) return false;

        const missingRequiredFields = getMissingRequiredFields();
        if (missingRequiredFields.length) {
            if (notifyRequired) {
                showToast('error', `Please fill in required field: ${missingRequiredFields[0]}.`, 5000);
            }
            return false;
        }

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

        return true;
    };

    const getCurrentQrImage = () => document.getElementById('qr-image');

    const getCurrentFormat = () => document.querySelector('input[name="format"]:checked')?.value || 'png';

    const fetchQrBlob = async () => {
        const qrImage = getCurrentQrImage();
        const imageUrl = qrImage?.src;

        if (!imageUrl || imageUrl.startsWith('data:image/svg+xml')) {
            return null;
        }

        const response = await fetch(imageUrl);

        if (!response.ok) {
            throw new Error(`Unable to fetch QR image. HTTP ${response.status}`);
        }

        return response.blob();
    };

    const downloadQrCode = async () => {
        const didGenerate = updateQrCode({ notifyRequired: true });
        if (!didGenerate) {
            return;
        }

        const qrImage = getCurrentQrImage();
        const imageUrl = qrImage?.src;

        if (!imageUrl) {
            return;
        }

        const format = getCurrentFormat();
        let downloadUrl = imageUrl;

        try {
            const blob = await fetchQrBlob();

            if (blob) {
                downloadUrl = URL.createObjectURL(blob);
            }
        } catch (error) {
            console.error(error);
            showToast('error', 'Could not generate QR code for download.', 5000);
        }

        const link = document.createElement('a');
        link.href = downloadUrl;
        link.download = `kaq-qr.${format}`;
        document.body.appendChild(link);
        link.click();
        link.remove();

        if (downloadUrl !== imageUrl) {
            URL.revokeObjectURL(downloadUrl);
        }
    };

    const copyQrCode = async () => {
        const didGenerate = updateQrCode({ notifyRequired: true });
        if (!didGenerate) {
            return;
        }

        const qrImage = getCurrentQrImage();
        const imageUrl = qrImage?.src;

        if (!imageUrl || !navigator.clipboard) {
            showToast('error', 'Copy is not available in this browser.', 5000);
            return;
        }

        try {
            const blob = await fetchQrBlob();

            if (
                blob &&
                window.ClipboardItem &&
                navigator.clipboard.write
            ) {
                const mimeType = blob.type || (getCurrentFormat() === 'svg' ? 'image/svg+xml' : 'image/png');
                await navigator.clipboard.write([
                    new ClipboardItem({
                        [mimeType]: blob,
                    }),
                ]);
                showToast('success', 'QR code copied successfully.');
                return;
            }

            await navigator.clipboard.writeText(imageUrl);
            showToast('success', 'QR code link copied successfully.');
        } catch (error) {
            console.error(error);
            showToast('error', 'Could not copy QR code.', 5000);
        }
    };

    const attachActionListeners = () => {
        const downloadButton = document.querySelector('.download-button');
        const copyButton = document.querySelector('.copy-button');

        if (downloadButton) {
            downloadButton.addEventListener('click', () => {
                downloadQrCode();
            });
        }

        if (copyButton) {
            copyButton.addEventListener('click', () => {
                copyQrCode();
            });
        }
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

    syncColorInputs('pixelColor', 'pixelColorHex');
    syncColorInputs('backgroundColor', 'backgroundColorHex');
    initColorPalettes();
    attachActionListeners();

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
                                        ${field.help_text ? `<span class="text-brand text-[10px] leading-none cursor-pointer tooltip-trigger" data-tooltip="${field.help_text.replace(/"/g, '&quot;')}"><i class="bi bi-info-circle-fill"></i></span>` : ''}
                                    </div>
                                </div>

                                <div>
                                    ${field.type === 'textarea'
                            ? `<textarea
                                                class="w-full border border-black p-2 focus:outline-none resize-none"
                                                id="${(field.label ?? '').toLowerCase().replace(/\s+/g, '_')}"
                                                name="${(field.label ?? '').toLowerCase().replace(/\s+/g, '_')}"
                                                ${field.required ? 'required' : ''}
                                                rows="4"
                                            >${field.value || ''}</textarea>`
                            : `<input
                                                type="${field.type}"
                                                class="w-full border border-black p-2 focus:outline-none"
                                                id="${(field.label ?? '').toLowerCase().replace(/\s+/g, '_')}"
                                                name="${(field.label ?? '').toLowerCase().replace(/\s+/g, '_')}"
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
                    showToast('error', 'Could not load this QR type. Please try again.', 5000);
                });
        });
    });

    document.querySelectorAll(
        '#pixelSize, #borderSize, input[name="format"]'
    ).forEach(control => {
        control.addEventListener('input', updateQrCode);
        control.addEventListener('change', updateQrCode);
    });

    const requestedTypeId = new URLSearchParams(window.location.search).get('type');
    const initialLink = requestedTypeId
        ? sidebarLinks.find(link => link.getAttribute('data-id') === requestedTypeId)
        : null;

    (initialLink || sidebarLinks[0]).click();

    const qrCodeImage = getCurrentQrImage();
    qrCodeImage?.addEventListener('error', () => {
        showToast('error', 'Could not generate QR code. Check fields and try again.', 5000);
    });

    const resizeHandle = document.getElementById('resize-handle');
    const rightPanel = document.getElementById('right-panel');

    if (resizeHandle && rightPanel) {
        let startX;
        let startWidth;

        resizeHandle.addEventListener('mousedown', (event) => {
            startX = event.clientX;
            startWidth = rightPanel.offsetWidth;
            document.body.style.cursor = 'col-resize';
            document.body.style.userSelect = 'none';

            const onMouseMove = (moveEvent) => {
                const delta = startX - moveEvent.clientX;
                const newWidth = Math.min(600, Math.max(240, startWidth + delta));
                rightPanel.style.width = `${newWidth}px`;
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