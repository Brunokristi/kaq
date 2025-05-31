from flask import Flask, request, send_file, jsonify, Response
import qrcode
import qrcode.image.svg
import io
from xml.etree import ElementTree as ET
import zlib
import lzma
import struct
import requests
from flask_cors import CORS
from datetime import datetime, timezone 
import textwrap
from urllib.parse import unquote
import quopri
import io
import traceback
import xml.etree.ElementTree as ET
from urllib.parse import quote
import re





placeholder_photo_base64 = textwrap.dedent("""\
    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
""").replace("\n", "")




app = Flask(__name__)
CORS(app)
CLIENT_ID = "1025295778547-069622a895e1nd1srnknp1p8gv9h2c00.apps.googleusercontent.com"
CLIENT_SECRET = "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"
REDIRECT_URI = "https://kaqapp.com/oauth2callback"

def qp_utf8(value: str) -> str:
    return quopri.encodestring(value.encode('utf-8')).decode('utf-8')


def normalize_phone(phone: str) -> str:
    digits = re.sub(r'\D', '', phone)

    if digits.startswith('0'):
        return '421' + digits[1:]
    
    if digits.startswith('004'):
        return '4' + digits[5:]
    
    if digits.startswith('421'):
        return digits

    return digits



def generate_qr_with_params(data, format='png', fill_color='black', back_color='white', box_size=10, border=4, error_correction='H'):
    try:
        print("📦 Generating QR with dynamic version...")

        error_correction_map = {
            'L': qrcode.constants.ERROR_CORRECT_L,
            'M': qrcode.constants.ERROR_CORRECT_M,
            'Q': qrcode.constants.ERROR_CORRECT_Q,
            'H': qrcode.constants.ERROR_CORRECT_H,
        }
        error_correction_level = error_correction_map.get(error_correction, qrcode.constants.ERROR_CORRECT_H)

        if format == 'png':
            # použi bezpečný spôsob bez self.version
            qr = qrcode.QRCode(
                error_correction=error_correction_level,
                box_size=box_size,
                border=border,
            )
            qr.add_data(data.encode('utf-8'))
            qr.make(fit=True)  # bezpečné – QRCode práve bol vytvorený čisto
            img = qr.make_image(fill_color=fill_color, back_color=back_color)
            buf = io.BytesIO()
            img.save(buf, format="PNG")
            buf.seek(0)
            print("✅ Returning PNG QR")
            return send_file(buf, mimetype='image/png', as_attachment=False, download_name='qrcode.png')

        elif format == 'svg':
            # qrcode.make vytvorí všetko automaticky
            factory = qrcode.image.svg.SvgPathImage
            img_svg = qrcode.make(data.encode('utf-8'), image_factory=factory)
            buf = io.BytesIO()
            img_svg.save(buf)
            buf.seek(0)
            svg_data = buf.getvalue().decode('utf-8')

            # Upraviť farby
            root = ET.fromstring(svg_data)
            for path in root.findall('.//{http://www.w3.org/2000/svg}path'):
                path.set('fill', fill_color)

            background_rect = ET.Element(
                '{http://www.w3.org/2000/svg}rect',
                attrib={'width': '100%', 'height': '100%', 'fill': back_color}
            )
            root.insert(0, background_rect)

            modified_svg_data = ET.tostring(root, encoding='unicode')
            print("✅ Returning SVG QR")
            return send_file(
                io.BytesIO(modified_svg_data.encode('utf-8')),
                mimetype='image/svg+xml',
                as_attachment=False,
                download_name='qrcode.svg'
            )

        else:
            return {"error": "Unsupported format. Use 'png' or 'svg'."}, 400

    except Exception as e:
        print("❌ Error in generate_qr_with_params:")
        import traceback; traceback.print_exc()
        return {"error": f"An unexpected error occurred: {e}"}, 500

def styling(encoded_data, format='svg', fill_color='black', back_color='white', box_size=10, border=4):
    return generate_qr_with_params(
        encoded_data, format, fill_color, back_color, box_size, border
    )






@app.route('/qrcode')
def generate_qr():
    return generate_qr_with_params(
        data=unquote(request.args.get('url', 'https://www.google.com')),
        format=request.args.get('format', 'svg'),
        fill_color=request.args.get('fill', 'black'),
        back_color=request.args.get('background', 'white'),
        box_size=int(request.args.get('box_size', 10)),
        border=int(request.args.get('border', 4)),
        error_correction=request.args.get('error_correction', 'H')
    )


