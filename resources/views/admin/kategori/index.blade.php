<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Lapor.in</title>
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

        .btn-primary {
            background: linear-gradient(135deg, #4fb3bf 0%, #2d5a7b 100%);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary i[data-lucide] { width: 16px; height: 16px; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79,179,191,0.4); }

        .table-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        thead { background: #f5f7fa; }
        th { padding: 15px; text-align: left; font-weight: 600; color: #2d5a7b; font-size: 14px; }
        td { padding: 15px; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        tbody tr:hover { background: #f9fafb; }

        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .action-btn i[data-lucide] { width: 14px; height: 14px; }
        .btn-edit { background: rgba(255,152,0,0.1); color: #ff9800; }
        .btn-edit:hover { background: #ff9800; color: white; }
        .btn-delete { background: rgba(244,67,54,0.1); color: #f44336; }
        .btn-delete:hover { background: #f44336; color: white; }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            background: rgba(79,179,191,0.1);
            color: #4fb3bf;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s ease;
        }
        .modal.show { display: flex; align-items: center; justify-content: center; }
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            animation: slideDown 0.3s ease;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }
        .modal-header h3 { color: #2d5a7b; font-size: 20px; display: flex; align-items: center; gap: 8px; }
        .modal-header h3 i[data-lucide] { width: 20px; height: 20px; }
        .close-btn { font-size: 28px; color: #999; cursor: pointer; transition: color 0.3s ease; line-height: 1; }
        .close-btn:hover { color: #333; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; color: #2d5a7b; margin-bottom: 8px; }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus { outline: none; border-color: #4fb3bf; }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="main-content">
        <div class="topbar">
            <h1>Kelola Kategori</h1>
            <button class="btn-primary" onclick="showAddModal()">
                <i data-lucide="plus"></i> Tambah Kategori
            </button>
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

        <div class="table-card">
            <h3 style="color: #2d5a7b; margin-bottom: 10px;">Daftar Kategori Pengaduan</h3>
            <p style="color: #666; font-size: 14px;">Kelola kategori untuk mengorganisir pengaduan</p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Pengaduan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $kategori)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $kategori->nama_kategori }}</strong></td>
                        <td><span class="badge">{{ $kategori->pengaduan_count }} pengaduan</span></td>
                        <td>
                            <button class="action-btn btn-edit" onclick="showEditModal({{ $kategori->id }}, '{{ $kategori->nama_kategori }}')">
                                <i data-lucide="pencil"></i> Edit
                            </button>
                            <form action="{{ route('admin.kategori.delete', $kategori->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                    <i data-lucide="trash-2"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: #999;">Belum ada kategori. Tambahkan kategori pertama Anda!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Tambah -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i data-lucide="tag"></i> Tambah Kategori Baru</h3>
                <span class="close-btn" onclick="closeAddModal()">&times;</span>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" placeholder="Contoh: Fasilitas Kelas" required>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%;">
                    <i data-lucide="save"></i> Simpan Kategori
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i data-lucide="pencil"></i> Edit Kategori</h3>
                <span class="close-btn" onclick="closeEditModal()">&times;</span>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" id="editNamaKategori" name="nama_kategori" required>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%;">
                    <i data-lucide="save"></i> Update Kategori
                </button>
            </form>
        </div>
    </div>

    <script>
        function showAddModal() { document.getElementById('addModal').classList.add('show'); }
        function closeAddModal() { document.getElementById('addModal').classList.remove('show'); }
        function showEditModal(id, nama) {
            document.getElementById('editForm').action = '{{ url("admin/kategori") }}/' + id;
            document.getElementById('editNamaKategori').value = nama;
            document.getElementById('editModal').classList.add('show');
        }
        function closeEditModal() { document.getElementById('editModal').classList.remove('show'); }
        window.onclick = function(event) {
            if (event.target == document.getElementById('addModal')) closeAddModal();
            if (event.target == document.getElementById('editModal')) closeEditModal();
        }
    </script>
    <script>lucide.createIcons();</script>
    <script>
        // Auto-hide alert setelah 4 detik
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