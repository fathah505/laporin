<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Lapor.in</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
        }
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
        .topbar h1 {
            font-size: 28px;
            color: #2d5a7b;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #e0e0e0;
            flex-shrink: 0;
        }
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #f5f7fa;
            padding: 4px;
        }
        .user-details { display: flex; flex-direction: column; }
        .user-name { font-weight: 600; color: #333; }
        .user-role { font-size: 13px; color: #666; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(79,179,191,0.2);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-icon i[data-lucide] { width: 28px; height: 28px; }
        .stat-icon.blue { background: rgba(79,179,191,0.1); color: #4fb3bf; }
        .stat-icon.orange { background: rgba(255,152,0,0.1); color: #ff9800; }
        .stat-icon.green { background: rgba(76,175,80,0.1); color: #4caf50; }
        .stat-icon.red { background: rgba(244,67,54,0.1); color: #f44336; }
        .stat-info h3 {
            font-size: 32px;
            font-weight: 700;
            color: #2d5a7b;
            margin-bottom: 5px;
        }
        .stat-info p { color: #666; font-size: 14px; }

        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        .card-header h2 { font-size: 20px; color: #2d5a7b; }
        .category-list { list-style: none; }
        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .category-item:last-child { border-bottom: none; }
        .category-name { display: flex; align-items: center; gap: 12px; }
        .category-color { width: 12px; height: 12px; border-radius: 50%; }
        .category-count {
            background: #f5f7fa;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            color: #2d5a7b;
        }

        .table-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .table-header h2 { font-size: 20px; color: #2d5a7b; }
        .search-box { display: flex; gap: 10px; }
        .search-box input {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            width: 250px;
        }
        .filter-select {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f5f7fa; }
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2d5a7b;
            font-size: 14px;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
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

        @media (max-width: 1024px) { .charts-section { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="main-content">
        <div class="topbar">
            <h1>Dashboard Admin</h1>
            <div class="user-info">
                <div class="user-details">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">{{ ucfirst(Auth::user()->level) }}</span>
                </div>
                <div class="user-avatar">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i data-lucide="clipboard-list"></i></div>
                <div class="stat-info">
                    <h3>{{ $totalPengaduan }}</h3>
                    <p>Total Pengaduan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red"><i data-lucide="clock"></i></div>
                <div class="stat-info">
                    <h3>{{ $pending }}</h3>
                    <p>Menunggu</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i data-lucide="loader"></i></div>
                <div class="stat-info">
                    <h3>{{ $proses }}</h3>
                    <p>Dalam Proses</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i data-lucide="check-circle"></i></div>
                <div class="stat-info">
                    <h3>{{ $selesai }}</h3>
                    <p>Selesai</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red"><i data-lucide="x-circle"></i></div>
                <div class="stat-info">
                    <h3>{{ $ditolak ?? 0 }}</h3>
                    <p>Ditolak</p>
                </div>
            </div>
        </div>

        <div class="charts-section">
            <div class="card">
                <div class="card-header">
                    <h2>Pengaduan per Kategori</h2>
                </div>
                <ul class="category-list">
                    @foreach($kategoriStats as $stat)
                    <li class="category-item">
                        <div class="category-name">
                            <div class="category-color" style="background: {{ $loop->iteration % 5 == 1 ? '#4fb3bf' : ($loop->iteration % 5 == 2 ? '#ff9800' : ($loop->iteration % 5 == 3 ? '#4caf50' : ($loop->iteration % 5 == 4 ? '#f44336' : '#9c27b0'))) }};"></div>
                            <span>{{ $stat->nama_kategori }}</span>
                        </div>
                        <span class="category-count">{{ $stat->total }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Status Pengaduan</h2>
                </div>
                <ul class="category-list">
                    <li class="category-item">
                        <div class="category-name">
                            <div class="category-color" style="background: #f44336;"></div>
                            <span>Pending</span>
                        </div>
                        <span class="category-count">{{ $pending }}</span>
                    </li>
                    <li class="category-item">
                        <div class="category-name">
                            <div class="category-color" style="background: #ff9800;"></div>
                            <span>Proses</span>
                        </div>
                        <span class="category-count">{{ $proses }}</span>
                    </li>
                    <li class="category-item">
                        <div class="category-name">
                            <div class="category-color" style="background: #4caf50;"></div>
                            <span>Selesai</span>
                        </div>
                        <span class="category-count">{{ $selesai }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h2>Pengaduan Terbaru</h2>
                <div class="search-box">
                    <input type="text" placeholder="Cari pengaduan...">
                    <select class="filter-select">
                        <option>Semua Status</option>
                        <option>Menunggu</option>
                        <option>Proses</option>
                        <option>Selesai</option>
                    </select>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelapor</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduan as $item)
                    <tr>
                        <td>#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_pengaduan)->format('d M Y') }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->user->kelas ?? '-' }}</td>
                        <td>{{ $item->kategori->nama_kategori }}</td>
                        <td>{{ Str::limit($item->judul_laporan, 25) }}</td>
                        <td>{{ Str::limit($item->isi_laporan, 30) }}</td>
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
                            <a href="{{ route('admin.pengaduan.show', $item->id) }}" class="action-btn btn-view">
                                <i data-lucide="eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px; color: #999;">Belum ada pengaduan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <script>lucide.createIcons();</script>
</body>
</html>