import qrcode
import qrcode.image.svg

# Data to encode in the QR code
data = "https://www.parkfive.sk"

# User-configurable QR code settings
version = 2  # Range: 1-40 (higher = more capacity, but bigger QR code)
error_correction = qrcode.constants.ERROR_CORRECT_H  # L, M, Q, H (H = highest correction)
box_size = 10  # Size of each box in pixels
border = 4  # Thickness of the border (minimum is 4)

# Styling options
fill_color = "blue"  # Foreground color of the QR code
back_color = "yellow"  # Background color of the QR code

# Output formats
png = True
svg = True
svg_method = "path"  # Choose from 'basic', 'fragment', or 'path'

# Create the QR code object
qr = qrcode.QRCode(
    version=version,
    error_correction=error_correction,
    box_size=box_size,
    border=border,
)

qr.add_data(data)
qr.make(fit=True)

# Generate PNG output
if png:
    print("Generating PNG QR code...")
    img = qr.make_image(fill_color=fill_color, back_color=back_color)
    img.save("my_qrcode.png")
    print("PNG saved as 'my_qrcode.png'.")

# Generate SVG output
if svg:
    print("Generating SVG QR code...")
    if svg_method == "basic":
        factory = qrcode.image.svg.SvgImage
    elif svg_method == "fragment":
        factory = qrcode.image.svg.SvgFragmentImage
    else:  # 'path'
        factory = qrcode.image.svg.SvgPathImage

    img_svg = qrcode.make(data, image_factory=factory)
    img_svg.save("my_qrcode.svg")
    print("SVG saved as 'my_qrcode.svg'.")
