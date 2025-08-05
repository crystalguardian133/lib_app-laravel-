<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Membership Card</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 50px; }
    .card-container { border: 1px solid #333; padding: 30px; }
    .fullname { font-size: 24px; font-weight: bold; margin-bottom: 20px; }
    .memberdate { font-size: 16px; margin-bottom: 30px; }
    .qr { text-align: center; margin-top: 50px; }
    .page-break { page-break-before: always; }
  </style>
</head>
<body>
  <div class="card-container">
    <div class="fullname">{{ $fullName }}</div>
    <div class="memberdate">Member Since: {{ $memberdate }}</div>
  </div>

  <div class="page-break"></div>

  <div class="qr">
    <img src="{{ $qrCode }}" width="150">
    <p>Scan to verify membership</p>
  </div>
</body>
</html>