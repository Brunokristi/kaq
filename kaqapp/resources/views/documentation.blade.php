@extends('layouts.app')

@section('title', 'QR API Documentation')

@section('content')
<div class="documentation">
    <h1>QR Code Generator API Documentation</h1>

    <p>This API provides endpoints to generate QR codes for various use cases such as contact sharing, Wi-Fi credentials, calendar events, payments, social media, and map navigation. You can customize QR code styles and download them in SVG or PNG format.</p>

    
     

    <h2>API Endpoints</h2>

    <h3>URL QR</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/qrcode</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Generates a QR code for a URL.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>url</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>/qrcode?url=https://example.com&amp;format=png</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>Wi-Fi</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/wifi</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Share Wi-Fi credentials using QR code.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>ssid</code> (required), <code>password</code>, <code>encryption</code>, <code>hidden</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>POST /wifi</code> with JSON: <code>{ "ssid": "Home", "password": "12345678" }</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>vCard Contact</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/vcard</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Share contact details as vCard.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>name</code>, <code>phone</code> (required), <code>email</code>, <code>company</code>, <code>title</code>, <code>website</code>, <code>address</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>POST /vcard</code> with JSON: <code>{ "name": "John Doe", "phone": "+421900000000" }</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>WhatsApp</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/whatsapp</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Send predefined WhatsApp message.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>phone</code>, <code>message</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>/whatsapp?phone=0900123456&amp;message=Hi!</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>Email</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/email</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Compose an email using a QR code.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>recipient</code>, <code>subject</code>, <code>body</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>POST /email</code> with JSON: <code>{ "recipient": "user@example.com", "subject": "Hi" }</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>Call</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/call</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Dial a number from QR code.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>phone</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>/call?phone=123456789</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>SMS</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/sms</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Send SMS with predefined message.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>phone</code>, <code>message</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>/sms?phone=123456789&amp;message=Hello</code></td>
    </tr>
    </tbody>
    </table>


    <h3>PayBySquare</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/paybysquare</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Slovak bank QR payments.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>amount</code>, <code>currency</code>, <code>iban</code>, <code>note</code>, <code>symbols</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>POST /paybysquare</code> with JSON: <code>{ "amount": "12.50", "currency": "EUR", "iban": "SK12..." }</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>QR Platba (CZ)</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/qrplatba</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Czech payment format (SPD).</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>iban</code>, <code>amount</code>, <code>currency</code>, <code>message</code>, <code>variable_symbol</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>/qrplatba?iban=CZ12...&amp;amount=120</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>SEPA Payment</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/sepa</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>EU SEPA credit transfer.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>creditor_name</code>, <code>iban</code>, <code>bic</code>, <code>amount</code>, <code>reference</code>, <code>remittance_information</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>POST /sepa</code> with JSON: <code>{ "iban": "SK12...", "amount": "25.00" }</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>Revolut &amp; PayPal</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/revolut</code>, <code>/paypal</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>QR codes for Revolut or PayPal payments.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>username</code>, <code>amount</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>/paypal?username=abc&amp;amount=12</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>Event (Calendar)</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/event</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>iCalendar format for one-time event.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>title</code>, <code>start</code>, <code>end</code>, <code>location</code>, <code>description</code></td>
    </tr>
    <tr>
    <td>Example</td>
    <td><code>POST /event</code> with JSON: <code>{ "title": "Meeting", "start": "2025-06-01T10:00", "end": "2025-06-01T11:00" }</code></td>
    </tr>
    </tbody>
    </table>

     
     

    <h3>Meeting Links</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/google_meet</code>, <code>/microsoft_meeting</code>, <code>/zoom_meeting</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Generate QR code for online meeting links.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>meeting_url</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>Google/Apple Maps Location</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/google_maps</code>, <code>/apple_maps</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Show a place on map.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>latitude</code>, <code>longitude</code>, <code>address</code></td>
    </tr>
    </tbody>
    </table>

     

    <h3>Google/Apple Maps Route</h3>

    <table>
    <thead>
    <tr>
    <th>Endpoint</th>
    <th><code>/google_maps_route</code>, <code>/apple_maps_route</code></th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Description</td>
    <td>Show route on map from start to destination.</td>
    </tr>
    <tr>
    <td>Parameters</td>
    <td><code>start</code>, <code>destination</code>, <code>stops</code></td>
    </tr>
    </tbody>
    </table>

     

    <h2>Error Codes</h2>

    <table>
    <thead>
    <tr>
    <th>Code</th>
    <th>Meaning</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>400</td>
    <td>Invalid or missing parameters</td>
    </tr>
    <tr>
    <td>500</td>
    <td>Internal server error</td>
    </tr>
    </tbody>
    </table>

    <h2>Styling</h2>

    <table>
    <thead>
    <tr>
    <th>Parameter</th>
    <th>Type</th>
    <th>Description</th>
    <th>Default</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td><code>format</code></td>
    <td><code>string</code></td>
    <td>Image format: <code>svg</code> or <code>png</code></td>
    <td><code>svg</code></td>
    </tr>
    <tr>
    <td><code>fill</code></td>
    <td><code>string</code></td>
    <td>Foreground color</td>
    <td><code>black</code></td>
    </tr>
    <tr>
    <td><code>background</code></td>
    <td><code>string</code></td>
    <td>Background color</td>
    <td><code>white</code></td>
    </tr>
    <tr>
    <td><code>box_size</code></td>
    <td><code>int</code></td>
    <td>Size of QR boxes</td>
    <td><code>10</code></td>
    </tr>
    <tr>
    <td><code>border</code></td>
    <td><code>int</code></td>
    <td>Border thickness</td>
    <td><code>4</code></td>
    </tr>
    </tbody>
    </table>

     

    <h2>Example Curl</h2>

    <div class="codehilite">
    <pre><span></span>curl<span class="w"> </span><span class="s2">&quot;https://your-domain/qrcode?url=https://openai.com&amp;format=svg&quot;</span>
    </pre>
    </div>

    <h2>Example JSON POST</h2>

    <div class="codehilite">
    <pre><span></span><span class="err">POST</span><span class="w"> </span><span class="err">/wi</span><span class="kc">f</span><span class="err">i</span>
    <span class="p">{</span>
    <span class="w">  </span><span class="nt">&quot;ssid&quot;</span><span class="p">:</span><span class="w"> </span><span class="s2">&quot;MyWiFi&quot;</span><span class="p">,</span>
    <span class="w">  </span><span class="nt">&quot;password&quot;</span><span class="p">:</span><span class="w"> </span><span class="s2">&quot;mypassword&quot;</span><span class="p">,</span>
    <span class="w">  </span><span class="nt">&quot;format&quot;</span><span class="p">:</span><span class="w"> </span><span class="s2">&quot;png&quot;</span>
    <span class="p">}</span>
    </pre>
    </div>

     

    <h2 style="text-align: center; padding-top: 40px;">For any questions or suggestions</h2>
    <a href="{{ route('contact') }}">get in touch with us <i class="bi bi-arrow-right"></i></a>
</div>
@endsection