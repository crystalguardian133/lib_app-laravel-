<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Membership Card</title>
  <style>
body {
  margin:0; padding:20px; background:#0b1220;
  display:flex; flex-direction:column;
  align-items:center; justify-content:center;
  gap:20px; min-height:100vh;
  font-family:'Inter', sans-serif;
}
.card {
  position:relative;
  width:1011px; height:638px;
  box-shadow:0 10px 30px rgba(0,0,0,.4);
}
.card.front {
  background:url('/card_temp/card-1.png') no-repeat center/cover;
}
.card.back {
  background:url('/card_temp/card-2.png') no-repeat center/cover;
}
.field {
  position:absolute; color:#0b1220; font-weight:600;
  white-space:nowrap; transform:translate(-50%,-50%);
}
.name { left:500px; top:300px; font-size:36px; font-weight:700; }
.id   { left:500px; top:360px; font-size:24px; }

.photo {
  position:absolute; left:120px; top:240px;
  width:180px; height:180px; border-radius:50%;
  overflow:hidden; background:#e5e7eb;
  display:flex; align-items:center; justify-content:center;
}
.photo img { width:100%; height:100%; object-fit:cover; }

.qr {
  position:absolute; left:435px; top:250px; /* adjust based on back template */
  width:140px; height:140px; background:#fff; border-radius:8px; overflow:hidden;
}
.qr img { width:100%; height:100%; object-fit:contain; }

.controls { display:flex; gap:10px; }
button {
  padding:10px 16px; border:none; border-radius:8px; cursor:pointer;
  background:#0ea5e9; color:#fff; font-weight:600;
  box-shadow:0 4px 12px rgba(14,165,233,.4);
}

@media print {
  body { background:#fff; }
  .controls { display:none; }
  .card { box-shadow:none; }
  @page { size:1011px 638px; margin:0; }
}


  </style>
</head>
<body>
  <div id="cardStage"></div>

  <div class="controls">
    <button id="downloadBtn">Download PNG</button>
    <button onclick="window.print()">Print / Save as PDF</button>
  </div>

  {{-- load html2canvas --}}
<script>
  window.memberId = {{ $id }};
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="{{ asset('js/card_gen.js') }}"></script>
</body>
</html>
