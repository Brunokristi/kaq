import qrcode

# Function to generate Pay by Square QR data string
def generate_pay_by_square_qr(iban, amount, currency="CZK", message="", variable_symbol=""):
    # Base Pay by Square (SPD) format
    qr_data = f"SPD*1.0*ACC:{iban.replace(' ', '')}*AM:{amount:.2f}*CC:{currency}"

    # Add message and variable symbol if provided
    if message:
        qr_data += f"*MSG:{message}"
    if variable_symbol:
        qr_data += f"*X-VS:{variable_symbol}"

    return qr_data

# Example usage to generate Pay by Square QR code
iban = "CZ9106000000000000000123"
amount = 450.00
currency = "EUR"
message = "PLATBA ZA ZBOZI"
variable_symbol = "1234567890"

# Generate the QR data string
qr_data = generate_pay_by_square_qr(
    iban=iban,
    amount=amount,
    currency=currency,
    message=message,
    variable_symbol=variable_symbol
)

# Generate and save the QR code as an image file
img = qrcode.make(qr_data)
img.save("pay_by_square_qr_cz.png")
img.show()
print(f"QR code data: {qr_data}")
print("QR code saved as 'pay_by_square_qr_cz.png'")
