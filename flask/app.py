from flask import Flask, request, send_file
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



app = Flask(__name__)
CORS(app)
CLIENT_ID = "1025295778547-069622a895e1nd1srnknp1p8gv9h2c00.apps.googleusercontent.com"
CLIENT_SECRET = "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"
REDIRECT_URI = "https://kaqapp.com/oauth2callback"




@app.route('/qrcode', methods=['GET'])
def generate_qr():
    # Extract and validate parameters
    try:
        data = request.args.get('url', 'https://www.google.sk')
        format = request.args.get('format', 'png')
        fill_color = request.args.get('fill', 'black')
        back_color = request.args.get('background', 'white')

        version = int(request.args.get('version', 2))
        if not (1 <= version <= 40):
            return {"error": "Version must be an integer between 1 and 40."}, 400
        
        error_correction_map = {
            'L': qrcode.constants.ERROR_CORRECT_L,
            'M': qrcode.constants.ERROR_CORRECT_M,
            'Q': qrcode.constants.ERROR_CORRECT_Q,
            'H': qrcode.constants.ERROR_CORRECT_H,
        }
        error_correction_key = request.args.get('error_correction', 'H')
        if error_correction_key not in error_correction_map:
            return {"error": "Invalid error_correction value. Use 'L', 'M', 'Q', or 'H'."}, 400
        error_correction = error_correction_map[error_correction_key]
        
        box_size = int(request.args.get('box_size', 10))
        border = int(request.args.get('border', 4))

        qr = qrcode.QRCode(
            version=version,
            error_correction=error_correction,
            box_size=box_size,
            border=border,
        )
        qr.add_data(data)
        qr.make(fit=True)

        # Generate QR code
        if format == 'png':
            img = qr.make_image(fill_color=fill_color, back_color=back_color)
            buf = io.BytesIO()
            img.save(buf, format="PNG")
            buf.seek(0)
            return send_file(buf, mimetype='image/png', as_attachment=False, download_name='qrcode.png')
        
        
        elif format == 'svg':
            factory = qrcode.image.svg.SvgPathImage
            img_svg = qrcode.make(data, image_factory=factory)

            # Generate the SVG as a string
            buf = io.BytesIO()
            img_svg.save(buf)
            buf.seek(0)
            svg_data = buf.getvalue().decode('utf-8')

            # Parse the SVG to modify the path fill attributes
            root = ET.fromstring(svg_data)
            for path in root.findall('.//{http://www.w3.org/2000/svg}path'):
                path.set('fill', fill_color)

            # Add the background color using a <rect> element
            background_rect = ET.Element(
                '{http://www.w3.org/2000/svg}rect',
                attrib={
                    'width': '100%',
                    'height': '100%',
                    'fill': back_color,
                }
            )
            root.insert(0, background_rect)  # Insert background as the first element

            # Convert the modified SVG tree back to a string
            modified_svg_data = ET.tostring(root, encoding='unicode')

            # Serve the modified SVG
            return send_file(
                io.BytesIO(modified_svg_data.encode('utf-8')),
                mimetype='image/svg+xml',
                as_attachment=False,
                download_name='qrcode.svg'
            )



        else:
            return {"error": "Unsupported format. Use 'png' or 'svg'."}, 400
    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500

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
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract vCard data
        name = request_data.get('name', 'Unknown')
        phone = request_data.get('phone', '')
        email = request_data.get('email', '')
        company = request_data.get('company', '')
        title = request_data.get('title', '')
        website = request_data.get('website', '')
        address = request_data.get('address', '')
        photo_url = request_data.get('photo', '')

        # Validate required fields
        if not name or not phone:
            return {"error": "Name and phone are required fields for vCard."}, 400

        # Generate vCard data
        vcard_data = f"""BEGIN:VCARD
        VERSION:4.0
        FN:{name}   
        TEL:{phone}
        EMAIL:{email}
        """
        if company:
            vcard_data += f"ORG:{company}\n"
        if title:
            vcard_data += f"TITLE:{title}\n"
        if website:
            vcard_data += f"URL:{website}\n"
        if address:
            vcard_data += f"ADR:;;{address}\n"

        vcard_data += "END:VCARD"

        # Clean up any unnecessary spaces or indentation
        vcard_data = vcard_data.strip()

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate QR code with vCard data and styling
        return styling(vcard_data, format, fill_color, back_color, box_size, border)

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


@app.route('/whatsapp', methods=['GET', 'POST'])
def generate_whatsapp_qr():
    try:
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract phone number, message, and QR code styling options
        phone = request_data.get('phone', '1234567890')  # Default phone number
        message = request_data.get('message', 'Hello!')  # Default message
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Format the WhatsApp API URL
        encoded_message = message.replace(' ', '%20')  # URL-encode spaces
        qr_data = f"https://wa.me/{phone}?text={encoded_message}"

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
        # Handle GET and POST requests
        if request.method == 'POST':
            request_data = request.get_json()
        elif request.method == 'GET':
            request_data = request.args

        # Extract SEPA payment details
        creditor_name = request_data.get('creditor_name', 'Default Creditor')  # Creditor's name
        creditor_iban = request_data.get('creditor_iban', 'BE72000000001616')  # Creditor's IBAN
        creditor_bic = request_data.get('creditor_bic', 'BPOTBEB1')  # Creditor's BIC
        amount = request_data.get('amount', '1.00')  # Amount in euros
        remittance_information = request_data.get('remittance_information', 'Sample EPC QR code')  # Payment details
        reason = request_data.get('reason', 'CHAR')  # Reason (4 characters max)
        ref_invoice = request_data.get('ref_invoice', '')  # Reference or empty line

        # Extract QR code styling options
        format = request_data.get('format', 'svg')  # Default QR code format
        fill_color = request_data.get('fill', 'black')  # Default fill color
        back_color = request_data.get('background', 'white')  # Default background color
        box_size = int(request_data.get('box_size', 10))  # Default box size
        border = int(request_data.get('border', 4))  # Default border size

        # Generate SEPA payment QR data following EPC format
        qr_data = f"""BCD
001
1
SCT
{creditor_bic}
{creditor_name}
{creditor_iban}
EUR{amount}
{reason}
{ref_invoice}
{remittance_information}
"""

        # Generate and style the QR code
        return styling(qr_data, format, fill_color, back_color, box_size, border)

    except ValueError as ve:
        return {"error": f"Invalid parameter value: {ve}"}, 400
    except Exception as e:
        return {"error": f"An unexpected error occurred: {e}"}, 500


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







def styling(encoded_data, format='svg', fill_color='black', back_color='white', box_size=10, border=4):
    request.args = request.args.copy()
    request.args.update({
        'url': encoded_data,
        'format': format,
        'fill': fill_color,
        'background': back_color,
        'box_size': box_size,
        'border': border,
    })
    return generate_qr()


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001)
