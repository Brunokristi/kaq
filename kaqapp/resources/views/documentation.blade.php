@extends('layouts.app')

@section('title', 'API Documentation')

@section('content')
<div class="documentation mx-auto w-full p-4 sm:p-6 text-black
    [&_h1]:text-center
    [&_h1]:mb-6
    [&_h2]:mb-4
    [&_h2]:text-sm
    [&_h3]:mb-3
    [&_p]:mb-4
    [&_table]:w-full
    [&_table]:border-collapse
    [&_table]:mb-8
    [&_table]:border
    [&_table]:border-black
    [&_th]:border
    [&_th]:border-black
    [&_th]:p-2
    [&_th]:text-left
    [&_th]:align-top
    [&_td]:border
    [&_td]:border-black
    [&_td]:p-2
    [&_td]:text-left
    [&_td]:align-top
    [&_td]:break-words
    [&_th:first-child]:w-[200px]
    [&_th:first-child]:whitespace-nowrap
    [&_td:first-child]:w-[200px]
    [&_td:first-child]:whitespace-nowrap
    [&_code]:bg-brand
    [&_code]:text-white
    [&_code]:px-1.5
    [&_code]:py-0.5
    [&_code]:rounded-none
    [&_pre]:bg-brand
    [&_pre]:text-white
    [&_pre]:border
    [&_pre]:border-black
    [&_pre]:p-4
    [&_pre]:overflow-x-auto
    [&_pre]:mb-4
    [&_hr]:my-12
    [&_a]:block
    [&_a]:mx-auto
    [&_a]:text-center
    [&_a]:text-sm
    [&_a]:text-brand
    [&_a]:hover:underline
    [&_i]:text-brand
    [&_i]:ml-2
    [&_i]:text-base">
    <h2 class="mb-6 text-lg uppercase">QR Code Generator API Documentation</h2>

    <p>This page reflects the current Flask API behavior. Unless noted otherwise, endpoints accept both query-string GET requests and JSON POST requests. Styling parameters such as <code>format</code>, <code>fill</code>, <code>background</code>, <code>box_size</code>, and <code>border</code> are supported across the generator endpoints below.</p>

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
                <td>Methods</td>
                <td><code>GET</code> only</td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a QR code for a URL.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>url</code> (optional, defaults to Google), <code>error_correction</code>, plus styling parameters</td>
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
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Shares Wi-Fi credentials in QR format.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>ssid</code> (required), <code>password</code> (optional), <code>encryption</code> (optional, default <code>WPA</code>), <code>hidden</code> (optional, <code>true</code>/<code>false</code>)</td>
            </tr>
            <tr>
                <td>Example</td>
                <td><code>/wifi?ssid=Home&amp;password=12345678&amp;encryption=WPA</code></td>
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
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a vCard QR code.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>name</code> (required), <code>phone</code> (required), <code>email</code>, <code>company</code>, <code>title</code>, <code>website</code>, <code>address</code></td>
            </tr>
            <tr>
                <td>Example</td>
                <td><code>/vcard?name=John%20Doe&amp;phone=%2B421900000000</code></td>
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
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a WhatsApp message link QR code. Phone numbers are normalized before building the URL.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>phone</code> (optional), <code>message</code> (optional, default <code>Hello!</code>)</td>
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
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a <code>mailto:</code> QR code.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>recipient</code> (optional), <code>subject</code> (optional), <code>body</code> (optional)</td>
            </tr>
            <tr>
                <td>Example</td>
                <td><code>/email?recipient=user@example.com&amp;subject=Hi&amp;body=Hello</code></td>
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
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a phone dial QR code.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>phone</code> (optional, default <code>123456789</code>)</td>
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
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates an SMS link QR code.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>phone</code> (optional, default <code>123456789</code>), <code>message</code> (optional, default <code>Hello!</code>)</td>
            </tr>
            <tr>
                <td>Example</td>
                <td><code>/sms?phone=123456789&amp;message=Hello</code></td>
            </tr>
        </tbody>
    </table>

    <h3>Social &amp; Sharing</h3>

    <table>
        <thead>
            <tr>
                <th>Endpoint</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>/discord</code></td>
                <td><code>server_id</code> and <code>channel_id</code> are optional. Generates a <code>discord://</code> channel link.</td>
            </tr>
            <tr>
                <td><code>/discord_invite</code></td>
                <td><code>invite_code</code> is optional. Example: <code>/discord_invite?invite_code=myserver</code></td>
            </tr>
            <tr>
                <td><code>/messenger</code></td>
                <td><code>username</code> is optional. Generates <code>https://m.me/{username}</code>.</td>
            </tr>
            <tr>
                <td><code>/facebook_page</code></td>
                <td><code>page</code> is optional. Generates <code>https://facebook.com/{page}</code>.</td>
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
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a Slovak PayBySquare payment QR code.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>amount</code> (required), <code>currency</code> (required), <code>iban</code> (required), <code>date</code>, <code>variable_symbol</code>, <code>constant_symbol</code>, <code>specific_symbol</code>, <code>note</code>, <code>swift</code></td>
            </tr>
            <tr>
                <td>Example</td>
                <td><code>/paybysquare?amount=12.50&amp;currency=EUR&amp;iban=SK1234567890123456789012&amp;date=20240101</code></td>
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
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a Czech SPD payment QR code.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>iban</code> (required), <code>amount</code> (required), <code>currency</code> (optional, default <code>CZK</code>), <code>message</code>, <code>variable_symbol</code></td>
            </tr>
            <tr>
                <td>Example</td>
                <td><code>/qrplatba?iban=CZ5855000000001265098001&amp;amount=120</code></td>
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
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates an EPC/SEPA payment QR code. This endpoint has server-side fallbacks for missing values.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>creditor_name</code>, <code>iban</code>, <code>bic</code>, <code>amount</code>, <code>reference</code>, <code>remittance_information</code></td>
            </tr>
            <tr>
                <td>Example</td>
                <td><code>/sepa?creditor_name=Acme&amp;iban=SK6802000000001234567890&amp;bic=UNCRSKBX&amp;amount=25.00</code></td>
            </tr>
        </tbody>
    </table>

    <h3>Revolut</h3>

    <table>
        <thead>
            <tr>
                <th>Endpoint</th>
                <th><code>/revolut</code></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a QR code for a Revolut profile URL.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>username</code> (optional, default <code>defaultuser</code>)</td>
            </tr>
            <tr>
                <td>Example</td>
                <td><code>/revolut?username=yourname</code></td>
            </tr>
        </tbody>
    </table>

    <h3>PayPal</h3>

    <table>
        <thead>
            <tr>
                <th>Endpoint</th>
                <th><code>/paypal</code></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a PayPal.Me QR code.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>username</code> (required), <code>amount</code> (optional numeric value)</td>
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
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a one-time iCalendar event QR code.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>title</code> (optional), <code>start</code> (required, <code>YYYY-MM-DDTHH:MM</code>), <code>end</code> (required, <code>YYYY-MM-DDTHH:MM</code>), <code>location</code>, <code>description</code></td>
            </tr>
            <tr>
                <td>Example</td>
                <td><code>/event?title=Meeting&amp;start=2025-06-01T10:00&amp;end=2025-06-01T11:00</code></td>
            </tr>
        </tbody>
    </table>

    <h3>Recurring Event</h3>

    <table>
        <thead>
            <tr>
                <th>Endpoint</th>
                <th><code>/recurring_event</code></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Methods</td>
                <td><code>GET</code>, <code>POST</code></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>Generates a recurring iCalendar event QR code.</td>
            </tr>
            <tr>
                <td>Parameters</td>
                <td><code>summary</code>, <code>start_date</code>, <code>end_date</code>, <code>location</code>, <code>description</code>, <code>rrule</code> (all optional; defaults are applied)</td>
            </tr>
            <tr>
                <td>Example</td>
                <td><code>/recurring_event?summary=Standup&amp;start_date=20250110T090000Z&amp;end_date=20250110T093000Z&amp;rrule=FREQ=WEEKLY;COUNT=10</code></td>
            </tr>
        </tbody>
    </table>

    <h3>Meeting Links</h3>

    <table>
        <thead>
            <tr>
                <th>Endpoint</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>/google_meet</code></td>
                <td><code>meeting_url</code> is required and must start with <code>https://meet.google.com/</code>.</td>
            </tr>
            <tr>
                <td><code>/microsoft_meeting</code></td>
                <td><code>meeting_url</code> is required and must start with <code>https://teams.microsoft.com/l/</code>.</td>
            </tr>
            <tr>
                <td><code>/zoom_meeting</code></td>
                <td><code>meeting_url</code> is accepted and passed through directly. Example: <code>/zoom_meeting?meeting_url=https://zoom.us/j/123456789</code></td>
            </tr>
        </tbody>
    </table>

    <h3>Google / Apple Maps Location</h3>

    <table>
        <thead>
            <tr>
                <th>Endpoint</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>/google_maps</code></td>
                <td>Requires either both <code>latitude</code> and <code>longitude</code>, or <code>address</code>.</td>
            </tr>
            <tr>
                <td><code>/apple_maps</code></td>
                <td>Requires either both <code>latitude</code> and <code>longitude</code>, or <code>address</code>.</td>
            </tr>
        </tbody>
    </table>

    <h3>Google / Apple Maps Route</h3>

    <table>
        <thead>
            <tr>
                <th>Endpoint</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>/google_maps_route</code></td>
                <td><code>start</code>, <code>destination</code>, <code>stops</code> (comma-separated). If omitted, defaults are applied for start and destination.</td>
            </tr>
            <tr>
                <td><code>/apple_maps_route</code></td>
                <td><code>start</code>, <code>destination</code>, <code>stops</code> (comma-separated). If omitted, defaults are applied for start and destination.</td>
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
    <pre><span></span>curl<span class="w"> </span><span class="s2">&quot;http://127.0.0.1:5001/qrcode?url=https://kaqapp.com&amp;format=svg&quot;</span>
    </pre>
    </div>

    <h2>Example JSON POST</h2>

    <div class="codehilite">
    <pre><span></span><span class="err">POST</span><span class="w"> </span><span class="err">/wifi</span>
    <span class="p">{</span>
    <span class="w">  </span><span class="nt">&quot;ssid&quot;</span><span class="p">:</span><span class="w"> </span><span class="s2">&quot;MyWiFi&quot;</span><span class="p">,</span>
    <span class="w">  </span><span class="nt">&quot;password&quot;</span><span class="p">:</span><span class="w"> </span><span class="s2">&quot;mypassword&quot;</span><span class="p">,</span>
    <span class="w">  </span><span class="nt">&quot;format&quot;</span><span class="p">:</span><span class="w"> </span><span class="s2">&quot;png&quot;</span>
    <span class="p">}</span>
    </pre>
    </div>

     

    <h2 class="pt-10 text-center">For any questions or suggestions</h2>
    <a href="{{ route('contact') }}">get in touch with us <i class="bi bi-arrow-right"></i></a>
</div>
@endsection