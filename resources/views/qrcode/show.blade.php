<h1>Your QR Code:</h1>
<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate($data)) !!}" alt="QR Code">
