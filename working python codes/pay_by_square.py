import zlib
import lzma
import qrcode
from PIL import Image
import struct

# Prepare data
data = "\t".join([
    "",
    "1",
    "\t".join([
        "1",  # True
        "123.45",  # SUMA
        "EUR",  # JEDNOTKA
        "20170101",  # DATUM
        "123456789",  # VARIABILNY SYMBOL
        "0308",  # KONSTANTNY SYMBOL
        "1111",  # SPECIFICKY SYMBOL
        "",
        "poznamka",  # POZNAMKA
        "1",
        "SK8011000000001234567890",  # IBAN
        "TATRSKBX",  # SWIFT
        "0",
        "0"
    ])
])

# Add CRC32 checksum to the data
checksum = zlib.crc32(data.encode()).to_bytes(4, byteorder='big')
data = checksum[::-1] + data.encode()

# Compress data using LZMA
compressor = lzma.LZMACompressor(
    format=lzma.FORMAT_RAW,
    filters=[{"id": lzma.FILTER_LZMA1, "lc": 3, "lp": 0, "pb": 2, "dict_size": 128 * 1024}]
)
compressed_data = compressor.compress(data) + compressor.flush()

# Convert compressed data to binary
length_prefix = struct.pack(">H", len(data))
binary_data = b"\x00\x00" + length_prefix + compressed_data
hex_data = binary_data.hex()

# Convert hex to binary string
binary_string = "".join(f"{int(c, 16):04b}" for c in hex_data)

# Pad binary string to be divisible by 5
padding = (5 - len(binary_string) % 5) % 5
binary_string += "0" * padding

# Convert binary to Base32
base32_chars = "0123456789ABCDEFGHIJKLMNOPQRSTUV"
encoded_data = "".join(
    base32_chars[int(binary_string[i:i + 5], 2)]
    for i in range(0, len(binary_string), 5)
)

# Generate the QR code URL
if encoded_data:
    qr = qrcode.QRCode(
    version=1,  # Controls the size of the QR code
    error_correction=qrcode.constants.ERROR_CORRECT_L,
    box_size=10,
    border=4,
)
qr.add_data(encoded_data)
qr.make(fit=True)

# Create and save the QR code image
img = qr.make_image(fill_color="black", back_color="white")
img.save("pay_by_square_qrcode.png")
print("QR code saved as 'pay_by_square_qrcode.png'.")