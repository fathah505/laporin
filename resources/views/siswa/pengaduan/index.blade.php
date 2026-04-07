<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Saya - Lapor.in</title>
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
        .alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert i[data-lucide] { width: 18px; height: 18px; flex-shrink: 0; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }
        .btn i[data-lucide] { width: 16px; height: 16px; }
        .btn-primary { background: linear-gradient(135deg, #4fb3bf 0%, #2d5a7b 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79,179,191,0.4); }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .filter-form { display: flex; gap: 15px; flex-wrap: wrap; }
        .filter-form input,
        .filter-form select {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
        }
        .filter-form input[type="text"] { flex: 1; min-width: 250px; }

        .table-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f5f7fa; }
        th { padding: 15px; text-align: left; font-weight: 600; color: #2d5a7b; font-size: 14px; }
        td { padding: 15px; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        tbody tr:hover { background: #f9fafb; }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .status-menunggu { background: rgba(244,67,54,0.1); color: #f44336; }
        .status-proses { background: rgba(255,152,0,0.1); color: #ff9800; }
        .status-selesai { background: rgba(76,175,80,0.1); color: #4caf50; }
        .status-ditolak { background: rgba(244,67,54,0.1); color: #f44336; }

        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .action-btn i[data-lucide] { width: 14px; height: 14px; }
        .btn-view { background: rgba(79,179,191,0.1); color: #4fb3bf; }
        .btn-view:hover { background: #4fb3bf; color: white; }
        .btn-edit { background: rgba(255,152,0,0.1); color: #ff9800; }
        .btn-edit:hover { background: #ff9800; color: white; }
        .btn-delete { background: rgba(244,67,54,0.1); color: #f44336; }
        .btn-delete:hover { background: #f44336; color: white; }

        .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 20px; }
        .pagination a { padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; text-decoration: none; color: #2d5a7b; }
        .pagination a.active { background: #4fb3bf; color: white; border-color: #4fb3bf; }
    </style>
</head>
<body>
    @include('siswa.partials.sidebar')

    <main class="main-content">
        <div class="topbar">
            <h1>Pengaduan Saya</h1>
            <a href="{{ route('siswa.pengaduan.create') }}" class="btn btn-primary">
                <i data-lucide="plus"></i> Buat Pengaduan Baru
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <i data-lucide="check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <i data-lucide="x-circle"></i> {{ session('error') }}
        </div>
        @endif

        <div class="filter-section">
            <form action="{{ route('siswa.pengaduan') }}" method="GET" class="filter-form">
                <input type="text" name="search" placeholder="Cari pengaduan..." value="{{ request('search') }}">
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Menunggu</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Proses</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Selesai</option>
                    <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <select name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="search"></i> Filter
                </button>
            </form>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduan as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_pengaduan)->format('d M Y') }}</td>
                        <td>{{ $item->kategori->nama_kategori }}</td>
                        <td>{{ Str::limit($item->judul_laporan, 30) }}</td>
                        <td>{{ Str::limit($item->isi_laporan, 40) }}</td>
                        <td>
                            @if($item->status == '0')
                                <span class="status-badge status-menunggu">Menunggu</span>
                            @elseif($item->status == '1')
                                <span class="status-badge status-proses">Diproses</span>
                            @elseif($item->status == '2')
                                <span class="status-badge status-selesai">Selesai</span>
                            @else
                                <span class="status-badge status-ditolak">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('siswa.pengaduan.show', $item->id) }}" class="action-btn btn-view">
                                <i data-lucide="eye"></i> Detail
                            </a>
                            @if($item->status == '0')
                            <a href="{{ route('siswa.pengaduan.edit', $item->id) }}" class="action-btn btn-edit">
                                <i data-lucide="pencil"></i> Edit
                            </a>
                            <form action="{{ route('siswa.pengaduan.delete', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete" onclick="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                    <i data-lucide="trash-2"></i> Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                            Anda belum membuat pengaduan.<br>
                            <a href="{{ route('siswa.pengaduan.create') }}" style="color: #4fb3bf; text-decoration: none; font-weight: 600;">Buat pengaduan pertama Anda →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">{{ $pengaduan->links() }}</div>
        </div>
    </main>

    <script>lucide.createIcons();</script>
</body>
</html>