@app.route('/wifi', methods=['GET', 'POST'])
def generate_wifi_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract Wi-Fi connection details
        ssid = request_data.get('ssid', None)  # Wi-Fi network name
        password = request_data.get('password', '')  # Wi-Fi password
        encryption = request_data.get('encryption', 'WPA')  # Encryption type (default to WPA)
        hidden = request_data.get('hidden', 'false').lower() == 'true'  # Hidden network flag

        if not ssid:
            return {"error": "Wi-Fi SSID is required."}, 400

        # Build the Wi-Fi QR code content
        hidden_flag = f"H:{hidden};" if hidden else ""
        wifi_data = f"WIFI:T:{encryption};S:{ssid};P:{password};{hidden_flag}"

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate and style the QR code with the Wi-Fi data
        return styling(wifi_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500




@app.route('/vcard', methods=['GET', 'POST'])
def generate_vcard_with_photo():
    try:
        request_data = request.get_json() if request.method == 'POST' else request.args
        print("📥 Request data received:", dict(request_data))

        # Basic contact details
        name = request_data.get('name', '').strip()
        phone = request_data.get('phone', '').strip()
        email = request_data.get('email', '').strip()
        company = request_data.get('company', '').strip()
        title = request_data.get('title', '').strip()
        website = request_data.get('website', '').strip()
        address = request_data.get('address', '').strip()

        if not name or not phone:
            return {"error": "Name and phone are required fields for vCard."}, 400

        # Structured name
        name_parts = name.split(" ", 1)
        first_name = name_parts[0]
        last_name = name_parts[1] if len(name_parts) > 1 else ""

        print("👤 Generating vCard...")
        vcard_lines = [
            "BEGIN:VCARD",
            "VERSION:3.0",
            f"N;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE:{qp_utf8(last_name)};{qp_utf8(first_name)};;;",
            f"FN;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE:{qp_utf8(name)}",
            f"TEL:{phone}",
        ]

        if email:
            vcard_lines.append(f"EMAIL:{email}")
        if company:
            vcard_lines.append(f"ORG;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE:{qp_utf8(company)}")
        if title:
            vcard_lines.append(f"TITLE;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE:{qp_utf8(title)}")
        if website:
            vcard_lines.append(f"URL:{website}")
        if address:
            vcard_lines.append(f"ADR;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE:;;{qp_utf8(address)}")

        vcard_lines.append("END:VCARD")
        vcard_data = "\n".join(vcard_lines)

        format = request_data.get('format', 'svg')
        fill_color = request_data.get('fill', 'black')
        back_color = request_data.get('background', 'white')
        box_size = int(request_data.get('box_size', 10))
        border = int(request_data.get('border', 4))

        return generate_qr_with_params(vcard_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        print("❌ ValueError:", ve)
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        print("❌ Exception occurred:")
        traceback.print_exc()
        return {"error": f"An unexpected error occurred: {e}"}, 500

@app.route('/whatsapp', methods=['GET', 'POST'])
def generate_whatsapp_qr():
    try:
        request_data = request.get_json() if request.method == 'POST' else request.args

        raw_phone = request_data.get('phone', '')
        phone = normalize_phone(raw_phone)

        message = request_data.get('message', 'Hello!')
        format = request_data.get('format', 'svg')
        fill_color = request_data.get('fill', 'black')
        back_color = request_data.get('background', 'white')
        box_size = int(request_data.get('box_size', 10))
        border = int(request_data.get('border', 4))

        encoded_message = quote(message)
        qr_data = f"https://wa.me/{phone}?text={encoded_message}"

        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/email', methods=['GET', 'POST'])
def generate_email_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract email data
        recipient = request_data.get('recipient', 'example@example.com')
        subject = request_data.get('subject', 'Hello')
        body = request_data.get('body', 'This is a test email.')

        # Format email data as a mailto URI
        email_data = f"mailto:{recipient}?subject={subject}&body={body}"

        # Extract QR code styling options
        format = request_data.get('format', 'svg')
        fill_color = request_data.get('fill', 'black')
        back_color = request_data.get('background', 'white')
        box_size = int(request_data.get('box_size', 10))
        border = int(request_data.get('border', 4))

        # Generate QR code with email data and styling
        return styling(email_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/call', methods=['GET', 'POST'])
def generate_call_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract phone number and QR code styling options
        phone = request_data.get('phone', '123456789')  # Default phone number
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate the QR code content
        qr_data = f"tel:{phone}"

        # Generate and style the QR code
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/sms', methods=['GET', 'POST'])
def generate_sms_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract phone number, message, and QR code styling options
        phone = request_data.get('phone', '123456789')  # Default phone number
        message = request_data.get('message', 'Hello!')  # Default message
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate the QR code content
        qr_data = f"sms:{phone}?body={message}"

        # Generate and style the QR code
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500



@app.route('/discord', methods=['GET', 'POST'])
def generate_discord_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract Discord server and channel IDs
        server_id = request_data.get('server_id', '123456789012345678')  # Default server ID
        channel_id = request_data.get('channel_id', '876543210987654321')  # Default channel ID

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate the Discord URL
        qr_data = f"discord://discord.com/channels/{server_id}/{channel_id}"

        # Generate and style the QR code
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/discord_invite', methods=['GET', 'POST'])
def generate_discord_invite_qr():
    try:
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract invite code
        invite_code = request_data.get('invite_code', 'defaultCode')  # Default invite code

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate the Discord invite URL
        qr_data = f"https://discord.gg/{invite_code}"

        # Generate and style the QR code
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/messenger', methods=['GET', 'POST'])
def generate_messenger_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract Messenger username or user ID
        username = request_data.get('username', 'defaultUsername')  # Default Messenger username

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Format the Messenger URL
        qr_data = f"https://m.me/{username}"

        # Generate and style the QR code
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/facebook_page', methods=['GET', 'POST'])
def generate_facebook_page_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract Facebook page username or ID
        page = request_data.get('page', 'defaultPage')  # Default Facebook page username or ID

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Format the Facebook page URL
        qr_data = f"https://facebook.com/{page}"

        # Generate and style the QR code
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500






@app.route('/paybysquare', methods=['GET', 'POST'])
def pay_by_square():
    try:
        # Handle GET and POST requests differently
        if request.method == 'POST':
            # Extract data from JSON body
            request_data = request.get_json()
        elif request.method == 'GET':
            # Extract data from query parameters
            request_data = request.args

        # Validate mandatory fields
        mandatory_fields = ['amount', 'currency', 'iban']
        missing_fields = [field for field in mandatory_fields if field not in request_data]
        if missing_fields:
            return {"error": f"Missing mandatory fields: {', '.join(missing_fields)}"}, 400

        # Extract payment-related data
        amount = request_data.get('amount', '0.00')
        currency = request_data.get('currency', 'EUR')
        date = request_data.get('date', '20240101')
        variable_symbol = request_data.get('variable_symbol', '')
        constant_symbol = request_data.get('constant_symbol', '')
        specific_symbol = request_data.get('specific_symbol', '')
        note = request_data.get('note', '')
        iban = request_data.get('iban', '')
        swift = request_data.get('swift', '')

        # Extract styling-related data
        format = request_data.get('format', 'svg')
        fill_color = request_data.get('fill', 'black')
        back_color = request_data.get('background', 'white')
        box_size = int(request_data.get('box_size', 10))
        border = int(request_data.get('border', 4))

        # Generate PayBySquare data
        data = "\t".join([
            "",
            "1",
            "\t".join([
                "1",  # True
                amount,  # SUMA
                currency,  # JEDNOTKA
                date,  # DATUM
                variable_symbol,  # VARIABILNY SYMBOL
                constant_symbol,  # KONSTANTNY SYMBOL
                specific_symbol,  # SPECIFICKY SYMBOL
                "",
                note,  # POZNAMKA
                "1",
                iban,  # IBAN
                swift,  # SWIFT
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

        # Generate QR code with styling
        return styling(encoded_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/qrplatba', methods=['GET', 'POST'])
def qr_platba():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            # Extract data from JSON body
            request_data = request.get_json()
        elif request.method == 'GET':
            # Extract data from query parameters
            request_data = request.args

        # Validate mandatory fields
        mandatory_fields = ['iban', 'amount']
        missing_fields = [field for field in mandatory_fields if field not in request_data]
        if missing_fields:
            return {"error": f"Missing mandatory fields: {', '.join(missing_fields)}"}, 400

        # Extract payment data
        iban = request_data.get('iban')
        amount = float(request_data.get('amount'))
        currency = request_data.get('currency', 'CZK')
        message = request_data.get('message', '')
        variable_symbol = request_data.get('variable_symbol', '')

        # Base Pay by Square (SPD) format
        qr_data = f"SPD*1.0*ACC:{iban.replace(' ', '')}*AM:{amount:.2f}*CC:{currency}"
        if message:
            qr_data += f"*MSG:{message}"
        if variable_symbol:
            qr_data += f"*X-VS:{variable_symbol}"

        # Extract styling options
        format = request_data.get('format', 'svg')
        fill_color = request_data.get('fill', 'black')
        back_color = request_data.get('background', 'white')
        box_size = int(request_data.get('box_size', 10))
        border = int(request_data.get('border', 4))

        # Generate QR code with styling
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/sepa', methods=['GET', 'POST'])
def generate_sepa_payment_qr():
    try:
        request_data = request.get_json() if request.method == 'POST' else request.args
        print("Request received:", request_data)

        # Fallback function for safe fallback value
        def fallback(val, default):
            return val if val and val.strip() else default

        # Basic fields
        creditor_name = request_data.get('creditor_name') or 'Default Creditor'
        creditor_iban = request_data.get('iban') or 'SK6802000000001234567890'
        creditor_bic = request_data.get('bic') or 'UNCRSKBX'
        reference = request_data.get('reference') or ''
        remittance_info = request_data.get('remittance_information') or ''
        amount = "{:.2f}".format(float(request_data.get('amount') or '1.00'))


        # QR styling
        format = fallback(request_data.get('format'), 'svg')
        fill_color = fallback(request_data.get('fill'), 'black')
        back_color = fallback(request_data.get('background'), 'white')
        box_size = int(fallback(request_data.get('box_size'), 10))
        border = int(fallback(request_data.get('border'), 4))

        # EPC QR data
        epc_qr_data = "\n".join([
            "BCD",
            "001",
            "1",
            "SCT",
            creditor_bic,
            creditor_name,
            creditor_iban,
            f"EUR{amount}",
            reference,
            remittance_info
        ])

        print("Generated EPC QR string:")
        print(epc_qr_data)

        return styling(epc_qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid value: {ve}"}, 400
    except Exception as e:
        import traceback
        traceback.print_exc()
        return {"error": f"Unexpected error: {e}"}, 500



@app.route('/revolut', methods=['GET', 'POST'])
def generate_revolut_payment_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract Revolut payment details
        username = request_data.get('username', 'defaultuser')  # Revolut username

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate the Revolut payment URL
        qr_data = f"https://revolut.me/{username}"

        # Generate and style the QR code
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/paypal', methods=['GET', 'POST'])
def generate_paypal_payment_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract PayPal payment details
        username = request_data.get('username', None)  # PayPal.Me username
        if not username:
            return {"error": "PayPal.Me username is required"}, 400

        amount = request_data.get('amount', None)  # Optional amount

        # Construct the PayPal.Me URL
        if amount:
            try:
                # Ensure the amount is valid
                formatted_amount = f"{float(amount):.2f}"
                qr_data = f"https://www.paypal.com/paypalme/{username}/{formatted_amount}"
            except ValueError:
                return {"error": "Invalid amount. It must be a number."}, 400
        else:
            qr_data = f"https://www.paypal.com/paypalme/{username}"

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate and style the QR code
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500





@app.route('/event', methods=['GET', 'POST'])
def generate_calendar_event_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract event details
        title = request_data.get('title', 'New Event')  # Event title
        start_input = request_data.get('start')  # Start date/time (from datetime-local input)
        end_input = request_data.get('end')  # End date/time (from datetime-local input)
        location = request_data.get('location', '')  # Event location
        description = request_data.get('description', '')  # Event description

        # Validate datetime inputs
        if not start_input or not end_input:
            return {"error": "Start and end datetime values are required."}, 400

        # Format datetime inputs into iCalendar format
        def format_datetime_to_ics(dt_input):
            try:
                # Parse the input datetime (assumes datetime-local format)
                dt_obj = datetime.strptime(dt_input, '%Y-%m-%dT%H:%M')  # Convert to datetime object
                # Convert to UTC and format as iCalendar (YYYYMMDDTHHMMSSZ)
                return dt_obj.astimezone(timezone.utc).strftime('%Y%m%dT%H%M%SZ')
            except ValueError as e:
                raise ValueError(f"Invalid datetime format: {e}")

        start = format_datetime_to_ics(start_input)
        end = format_datetime_to_ics(end_input)

        # Escape fields to ensure proper iCalendar formatting
        def escape_ics_field(value):
            return value.replace('\\', '\\\\').replace(';', '\\;').replace(',', '\\,').replace(':', '\\:')

        title = escape_ics_field(title)
        location = escape_ics_field(location)
        description = escape_ics_field(description)

        # Generate the iCalendar data
        qr_data = (
            f"BEGIN:VCALENDAR\n"
            f"VERSION:2.0\n"
            f"BEGIN:VEVENT\n"
            f"SUMMARY:{title}\n"
            f"DTSTART:{start}\n"
            f"DTEND:{end}\n"
            f"LOCATION:{location}\n"
            f"DESCRIPTION:{description}\n"
            f"END:VEVENT\n"
            f"END:VCALENDAR"
        )

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate QR code with the event data
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/recurring_event', methods=['GET', 'POST'])
def generate_recurring_event_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract event details
        summary = request_data.get('summary', 'Recurring Event')  # Event title
        start_date = request_data.get('start_date', '20250110T090000Z')  # Start date/time (UTC)
        end_date = request_data.get('end_date', '20250110T100000Z')  # End date/time (UTC)
        location = request_data.get('location', 'Location')  # Event location
        description = request_data.get('description', 'Recurring event description')  # Event description
        recurrence_rule = request_data.get('rrule', 'FREQ=WEEKLY;COUNT=10')  # Recurrence rule

        # Build the complete iCalendar data
        ical_data = f"""BEGIN:VCALENDAR
        VERSION:2.0
        CALSCALE:GREGORIAN
        BEGIN:VEVENT
        SUMMARY:{summary}
        DTSTART:{start_date}
        DTEND:{end_date}
        RRULE:{recurrence_rule}
        LOCATION:{location}
        DESCRIPTION:{description}
        END:VEVENT
        END:VCALENDAR
        """

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate and style the QR code
        return styling(ical_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/google_tasks_qr', methods=['GET'])
def generate_google_tasks_qr():
    # Google OAuth2 URL
    oauth_url = (
        f"https://accounts.google.com/o/oauth2/v2/auth?"
        f"client_id={CLIENT_ID}&redirect_uri={REDIRECT_URI}"
        f"&response_type=code&scope=https://www.googleapis.com/auth/tasks"
    )

    # Generate QR code for the OAuth URL
    format = request.args.get('format', 'svg')  # Default QR code format
    fill_color = request.args.get('fill', 'black')  # Default fill color
    back_color = request.args.get('background', 'white')  # Default background color
    box_size = int(request.args.get('box_size', 10))  # Default box size
    border = int(request.args.get('border', 4))  # Default border size

    # Generate and style the QR code
    return styling(oauth_url, format, fill_color, back_color, box_size, border)


@app.route('/oauth2callback', methods=['GET'])
def oauth2callback():
    # Get the authorization code from the callback
    auth_code = request.args.get('code')
    if not auth_code:
        return {"error": "Authorization code is missing."}, 400

    # Exchange the authorization code for an access token
    token_url = "https://oauth2.googleapis.com/token"
    token_data = {
        "code": auth_code,
        "client_id": CLIENT_ID,
        "client_secret": CLIENT_SECRET,
        "redirect_uri": REDIRECT_URI,
        "grant_type": "authorization_code"
    }

    token_response = requests.post(token_url, data=token_data)
    if token_response.status_code != 200:
        return {"error": "Failed to retrieve access token."}, 400

    access_token = token_response.json().get("access_token")

    # Add a task using the Google Tasks API
    tasks_url = "https://tasks.googleapis.com/tasks/v1/lists/@default/tasks"
    task_data = {
        "title": "Sample Task",
        "notes": "This task was added via Google Tasks API."
    }
    headers = {"Authorization": f"Bearer {access_token}"}

    task_response = requests.post(tasks_url, json=task_data, headers=headers)
    if task_response.status_code != 200:
        return {"error": "Failed to add task to Google Tasks."}, 400

    return jsonify({"message": "Task added successfully!", "task": task_response.json()})






@app.route('/google_meet', methods=['GET', 'POST'])
def generate_google_meet_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract Google Meet details
        meeting_url = request_data.get('meeting_url', None)  # Google Meet link
        if not meeting_url or not meeting_url.startswith("https://meet.google.com/"):
            return {"error": "A valid Google Meet link is required."}, 400

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate and style the QR code with the Google Meet link
        return styling(meeting_url, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/microsoft_meeting', methods=['GET', 'POST'])
def generate_microsoft_meeting_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract Microsoft Teams meeting link
        meeting_url = request_data.get('meeting_url', None)  # Microsoft Teams meeting link
        if not meeting_url or not meeting_url.startswith("https://teams.microsoft.com/l/"):
            return {"error": "A valid Microsoft Teams meeting link is required."}, 400

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate and style the QR code with the Microsoft Teams link
        return styling(meeting_url, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/zoom_meeting', methods=['GET', 'POST'])
def generate_zoom_meeting_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract Zoom meeting link
        meeting_url = request_data.get('meeting_url', None)  # Zoom meeting link

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate and style the QR code with the Zoom meeting link
        return styling(meeting_url, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500






@app.route('/google_maps', methods=['GET', 'POST'])
def generate_location_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract location details
        latitude = request_data.get('latitude', None)  # Latitude for coordinates
        longitude = request_data.get('longitude', None)  # Longitude for coordinates
        address = request_data.get('address', None)  # Address for the location

        # Construct the Google Maps URL
        if latitude and longitude:
            location_url = f"https://www.google.com/maps?q={latitude},{longitude}"
        elif address:
            location_url = f"https://www.google.com/maps?q={address.replace(' ', '+')}"
        else:
            return {"error": "Either latitude and longitude or address must be provided."}, 400

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate and style the QR code with the location URL
        return styling(location_url, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/google_maps_route', methods=['GET', 'POST'])
def generate_google_maps_route_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract route details
            
        start_location = request_data.get('start', '').strip() or 'London'  # Default to 'London'
        destination = request_data.get('destination', '').strip() or 'Paris'  # Default to 'Paris'

        stops = request_data.get('stops', '').split(',')  # Stops as comma-separated list

        if not start_location or not destination:
            return {"error": "Both start and destination locations are required."}, 400

        # Build the Google Maps URL with stops
        waypoints_query = "|".join([stop.replace(' ', '+') for stop in stops if stop])
        route_url = f"https://www.google.com/maps/dir/?api=1&origin={start_location.replace(' ', '+')}&destination={destination.replace(' ', '+')}"
        if waypoints_query:
            route_url += f"&waypoints={waypoints_query}"

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate and style the QR code with the Google Maps route URL
        return styling(route_url, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/apple_maps', methods=['GET', 'POST'])
def generate_apple_maps_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract location details
        latitude = request_data.get('latitude', None)  # Latitude for coordinates
        longitude = request_data.get('longitude', None)  # Longitude for coordinates
        address = request_data.get('address', None)  # Address for the location

        # Construct the Apple Maps URL
        if latitude and longitude:
            location_url = f"http://maps.apple.com/?ll={latitude},{longitude}"
        elif address:
            location_url = f"http://maps.apple.com/?q={address.replace(' ', '+')}"
        else:
            return {"error": "Either latitude and longitude or address must be provided."}, 400

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate and style the QR code with the Apple Maps link
        return styling(location_url, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


@app.route('/apple_maps_route', methods=['GET', 'POST'])
def generate_apple_maps_route_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract route details
        start_location = request_data.get('start', '').strip() or 'London'  # Default to 'London'
        destination = request_data.get('destination', '').strip() or 'Paris'  # Default to 'Paris'
        stops = request_data.get('stops', '').split(',')  # Stops as comma-separated list

        if not start_location or not destination:
            return {"error": "Both start and destination locations are required."}, 400

        # Build the Apple Maps URL with stops
        stops_query = "+to:".join([stop.replace(' ', '+') for stop in stops if stop])
        route_url = f"http://maps.apple.com/?saddr={start_location.replace(' ', '+')}&daddr={destination.replace(' ', '+')}"
        if stops_query:
            route_url += f"+to:{stops_query}"

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate and style the QR code with the Apple Maps route URL
        return styling(route_url, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500









if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001)
