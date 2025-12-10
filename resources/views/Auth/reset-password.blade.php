{{-- resources/views/auth/reset-password.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Reset Password</title>
  <!-- Tambahkan CSS (Tailwind/Bootstrap sesuai project Anda). Di contoh ini gaya minimal -->
  <style>
    body { font-family: Arial, sans-serif; background:#f3f6f8; }
    .card { max-width:480px;margin:60px auto;background:#fff;padding:28px;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06);}
    .form-group{margin-bottom:16px;}
    .form-control{width:100%;padding:10px;border:1px solid #e0e6eb;border-radius:8px;}
    .btn{display:inline-block;padding:10px 16px;border-radius:8px;border:none;cursor:pointer;}
    .btn-primary{background:#0b4a8b;color:#fff;width:100%;}
    .btn-disabled{background:#9fb3d0;color:#fff;cursor:not-allowed;}
    .text-error{color:#d32f2f;font-size:13px;margin-top:6px;}
    .text-success{color:#2e7d32;font-size:13px;margin-top:6px;}
    .small-muted{font-size:13px;color:#6b7280;margin-bottom:10px;}
  </style>
</head>
<body>
  <div class="card">
    <h2 style="text-align:center;margin-bottom:6px;">Reset Password</h2>
    <p class="small-muted" style="text-align:center;">Masukkan username dan password baru Anda</p>

    @if(session('status'))
      <div style="background:#e6ffed;padding:10px;border-radius:6px;margin-bottom:12px;color:#0b6626">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.reset.update') }}" id="resetForm" novalidate>
      @csrf

      <div class="form-group">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" class="form-control" value="{{ old('username') }}" autocomplete="username">
        <div id="username-feedback" style="margin-top:6px;font-size:13px;"></div>
        @error('username')
          <div class="text-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="password">Password Baru (min 8 karakter, termasuk huruf besar, huruf kecil, dan angka)</label>
        <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
        @error('password')
          <div class="text-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
      </div>

      <div style="margin-top:8px;">
        <button type="submit" id="submitBtn" class="btn btn-primary">Simpan Password Baru</button>
      </div>

      <div style="margin-top:10px;text-align:center;">
        <a href="{{ route('login') }}">Kembali ke Login</a>
      </div>
    </form>
  </div>

  {{-- JS: fetch API untuk cek username real-time --}}
  <script>
    (function(){
      const usernameEl = document.getElementById('username');
      const feedbackEl = document.getElementById('username-feedback');
      const submitBtn = document.getElementById('submitBtn');
      let lastValue = '';
      let usernameExists = null; // null = belum dicek, true/false = hasil

      function setFeedback(message, ok) {
        feedbackEl.textContent = message;
        feedbackEl.className = ok ? 'text-success' : 'text-error';
      }

      function setButtonState() {
        if (usernameExists === false) {
          submitBtn.classList.add('btn-disabled');
          submitBtn.disabled = true;
        } else {
          submitBtn.classList.remove('btn-disabled');
          submitBtn.disabled = false;
        }
      }

      let timer = null;
      usernameEl.addEventListener('input', function() {
        const v = this.value.trim();
        usernameExists = null;
        setFeedback('', true);
        setButtonState();

        if (timer) clearTimeout(timer);
        // singkat debounce 400ms
        timer = setTimeout(() => {
          if (v === '') {
            setFeedback('Masukkan username.', false);
            usernameExists = false;
            setButtonState();
            return;
          }
          // jika tidak berubah, skip
          if (v === lastValue) return;
          lastValue = v;

          // lakukan permintaan ke server
          fetch("{{ route('password.check-username') }}?username=" + encodeURIComponent(v), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
          })
          .then(r => r.json())
          .then(json => {
            usernameExists = !!json.exists;
            setFeedback(json.message, usernameExists);
            setButtonState();
          })
          .catch(err => {
            // kalau gagal koneksi, jangan blokir submit, tetapi beri pesan
            setFeedback('Gagal memeriksa username (cek koneksi).', false);
            usernameExists = null;
            setButtonState();
          });
        }, 400);
      });

      // Pastikan ketika submit, server-side juga melakukan validasi (defensive)
      document.getElementById('resetForm').addEventListener('submit', function(e){
        // jika sudah ada hasil cek dan false => cegah submit
        if (usernameExists === false) {
          e.preventDefault();
          setFeedback('Username tidak terdaftar. Perbaiki dulu.', false);
          usernameEl.focus();
        }
      });

      // Inisialisasi: jika ada nilai lama pada input (old), trigger check
      if (usernameEl.value.trim() !== '') {
        usernameEl.dispatchEvent(new Event('input'));
      }
    })();
  </script>
</body>
</html>