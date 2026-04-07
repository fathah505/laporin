<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Users - Lapor.in</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; color: #333; }
        .main-content { margin-left: 260px; padding: 20px; min-height: 100vh; }
        .topbar { background: white; padding: 20px 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .topbar h1 { font-size: 28px; color: #2d5a7b; }

        .alert { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert i[data-lucide] { width: 18px; height: 18px; flex-shrink: 0; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error   { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* Validation errors */
        .error-list { background: #fff5f5; border: 1px solid #fecaca; border-radius: 8px; padding: 14px 18px; margin-bottom: 18px; }
        .error-list p { color: #c62828; font-weight: 600; font-size: 13px; margin-bottom: 6px; }
        .error-list ul { padding-left: 18px; }
        .error-list ul li { color: #c62828; font-size: 13px; margin-bottom: 3px; }

        .btn-primary { background: linear-gradient(135deg, #4fb3bf 0%, #2d5a7b 100%); color: white; padding: 12px 25px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.3s ease; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary i[data-lucide] { width: 16px; height: 16px; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79,179,191,0.4); }

        .table-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        thead { background: #f5f7fa; }
        th { padding: 15px; text-align: left; font-weight: 600; color: #2d5a7b; font-size: 14px; }
        td { padding: 15px; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        tbody tr:hover { background: #f9fafb; }

        .level-badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-w   eight: 600; display: inline-flex; align-items: center; gap: 5px; }
        .level-badge i[data-lucide] { width: 13px; height: 13px; }
        .level-admin  { background: rgba(156,39,176,0.1); color: #9c27b0; }
        .level-siswa  { background: rgba(76,175,80,0.1); color: #4caf50; }

        .action-btn { padding: 8px 12px; border: none; border-radius: 6px; font-size: 13px; cursor: pointer; transition: all 0.3s ease; margin-right: 5px; display: inline-flex; align-items: center; gap: 5px; font-family: inherit; }
        .action-btn i[data-lucide] { width: 14px; height: 14px; }
        .btn-edit   { background: rgba(255,152,0,0.1); color: #ff9800; }
        .btn-edit:hover   { background: #ff9800; color: white; }
        .btn-delete { background: rgba(244,67,54,0.1); color: #f44336; }
        .btn-delete:hover { background: #f44336; color: white; }

        /* Modal */
        .modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); overflow-y: auto; }
        .modal.show { display: flex; align-items: flex-start; justify-content: center; padding: 40px 20px; }
        .modal-content { background: white; padding: 30px; border-radius: 12px; width: 90%; max-width: 580px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); animation: slideDown 0.3s ease; margin: auto; }
        @keyframes slideDown { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #e0e0e0; }
        .modal-header h3 { color: #2d5a7b; font-size: 20px; display: flex; align-items: center; gap: 8px; }
        .modal-header h3 i[data-lucide] { width: 20px; height: 20px; }
        .close-btn { font-size: 28px; color: #999; cursor: pointer; line-height: 1; }
        .close-btn:hover { color: #333; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-group { margin-bottom: 16px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { display: block; font-weight: 600; color: #2d5a7b; margin-bottom: 7px; font-size: 13px; }
        .form-group input,
        .form-group select { width: 100%; padding: 11px 14px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit; transition: border-color 0.3s; }
        .form-group input:focus,
        .form-group select:focus { outline: none; border-color: #4fb3bf; }
        .form-group input.is-error,
        .form-group select.is-error { border-color: #f44336; }
        .form-group small { color: #999; font-size: 12px; display: block; margin-top: 4px; }

        /* Dynamic field sections */
        .field-admin { display: none; }
        .field-siswa  { display: none; }

        .divider { border: none; border-top: 1px dashed #e0e0e0; margin: 4px 0 16px; }

        .btn-submit { width: 100%; padding: 13px; background: linear-gradient(135deg, #4fb3bf, #2d5a7b); color: white; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: transform 0.2s, box-shadow 0.3s; font-family: inherit; margin-top: 4px; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(79,179,191,0.4); }
        .btn-submit i[data-lucide] { width: 17px; height: 17px; }

        /* Pagination */
        .pagination-wrap {
            display: flex; align-items: center; gap: 6px;
            margin-top: 22px; flex-wrap: wrap;
        }
        .page-btn {
            padding: 7px 13px; border-radius: 7px; font-size: 13px; font-weight: 600;
            text-decoration: none; border: 2px solid #e0e0e0;
            color: #2d5a7b; background: white;
            transition: all 0.2s; display: inline-block; cursor: pointer;
        }
        .page-btn:hover { background: #4fb3bf; color: white; border-color: #4fb3bf; }
        .page-btn.active { background: linear-gradient(135deg, #4fb3bf, #2d5a7b); color: white; border-color: transparent; }
        .page-btn.disabled { color: #bbb; background: #f5f5f5; border-color: #e8e8e8; cursor: default; pointer-events: none; }
        .page-info { margin-left: 8px; font-size: 13px; color: #888; }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="main-content">
        <div class="topbar">
            <h1>Kelola Users</h1>
            <button class="btn-primary" onclick="showAddModal()">
                <i data-lucide="user-plus"></i> Tambah User
            </button>
        </div>

        @if(session('success'))
        <div class="alert alert-success"><i data-lucide="check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error"><i data-lucide="x-circle"></i> {{ session('error') }}</div>
        @endif

        {{-- Jika ada error validasi, buka modal lagi otomatis --}}
        @if($errors->any())
        <div class="error-list">
            <p><i data-lucide="alert-triangle" style="display:inline;width:14px;height:14px;"></i> Gagal menyimpan, periksa kembali:</p>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="table-card">
            <h3 style="color:#2d5a7b;margin-bottom:6px;">Daftar Pengguna Sistem</h3>
            <p style="color:#666;font-size:14px;">Kelola akun admin dan siswa</p>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIS / NIP</th>
                        <th>Nama</th>
                        <th>Level</th>
                        <th>Kelas</th>
                        <th>Telepon</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $i }}</td>
                        <td><strong>{{ $user->nis_nip ?? $user->username ?? '-' }}</strong></td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if($user->level == 'admin')
                                <span class="level-badge level-admin"><i data-lucide="shield"></i> Admin</span>
                            @else
                                <span class="level-badge level-siswa"><i data-lucide="graduation-cap"></i> Siswa</span>
                            @endif
                        </td>
                        <td>{{ $user->kelas ?? '-' }}</td>
                        <td>{{ $user->telp ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                        <td>
                            <button class="action-btn btn-edit"
                                onclick="showEditModal(
                                    {{ $user->id }},
                                    '{{ addslashes($user->name) }}',
                                    '{{ $user->level }}',
                                    '{{ addslashes($user->nis_nip ?? '') }}',
                                    '{{ addslashes($user->username ?? '') }}',
                                    '{{ addslashes($user->email ?? '') }}',
                                    '{{ addslashes($user->kelas ?? '') }}',
                                    '{{ addslashes($user->telp ?? '') }}'
                                )">
                                <i data-lucide="pencil"></i> Edit
                            </button>
                            @if($user->id != auth()->id())
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus user {{ addslashes($user->name) }}?')">
                                    <i data-lucide="trash-2"></i> Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:#999;">Belum ada user terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($users->hasPages())
            <div class="pagination-wrap">
                @if($users->onFirstPage())
                    <span class="page-btn disabled">« Prev</span>
                @else
                    <a class="page-btn" href="{{ $users->previousPageUrl() }}">« Prev</a>
                @endif

                @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    @if($page == $users->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a class="page-btn" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($users->hasMorePages())
                    <a class="page-btn" href="{{ $users->nextPageUrl() }}">Next »</a>
                @else
                    <span class="page-btn disabled">Next »</span>
                @endif

                <span class="page-info">
                    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
                </span>
            </div>
            @endif
        </div>
    </main>

    {{-- ══════════════════════════════════════════════
         MODAL TAMBAH USER
    ══════════════════════════════════════════════ --}}
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i data-lucide="user-plus"></i> Tambah User Baru</h3>
                <span class="close-btn" onclick="closeAddModal()">&times;</span>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" id="addForm">
                @csrf

                {{-- Baris 1: Nama + Level --}}
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap <span style="color:red;">*</span></label>
                        <input type="text" name="name" placeholder="Contoh: Ahmad Rizki"
                               value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Level <span style="color:red;">*</span></label>
                        <select name="level" id="addLevel" onchange="toggleAddFields()" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="admin"  {{ old('level') == 'admin'  ? 'selected' : '' }}>Admin</option>
                            <option value="siswa"  {{ old('level') == 'siswa'  ? 'selected' : '' }}>Siswa</option>
                        </select>
                    </div>
                </div>

                <hr class="divider">

                {{-- Field khusus ADMIN --}}
                <div id="addFieldAdmin" class="field-admin">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Username <span style="color:red;">*</span></label>
                            <input type="text" name="username" id="addUsername"
                                   placeholder="Contoh: admin_budi" value="{{ old('username') }}">
                        </div>
                        <div class="form-group">
                            <label>Email <span style="color:red;">*</span></label>
                            <input type="email" name="email" id="addEmail"
                                   placeholder="Contoh: admin@sekolah.id" value="{{ old('email') }}">
                        </div>
                    </div>
                </div>

                {{-- Field khusus SISWA --}}
                <div id="addFieldSiswa" class="field-siswa">
                    <div class="form-row">
                        <div class="form-group">
                            <label>NIS <span style="color:red;">*</span></label>
                            <input type="text" name="nis_nip" id="addNisNip"
                                   placeholder="Contoh: 2024001" value="{{ old('nis_nip') }}">
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas" placeholder="Contoh: XII RPL 1"
                                   value="{{ old('kelas') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email <small style="font-weight:400;">(opsional)</small></label>
                        <input type="email" name="email" placeholder="Contoh: siswa@gmail.com"
                               value="{{ old('email') }}">
                    </div>
                </div>

                <hr class="divider">

                {{-- Baris terakhir: Telepon + Password --}}
                <div class="form-row">
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="telp" placeholder="Contoh: 08123456789"
                               value="{{ old('telp') }}">
                    </div>
                    <div class="form-group">
                        <label>Password <span style="color:red;">*</span></label>
                        <input type="password" name="password" placeholder="Min. 8 karakter" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i data-lucide="save"></i> Simpan User
                </button>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
         MODAL EDIT USER
    ══════════════════════════════════════════════ --}}
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i data-lucide="pencil"></i> Edit User</h3>
                <span class="close-btn" onclick="closeEditModal()">&times;</span>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap <span style="color:red;">*</span></label>
                        <input type="text" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Level <span style="color:red;">*</span></label>
                        <select id="editLevel" name="level" onchange="toggleEditFields()" required>
                            <option value="admin">Admin</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>
                </div>

                <hr class="divider">

                <div id="editFieldAdmin" style="display:none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Username <span style="color:red;">*</span></label>
                            <input type="text" id="editUsername" name="username">
                        </div>
                        <div class="form-group">
                            <label>Email <span style="color:red;">*</span></label>
                            <input type="email" id="editEmail" name="email">
                        </div>
                    </div>
                </div>

                <div id="editFieldSiswa" style="display:none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label>NIS <span style="color:red;">*</span></label>
                            <input type="text" id="editNisNip" name="nis_nip">
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" id="editKelas" name="kelas">
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <div class="form-row">
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" id="editTelp" name="telp">
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
                        <small>Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i data-lucide="save"></i> Update User
                </button>
            </form>
        </div>
    </div>

    <script>lucide.createIcons();</script>
    <script>
        function toggleAddFields() {
            const level = document.getElementById('addLevel').value;

            const adminDiv = document.getElementById('addFieldAdmin');
            const siswaDiv = document.getElementById('addFieldSiswa');

            adminDiv.style.display = level === 'admin' ? 'block' : 'none';
            siswaDiv.style.display = level === 'siswa' ? 'block' : 'none';

            document.getElementById('addUsername').required = (level === 'admin');
            document.getElementById('addEmail').required    = (level === 'admin');
            document.getElementById('addNisNip').required   = (level === 'siswa');
        }

        function toggleEditFields() {
            const level = document.getElementById('editLevel').value;
            document.getElementById('editFieldAdmin').style.display = level === 'admin' ? 'block' : 'none';
            document.getElementById('editFieldSiswa').style.display = level === 'siswa' ? 'block' : 'none';

            document.getElementById('editUsername').required = (level === 'admin');
            document.getElementById('editEmail').required    = (level === 'admin');
            document.getElementById('editNisNip').required   = (level === 'siswa');
        }

        function showAddModal() {
            document.getElementById('addModal').classList.add('show');
            toggleAddFields();
        }
        function closeAddModal() {
            document.getElementById('addModal').classList.remove('show');
        }

        function showEditModal(id, name, level, nisNip, username, email, kelas, telp) {
            document.getElementById('editForm').action = '{{ url("admin/users") }}/' + id;
            document.getElementById('editName').value    = name;
            document.getElementById('editLevel').value   = level;
            document.getElementById('editNisNip').value  = nisNip;
            document.getElementById('editUsername').value = username;
            document.getElementById('editEmail').value   = email;
            document.getElementById('editKelas').value   = kelas;
            document.getElementById('editTelp').value    = telp;
            toggleEditFields();
            document.getElementById('editModal').classList.add('show');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.remove('show');
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('addModal'))  closeAddModal();
            if (event.target == document.getElementById('editModal')) closeEditModal();
        }

        @if($errors->any())
        showAddModal();
        @endif

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