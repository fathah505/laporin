<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Lapor.in</title>
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

        .btn-primary {
            background: linear-gradient(135deg, #4fb3bf 0%, #2d5a7b 100%);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }
        .btn-primary i[data-lucide] { width: 16px; height: 16px; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79,179,191,0.4); }

        .alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert i[data-lucide] { width: 18px; height: 18px; flex-shrink: 0; }
        .alert-info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }

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
        .stat-icon.purple { background: rgba(156,39,176,0.1); color: #9c27b0; }
        .stat-icon.orange { background: rgba(255,152,0,0.1); color: #ff9800; }
        .stat-info h3 { font-size: 32px; font-weight: 700; color: #2d5a7b; margin-bottom: 5px; }
        .stat-info p { color: #666; font-size: 14px; }

        .chart-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .chart-section h3 {
            color: #2d5a7b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .chart-section h3 i[data-lucide] { width: 20px; height: 20px; }
        .chart-placeholder {
            background: #f5f7fa;
            padding: 60px;
            border-radius: 8px;
            text-align: center;
            color: #666;
            border: 2px dashed #e0e0e0;
        }

        .category-list { list-style: none; }
        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.3s ease;
        }
        .category-item:hover { background: #f9fafb; }
        .category-item:last-child { border-bottom: none; }
        .category-name { font-weight: 600; color: #333; }
        .category-count {
            background: rgba(79,179,191,0.1);
            color: #4fb3bf;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .progress-bar { width: 200px; height: 8px; background: #e0e0e0; border-radius: 4px; overflow: hidden; margin: 0 15px; }
        .progress-fill { height: 100%; background: linear-gradient(135deg, #4fb3bf 0%, #2d5a7b 100%); transition: width 0.3s ease; }

        .note-box {
            background: #fff3cd;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        .note-box i[data-lucide] { width: 20px; height: 20px; color: #856404; flex-shrink: 0; margin-top: 2px; }
        .note-box-content p:first-child { color: #856404; font-weight: 600; margin-bottom: 5px; }
        .note-box-content p:last-child { color: #856404; font-size: 14px; }

        /* Filter */
        .filter-card {
            background: white;
            padding: 24px 28px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 28px;
        }
        .filter-card h4 {
            font-size: 15px; font-weight: 700; color: #2d5a7b;
            margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
        }
        .filter-card h4 i[data-lucide] { width: 16px; height: 16px; }
        .filter-row { display: flex; gap: 14px; flex-wrap: wrap; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; gap: 5px; }
        .filter-group label { font-size: 12px; font-weight: 600; color: #666; }
        .filter-group input,
        .filter-group select {
            padding: 9px 13px; border: 2px solid #e0e0e0; border-radius: 8px;
            font-size: 13px; font-family: inherit; min-width: 140px;
            transition: border-color 0.25s;
        }
        .filter-group input:focus,
        .filter-group select:focus { outline: none; border-color: #4fb3bf; }
        .filter-actions { display: flex; gap: 10px; align-items: flex-end; }
        .btn-filter {
            padding: 10px 20px; border: none; border-radius: 8px; font-size: 13px;
            font-weight: 600; cursor: pointer; display: inline-flex; align-items: center;
            gap: 7px; transition: all 0.25s; font-family: inherit;
        }
        .btn-filter i[data-lucide] { width: 14px; height: 14px; }
        .btn-filter.apply { background: linear-gradient(135deg, #4fb3bf, #2d5a7b); color: white; }
        .btn-filter.apply:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79,179,191,0.4); }
        .btn-filter.reset { background: #f0f0f0; color: #666; }
        .btn-filter.reset:hover { background: #e0e0e0; }
        .btn-export {
            padding: 10px 20px; border: none; border-radius: 8px; font-size: 13px;
            font-weight: 600; cursor: pointer; display: inline-flex; align-items: center;
            gap: 7px; transition: all 0.25s; font-family: inherit;
            background: linear-gradient(135deg, #4caf50, #2e7d32); color: white;
            text-decoration: none;
        }
        .btn-export i[data-lucide] { width: 14px; height: 14px; }
        .btn-export:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(76,175,80,0.4); }
        .badge-filter {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(79,179,191,0.1); color: #2d5a7b;
            padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="main-content">
        <div class="topbar">
            <h1>Laporan &amp; Statistik
                @if(request()->hasAny(['start_date','end_date','status','kategori_id']))
                <span class="badge-filter"><i data-lucide="filter"></i> Filter Aktif</span>
                @endif
            </h1>
        </div>

        @if(session('info'))
        <div class="alert alert-info">
            <i data-lucide="info"></i> {{ session('info') }}
        </div>
        @endif

        {{-- Filter Card --}}
        <div class="filter-card">
            <h4><i data-lucide="filter"></i> Filter Laporan</h4>
            <form action="{{ route('admin.laporan') }}" method="GET" id="filterForm">
                <div class="filter-row">
                    <div class="filter-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="filter-group">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="filter-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="">Semua Status</option>
                            <option value="0" {{ request('status')=='0' ? 'selected' : '' }}>Menunggu</option>
                            <option value="1" {{ request('status')=='1' ? 'selected' : '' }}>Diproses</option>
                            <option value="2" {{ request('status')=='2' ? 'selected' : '' }}>Selesai</option>
                            <option value="3" {{ request('status')=='3' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Kategori</label>
                        <select name="kategori_id">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id')==$kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter apply">
                            <i data-lucide="search"></i> Tampilkan
                        </button>
                        <a href="{{ route('admin.laporan') }}" class="btn-filter reset">
                            <i data-lucide="x"></i> Reset
                        </a>
                        {{-- Export dengan filter yang sama --}}
                        <a href="{{ route('admin.laporan.export') }}?{{ http_build_query(request()->only(['start_date','end_date','status','kategori_id'])) }}"
                           class="btn-export" id="exportBtn">
                            <i data-lucide="download"></i> Export CSV
                        </a>
                    </div>
                </div>
            </form>
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
                <div class="stat-icon purple"><i data-lucide="graduation-cap"></i></div>
                <div class="stat-info">
                    <h3>{{ $totalSiswa }}</h3>
                    <p>Total Siswa</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i data-lucide="tag"></i></div>
                <div class="stat-info">
                    <h3>{{ $totalKategori }}</h3>
                    <p>Kategori Aktif</p>
                </div>
            </div>
        </div>

        <div class="chart-section">
            <h3><i data-lucide="bar-chart-2"></i> Grafik Pengaduan per Bulan</h3>
            <div style="position: relative; height: 320px;">
                <canvas id="chartPengaduan"></canvas>
            </div>
        </div>

        <div class="chart-section">
            <h3><i data-lucide="trophy"></i> Top 5 Kategori Pengaduan</h3>
            <ul class="category-list">
                @forelse($topKategori as $index => $kategori)
                <li class="category-item">
                    <div style="display: flex; align-items: center; gap: 15px; flex: 1;">
                        <span style="font-size: 20px; font-weight: 700; color: #4fb3bf;">{{ $index + 1 }}</span>
                        <span class="category-name">{{ $kategori->nama_kategori }}</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $totalPengaduan > 0 ? ($kategori->pengaduan_count / $totalPengaduan * 100) : 0 }}%"></div>
                    </div>
                    <span class="category-count">{{ $kategori->pengaduan_count }} pengaduan</span>
                </li>
                @empty
                <li class="category-item" style="justify-content: center; color: #999;">Belum ada data kategori</li>
                @endforelse
            </ul>
        </div>

        <div class="chart-section">
            <h3><i data-lucide="calendar"></i> Ringkasan Status Pengaduan</h3>
            <div style="position: relative; height: 280px;">
                <canvas id="chartStatus"></canvas>
            </div>
        </div>

        <div class="note-box">
            <i data-lucide="info"></i>
            <div class="note-box-content">
                <p>Cara Export</p>
                <p>Klik tombol <strong>Export CSV</strong> untuk mengunduh data sesuai filter yang aktif. File CSV dapat dibuka di Microsoft Excel atau Google Sheets.</p>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

        const bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        const rawData = @json($pengaduanPerBulan);
        const dataPerBulan = Array(12).fill(0);
        rawData.forEach(function(item) {
            dataPerBulan[item.bulan - 1] = item.total;
        });

        const statusData = {
            menunggu: {{ $pending ?? 0 }},
            diproses: {{ $proses ?? 0 }},
            selesai:  {{ $selesai ?? 0 }},
            ditolak:  {{ $ditolak ?? 0 }},
        };

        // ── Chart 1: Bar — Pengaduan per Bulan ──
        const ctx1 = document.getElementById('chartPengaduan').getContext('2d');
        const grad1 = ctx1.createLinearGradient(0, 0, 0, 320);
        grad1.addColorStop(0, 'rgba(79,179,191,0.9)');
        grad1.addColorStop(1, 'rgba(45,90,123,0.35)');

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: bulanLabels,
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: dataPerBulan,
                    backgroundColor: grad1,
                    borderColor: '#4fb3bf',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#2d5a7b',
                        titleFont: { family: 'Segoe UI', size: 13 },
                        bodyFont: { family: 'Segoe UI', size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) {
                                return '  ' + ctx.parsed.y + ' pengaduan';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Segoe UI', size: 13 }, color: '#666' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            font: { family: 'Segoe UI', size: 12 },
                            color: '#999'
                        }
                    }
                }
            }
        });

        // ── Chart 2: Doughnut — Status Pengaduan ──
        const ctx2 = document.getElementById('chartStatus').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'],
                datasets: [{
                    data: [statusData.menunggu, statusData.diproses, statusData.selesai, statusData.ditolak],
                    backgroundColor: [
                        'rgba(255,152,0,0.85)',
                        'rgba(79,179,191,0.85)',
                        'rgba(76,175,80,0.85)',
                        'rgba(244,67,54,0.85)'
                    ],
                    borderColor: ['#ff9800','#4fb3bf','#4caf50','#f44336'],
                    borderWidth: 2,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: { family: 'Segoe UI', size: 13 },
                            color: '#333',
                            padding: 20,
                            usePointStyle: true,
                            pointStyleWidth: 12,
                        }
                    },
                    tooltip: {
                        backgroundColor: '#2d5a7b',
                        titleFont: { family: 'Segoe UI', size: 13 },
                        bodyFont: { family: 'Segoe UI', size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce(function(a,b){return a+b;}, 0);
                                const pct = total > 0 ? Math.round(ctx.parsed / total * 100) : 0;
                                return '  ' + ctx.parsed + ' pengaduan (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>