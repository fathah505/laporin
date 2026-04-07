<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan - Lapor.in</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }
        .main-content { margin-left: 260px; padding: 20px; min-height: 100vh; }
        .topbar {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .topbar h1 { font-size: 28px; color: #2d5a7b; }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .btn i[data-lucide] { width: 16px; height: 16px; }
        .btn-back { background: #e0e0e0; color: #333; }
        .btn-back:hover { background: #d0d0d0; }
        .btn-edit { background: rgba(255,152,0,0.1); color: #ff9800; padding: 12px 25px; border: 2px solid #ff9800; }
        .btn-edit:hover { background: #ff9800; color: white; }
        .btn-delete { background: rgba(244,67,54,0.1); color: #f44336; padding: 12px 25px; border: 2px solid #f44336; }
        .btn-delete:hover { background: #f44336; color: white; }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .card h3 {
            color: #2d5a7b;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card h3 i[data-lucide] { width: 20px; height: 20px; }

        .info-grid { display: grid; grid-template-columns: 200px 1fr; gap: 15px; margin-bottom: 25px; }
        .info-label { font-weight: 600; color: #666; }
        .info-value { color: #333; }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .status-badge i[data-lucide] { width: 14px; height: 14px; }
        .status-menunggu { background: rgba(244,67,54,0.1); color: #f44336; }
        .status-proses { background: rgba(255,152,0,0.1); color: #ff9800; }
        .status-selesai { background: rgba(76,175,80,0.1); color: #4caf50; }

        .foto-pengaduan {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 10px;
        }
        .action-buttons { display: flex; gap: 10px; margin-top: 20px; }
        .hint-text { margin-top: 15px; font-size: 13px; color: #999; display: flex; align-items: center; gap: 6px; }
        .hint-text i[data-lucide] { width: 14px; height: 14px; }

        /* Timeline */
        .timeline { position: relative; padding-left: 30px; }
        .timeline::before {
            content: '';
            position: absolute;
            left: 6px; top: 10px; bottom: 10px;
            width: 2px;
            background: #e0e0e0;
        }
        .timeline-item { position: relative; padding-bottom: 20px; }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -26px; top: 5px;
            width: 14px; height: 14px;
            border-radius: 50%;
            background: #4fb3bf;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #4fb3bf;
        }
        .timeline-date { font-size: 12px; color: #999; margin-bottom: 5px; }
        .timeline-content { color: #666; }

        /* Tanggapan */
        .tanggapan-card {
            background: linear-gradient(135deg, rgba(79,179,191,0.05), rgba(45,90,123,0.05));
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #4fb3bf;
            margin-top: 15px;
        }
        .tanggapan-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .tanggapan-meta i[data-lucide] { width: 18px; height: 18px; color: #4fb3bf; }
        .tanggapan-meta strong { color: #2d5a7b; }
        .tanggapan-text { color: #333; line-height: 1.8; white-space: pre-wrap; }

        .empty-tanggapan { text-align: center; padding: 40px; color: #999; }
        .empty-tanggapan i[data-lucide] { width: 48px; height: 48px; margin-bottom: 15px; color: #e0e0e0; }
    </style>
</head>
<body>
    @include('siswa.partials.sidebar')

    <main class="main-content">
        <div class="topbar">
            <h1>Detail Pengaduan #{{ str_pad($pengaduan->id, 4, '0', STR_PAD_LEFT) }}</h1>
            <a href="{{ route('siswa.pengaduan') }}" class="btn btn-back">
                <i data-lucide="arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Detail Pengaduan -->
        <div class="card">
            <h3><i data-lucide="clipboard-list"></i> Informasi Pengaduan</h3>
            <div class="info-grid">
                <div class="info-label">Tanggal Pengaduan</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->format('d F Y, H:i') }} WIB</div>

                <div class="info-label">Kategori</div>
                <div class="info-value">{{ $pengaduan->kategori->nama_kategori }}</div>

                <div class="info-label">Status</div>
                <div class="info-value">
                    @if($pengaduan->status == '0')
                        <span class="status-badge status-menunggu"><i data-lucide="clock"></i> Menunggu Verifikasi</span>
                    @elseif($pengaduan->status == '1')
                        <span class="status-badge status-proses"><i data-lucide="loader"></i> Sedang Diproses</span>
                    @else
                        <span class="status-badge status-selesai"><i data-lucide="check-circle"></i> Selesai Ditangani</span>
                    @endif
                </div>

                <div class="info-label">Judul Laporan</div>
                <div class="info-value"><strong>{{ $pengaduan->judul_laporan }}</strong></div>

                <div class="info-label">Isi Laporan</div>
                <div class="info-value" style="white-space: pre-wrap; line-height: 1.8;">{{ $pengaduan->isi_laporan }}</div>

                @if($pengaduan->foto)
                <div class="info-label">Foto Bukti</div>
                <div class="info-value">
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="foto-pengaduan">
                </div>
                @endif
            </div>

            @if($pengaduan->status == '0')
            <div class="action-buttons">
                <a href="{{ route('siswa.pengaduan.edit', $pengaduan->id) }}" class="btn btn-edit">
                    <i data-lucide="pencil"></i> Edit Pengaduan
                </a>
                <form action="{{ route('siswa.pengaduan.delete', $pengaduan->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus pengaduan ini?')">
                        <i data-lucide="trash-2"></i> Hapus Pengaduan
                    </button>
                </form>
            </div>
            <p class="hint-text">
                <i data-lucide="info"></i>
                Anda hanya dapat mengedit atau menghapus pengaduan yang masih berstatus "Menunggu"
            </p>
            @endif
        </div>

        <!-- Timeline -->
        <div class="card">
            <h3><i data-lucide="calendar"></i> Timeline Pengaduan</h3>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-date">{{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->format('d M Y, H:i') }}</div>
                    <div class="timeline-content">
                        <strong>Pengaduan dibuat</strong><br>
                        Pengaduan Anda telah berhasil dikirim dan menunggu verifikasi dari admin.
                    </div>
                </div>

                @if($pengaduan->status >= '1')
                <div class="timeline-item">
                    <div class="timeline-date">
                        @if($pengaduan->tanggapan)
                            {{ \Carbon\Carbon::parse($pengaduan->tanggapan->tgl_tanggapan)->format('d M Y, H:i') }}
                        @endif
                    </div>
                    <div class="timeline-content">
                        <strong>Pengaduan sedang diproses</strong><br>
                        Admin sedang menindaklanjuti pengaduan Anda.
                    </div>
                </div>
                @endif

                @if($pengaduan->status == '2')
                <div class="timeline-item">
                    <div class="timeline-date">
                        @if($pengaduan->tanggapan)
                            {{ \Carbon\Carbon::parse($pengaduan->tanggapan->tgl_tanggapan)->format('d M Y, H:i') }}
                        @endif
                    </div>
                    <div class="timeline-content">
                        <strong>Pengaduan selesai ditangani</strong><br>
                        Terima kasih atas laporan Anda. Masalah telah diselesaikan.
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Tanggapan Petugas -->
        <div class="card">
            <h3><i data-lucide="message-square"></i> Tanggapan Admin</h3>
            @if($pengaduan->tanggapan)
            <div class="tanggapan-card">
                <div class="tanggapan-meta">
                    <i data-lucide="user-circle"></i>
                    <strong>{{ $pengaduan->tanggapan->admin->name ?? 'Admin' }}</strong>
                    <span>&bull;</span>
                    <span>{{ \Carbon\Carbon::parse($pengaduan->tanggapan->tgl_tanggapan)->format('d F Y, H:i') }} WIB</span>
                </div>
                <div class="tanggapan-text">{{ $pengaduan->tanggapan->tanggapan }}</div>
            </div>
            @else
            <div class="empty-tanggapan">
                <i data-lucide="clock"></i>
                <p style="font-weight: 600; color: #666; margin-bottom: 5px;">Belum Ada Tanggapan</p>
                <p style="font-size: 14px; color: #999;">Pengaduan Anda sedang menunggu tanggapan dari admin</p>
            </div>
            @endif
        </div>
    </main>

    <script>lucide.createIcons();</script>
</body>
</html>