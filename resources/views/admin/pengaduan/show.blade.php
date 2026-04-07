<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan - Lapor.in</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; color: #333; }
        .main-content { margin-left: 260px; padding: 20px; min-height: 100vh; }
        .topbar { background: white; padding: 20px 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .topbar h1 { font-size: 28px; color: #2d5a7b; }
        .btn { padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; font-family: inherit; }
        .btn i[data-lucide] { width: 16px; height: 16px; }
        .btn-back { background: #e0e0e0; color: #333; }
        .btn-back:hover { background: #d0d0d0; }
        .alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert i[data-lucide] { width: 18px; height: 18px; flex-shrink: 0; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .card h3 { color: #2d5a7b; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e0e0e0; display: flex; align-items: center; gap: 10px; }
        .card h3 i[data-lucide] { width: 20px; height: 20px; }
        .info-grid { display: grid; grid-template-columns: 200px 1fr; gap: 15px; margin-bottom: 10px; }
        .info-label { font-weight: 600; color: #666; padding: 4px 0; }
        .info-value { color: #333; padding: 4px 0; }
        .status-badge { padding: 7px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }
        .status-badge i[data-lucide] { width: 13px; height: 13px; }
        .status-menunggu  { background: rgba(255,152,0,0.1); color: #ff9800; }
        .status-proses    { background: rgba(79,179,191,0.1); color: #4fb3bf; }
        .status-selesai   { background: rgba(76,175,80,0.1); color: #4caf50; }
        .status-ditolak   { background: rgba(244,67,54,0.1); color: #f44336; }
        .foto-pengaduan { max-width: 400px; height: auto; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-top: 10px; }

        /* ── Action Section ── */
        .action-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .action-box { border-radius: 10px; padding: 22px; border: 2px solid transparent; }
        .action-box.terima { background: rgba(79,179,191,0.04); border-color: rgba(79,179,191,0.3); }
        .action-box.tolak { background: rgba(244,67,54,0.04); border-color: rgba(244,67,54,0.25); }
        .action-box-title { font-size: 15px; font-weight: 700; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
        .action-box-title i[data-lucide] { width: 16px; height: 16px; }
        .action-box.terima .action-box-title { color: #2d5a7b; }
        .action-box.tolak .action-box-title { color: #c62828; }
        .form-label { font-weight: 600; color: #555; display: block; margin-bottom: 6px; font-size: 13px; }
        .form-textarea { width: 100%; padding: 10px 13px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 13px; font-family: inherit; resize: vertical; min-height: 95px; transition: border-color 0.3s; margin-bottom: 12px; }
        .action-box.terima .form-textarea:focus { outline: none; border-color: #4fb3bf; }
        .action-box.tolak .form-textarea:focus { outline: none; border-color: #f44336; }
        .btn-submit-terima { width: 100%; background: linear-gradient(135deg, #4fb3bf, #2d5a7b); color: white; padding: 11px 20px; font-size: 14px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: transform 0.2s, box-shadow 0.3s; font-family: inherit; }
        .btn-submit-terima:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(79,179,191,0.4); }
        .btn-submit-terima i[data-lucide] { width: 16px; height: 16px; }
        .btn-submit-tolak { width: 100%; background: #f44336; color: white; padding: 11px 20px; font-size: 14px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: transform 0.2s, box-shadow 0.3s; font-family: inherit; }
        .btn-submit-tolak:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(244,67,54,0.4); }
        .btn-submit-tolak i[data-lucide] { width: 16px; height: 16px; }

        .btn-selesai {
            background: linear-gradient(135deg, #4caf50, #388e3c); color: white;
            padding: 12px 28px; font-size: 15px; font-weight: 600; border-radius: 10px;
            border: none; cursor: pointer; display: inline-flex; align-items: center;
            gap: 8px; transition: transform 0.2s, box-shadow 0.3s; font-family: inherit;
        }
        .btn-selesai:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(76,175,80,0.4); }
        .btn-selesai i[data-lucide] { width: 17px; height: 17px; }

        .tanggapan-card { background: linear-gradient(135deg, rgba(79,179,191,0.05), rgba(45,90,123,0.05)); padding: 22px; border-radius: 8px; border-left: 4px solid #4fb3bf; margin-top: 15px; }
        .tanggapan-meta { display: flex; align-items: center; gap: 10px; font-size: 13px; color: #666; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid rgba(0,0,0,0.06); }
        .tanggapan-meta i[data-lucide] { width: 16px; height: 16px; color: #4fb3bf; }
        .tanggapan-meta strong { color: #2d5a7b; }
        .tanggapan-text { color: #333; line-height: 1.8; white-space: pre-wrap; }
        .info-box { background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 14px 18px; display: flex; align-items: center; gap: 10px; font-size: 14px; color: #0369a1; margin-top: 10px; }
        .info-box.ditolak { background: #fff5f5; border-color: #fecaca; color: #b91c1c; }
        .info-box i[data-lucide] { width: 16px; height: 16px; flex-shrink: 0; }
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="main-content">
        <div class="topbar">
            <h1>Detail Pengaduan #{{ str_pad($pengaduan->id, 4, '0', STR_PAD_LEFT) }}</h1>
            <a href="{{ route('admin.pengaduan') }}" class="btn btn-back">
                <i data-lucide="arrow-left"></i> Kembali
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success"><i data-lucide="check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error"><i data-lucide="x-circle"></i> {{ session('error') }}</div>
        @endif

        {{-- Informasi Pelapor --}}
        <div class="card">
            <h3><i data-lucide="user"></i> Informasi Pelapor</h3>
            <div class="info-grid">
                <div class="info-label">Nama Lengkap</div>
                <div class="info-value">{{ $pengaduan->user->name ?? '-' }}</div>
                <div class="info-label">NIS/NIP</div>
                <div class="info-value">{{ $pengaduan->user->nis_nip ?? '-' }}</div>
                <div class="info-label">Kelas</div>
                <div class="info-value">{{ $pengaduan->user->kelas ?? '-' }}</div>
                <div class="info-label">No. Telepon</div>
                <div class="info-value">{{ $pengaduan->user->telp ?? '-' }}</div>
            </div>
        </div>

        {{-- Detail Pengaduan --}}
        <div class="card">
            <h3><i data-lucide="clipboard-list"></i> Detail Pengaduan</h3>
            <div class="info-grid">
                <div class="info-label">Tanggal Pengaduan</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->format('d F Y, H:i') }} WIB</div>
                <div class="info-label">Kategori</div>
                <div class="info-value">{{ $pengaduan->kategori->nama_kategori ?? '-' }}</div>
                <div class="info-label">Status</div>
                <div class="info-value">
                    @if($pengaduan->status == '0')
                        <span class="status-badge status-menunggu"><i data-lucide="clock"></i> Menunggu</span>
                    @elseif($pengaduan->status == '1')
                        <span class="status-badge status-proses"><i data-lucide="loader"></i> Diproses</span>
                    @elseif($pengaduan->status == '2')
                        <span class="status-badge status-selesai"><i data-lucide="check-circle"></i> Selesai</span>
                    @else
                        <span class="status-badge status-ditolak"><i data-lucide="x-circle"></i> Ditolak</span>
                    @endif
                </div>
                <div class="info-label">Judul Laporan</div>
                <div class="info-value"><strong>{{ $pengaduan->judul_laporan }}</strong></div>
                <div class="info-label">Isi Laporan</div>
                <div class="info-value" style="white-space:pre-wrap;line-height:1.8;">{{ $pengaduan->isi_laporan }}</div>
                @if($pengaduan->foto)
                <div class="info-label">Foto Bukti</div>
                <div class="info-value">
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto" class="foto-pengaduan">
                </div>
                @endif
            </div>
        </div>

        {{-- Tanggapan yang sudah ada --}}
        @if($pengaduan->tanggapan)
        <div class="card">
            <h3><i data-lucide="message-square"></i> Tanggapan Admin</h3>
            <div class="tanggapan-card">
                <div class="tanggapan-meta">
                    <i data-lucide="user-circle"></i>
                    <strong>{{ $pengaduan->tanggapan->admin->name ?? 'Admin' }}</strong>
                    <span>&bull;</span>
                    <span>{{ \Carbon\Carbon::parse($pengaduan->tanggapan->tgl_tanggapan)->format('d F Y, H:i') }} WIB</span>
                </div>
                <div class="tanggapan-text">{{ $pengaduan->tanggapan->tanggapan }}</div>
            </div>
        </div>
        @endif

        {{-- ── ACTION SECTION ── --}}

        @if($pengaduan->status == '0')
        {{-- STATUS MENUNGGU: 2 box berdampingan --}}
        <div class="card">
            <h3><i data-lucide="settings-2"></i> Tindakan</h3>
            <p style="font-size:14px;color:#666;margin-bottom:18px;">Isi tanggapan pada kolom yang sesuai lalu klik tombol konfirmasi.</p>

            <div class="action-grid">
                {{-- Box Terima --}}
                <div class="action-box terima">
                    <div class="action-box-title">
                        <i data-lucide="check-circle"></i> Terima Pengaduan
                    </div>
                    <form action="{{ route('admin.pengaduan.terima', $pengaduan->id) }}" method="POST">
                        @csrf
                        <label class="form-label">Keterangan Tindak Lanjut</label>
                        <textarea class="form-textarea" name="tanggapan"
                            placeholder="Tuliskan tindak lanjut yang akan dilakukan..."
                            required minlength="5"></textarea>
                        <button type="submit" class="btn-submit-terima">
                            <i data-lucide="check"></i> Terima & Proses
                        </button>
                    </form>
                </div>

                {{-- Box Tolak --}}
                <div class="action-box tolak">
                    <div class="action-box-title">
                        <i data-lucide="x-circle"></i> Tolak Pengaduan
                    </div>
                    <form action="{{ route('admin.pengaduan.tolak', $pengaduan->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menolak pengaduan ini?')">
                        @csrf
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea class="form-textarea" name="tanggapan"
                            placeholder="Tuliskan alasan penolakan pengaduan ini..."
                            minlength="5"></textarea>
                        <button type="submit" class="btn-submit-tolak">
                            <i data-lucide="x"></i> Tolak Pengaduan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @elseif($pengaduan->status == '1')
        {{-- STATUS DIPROSES: Tombol Selesai --}}
        <div class="card">
            <h3><i data-lucide="settings-2"></i> Tindakan</h3>
            <p style="font-size:14px;color:#666;margin-bottom:16px;">Pengaduan sedang diproses. Klik tombol di bawah jika masalah sudah diselesaikan.</p>
            <form action="{{ route('admin.pengaduan.selesai', $pengaduan->id) }}" method="POST"
                  onsubmit="return confirm('Tandai pengaduan ini sebagai selesai?')">
                @csrf
                <label class="form-label">Catatan Penyelesaian <span style="font-weight:400;color:#999;">(opsional)</span></label>
                <textarea class="form-textarea" name="tanggapan"
                    placeholder="Tuliskan catatan penyelesaian jika ada..."></textarea>
                <button type="submit" class="btn-selesai">
                    <i data-lucide="check-circle"></i> Tandai Selesai
                </button>
            </form>
        </div>

        @elseif($pengaduan->status == '2')
        <div class="info-box">
            <i data-lucide="check-circle"></i>
            Pengaduan ini telah selesai ditangani dan tidak dapat diubah lagi.
        </div>

        @else
        <div class="info-box ditolak">
            <i data-lucide="x-circle"></i>
            Pengaduan ini telah ditolak dan tidak dapat diubah lagi.
        </div>
        @endif

    </main>

    <script>lucide.createIcons();</script>
    <script>
        // Auto-hide alert
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(el) {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = '0';
                setTimeout(function() { el.style.display = 'none'; }, 500);
            });
        }, 4000);
    </script>
</body>
</html>