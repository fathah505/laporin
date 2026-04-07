<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\Tanggapan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display dashboard
     */
    public function index()
    {
        $pengaduan = Pengaduan::with(['user', 'kategori', 'tanggapan'])
            ->latest()
            ->take(10)
            ->get();

        $totalPengaduan = Pengaduan::count();
        $pending        = Pengaduan::where('status', '0')->count();
        $proses         = Pengaduan::where('status', '1')->count();
        $selesai        = Pengaduan::where('status', '2')->count();
        $ditolak        = Pengaduan::where('status', '3')->count();
        $totalSiswa     = User::where('level', 'siswa')->count();

        $kategoriStats = Kategori::withCount('pengaduan')
            ->orderBy('pengaduan_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pengaduan', 'totalPengaduan', 'pending',
            'proses', 'selesai', 'ditolak', 'totalSiswa', 'kategoriStats'
        ));
    }

    /**
     * Display all pengaduan
     */
    public function pengaduan(Request $request)
    {
        $query = Pengaduan::with(['user', 'kategori', 'tanggapan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_laporan', 'like', "%{$search}%")
                  ->orWhere('isi_laporan', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $pengaduan = $query->latest()->paginate(10);
        $kategoris = Kategori::all();

        return view('admin.pengaduan.index', compact('pengaduan', 'kategoris'));
    }

    /**
     * Show pengaduan detail
     */
    public function showPengaduan($id)
    {
        $pengaduan = Pengaduan::with(['user', 'kategori', 'tanggapan.admin'])
            ->findOrFail($id);

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Terima pengaduan → status menjadi "Diproses" (1)
     */
    public function terimaPengaduan(Request $request, $id)
    {
        $request->validate([
            'tanggapan' => 'required|string|min:5',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        // Hanya bisa diterima jika status masih menunggu
        if ($pengaduan->status != '0') {
            return redirect()->back()->with('error', 'Pengaduan ini tidak dapat diterima karena statusnya bukan "Menunggu".');
        }

        // Simpan / update tanggapan
        Tanggapan::updateOrCreate(
            ['pengaduan_id' => $pengaduan->id],
            [
                'admin_id'      => Auth::id(),
                'tanggapan'     => $request->tanggapan,
                'tgl_tanggapan' => now(),
            ]
        );

        $pengaduan->update(['status' => '1']);

        return redirect()->route('admin.pengaduan')->with('success', 'Pengaduan berhasil diterima dan sedang diproses.');
    }

    /**
     * Tolak pengaduan → status menjadi "Ditolak" (3)
     */
    public function tolakPengaduan(Request $request, $id)
    {
        $request->validate([
            'tanggapan' => 'required|string|min:5',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        // Hanya bisa ditolak jika status masih menunggu
        if ($pengaduan->status != '0') {
            return redirect()->back()->with('error', 'Pengaduan ini tidak dapat ditolak karena statusnya bukan "Menunggu".');
        }

        Tanggapan::updateOrCreate(
            ['pengaduan_id' => $pengaduan->id],
            [
                'admin_id'      => Auth::id(),
                'tanggapan'     => $request->tanggapan,
                'tgl_tanggapan' => now(),
            ]
        );

        $pengaduan->update(['status' => '3']);

        return redirect()->route('admin.pengaduan')->with('success', 'Pengaduan telah ditolak.');
    }

    /**
     * Selesaikan pengaduan → status menjadi "Selesai" (2)
     */
    public function selesaikanPengaduan(Request $request, $id)
    {
        $request->validate([
            'tanggapan' => 'nullable|string',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        // Hanya bisa diselesaikan jika status sedang diproses
        if ($pengaduan->status != '1') {
            return redirect()->back()->with('error', 'Pengaduan ini tidak dapat diselesaikan karena statusnya bukan "Diproses".');
        }

        // Update tanggapan jika diisi
        if ($request->filled('tanggapan') && $pengaduan->tanggapan) {
            $pengaduan->tanggapan->update([
                'tanggapan'     => $request->tanggapan,
                'tgl_tanggapan' => now(),
            ]);
        }

        $pengaduan->update(['status' => '2']);

        return redirect()->route('admin.pengaduan')->with('success', 'Pengaduan telah diselesaikan.');
    }

    /**
     * Store tanggapan (tetap ada untuk kompatibilitas)
     */
    public function storeTanggapan(Request $request)
    {
        $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,id',
            'tanggapan'    => 'required|string',
        ]);

        Tanggapan::updateOrCreate(
            ['pengaduan_id' => $request->pengaduan_id],
            [
                'admin_id'      => Auth::id(),
                'tanggapan'     => $request->tanggapan,
                'tgl_tanggapan' => now(),
            ]
        );

        $pengaduan = Pengaduan::find($request->pengaduan_id);
        if ($pengaduan->status == '0') {
            $pengaduan->update(['status' => '1']);
        }

        return redirect()->back()->with('success', 'Tanggapan berhasil ditambahkan!');
    }

    /**
     * Display kategori management
     */
    public function kategori()
    {
        $kategoris = Kategori::withCount('pengaduan')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori']);
        Kategori::create(['nama_kategori' => $request->nama_kategori]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $id]);
        Kategori::findOrFail($id)->update(['nama_kategori' => $request->nama_kategori]);
        return redirect()->back()->with('success', 'Kategori berhasil diupdate!');
    }

    public function deleteKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        if ($kategori->pengaduan()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki pengaduan!');
        }
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }

    /**
     * Display user management
     */
    public function users(Request $request)
    {
        $query = User::query();
        if ($request->filled('level'))  $query->where('level', $request->level);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%")
                ->orWhere('nis_nip', 'like', "%{$s}%"));
        }
        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'level'    => 'required|in:admin,siswa',
            'telp'     => 'nullable|string|max:20',
            'kelas'    => 'nullable|string|max:50',
            'email'    => 'nullable|email|unique:users,email',
        ];

        if ($request->level == 'admin') {
            $rules['username'] = 'required|string|max:100|unique:users,username';
        } else {
            $rules['nis_nip'] = 'required|string|max:50|unique:users,nis_nip';
        }

        $request->validate($rules);

        $data = [
            'name'     => $request->name,
            'password' => Hash::make($request->password),
            'level'    => $request->level,
            'telp'     => $request->telp    ?: null,
            'email'    => $request->email   ?: null,
            'kelas'    => $request->kelas   ?: null,
        ];

        if ($request->level == 'admin') {
            $data['username'] = $request->username;
        } else {
            $data['nis_nip'] = $request->nis_nip;
        }

        User::create($data);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $user  = User::findOrFail($id);
        $rules = [
            'name'     => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'level'    => 'required|in:admin,siswa',
            'telp'     => 'nullable|string|max:20',
        ];
        if ($request->level == 'admin') {
            $rules['username'] = 'required|string|unique:users,username,' . $id;
            $rules['email']    = 'required|email|unique:users,email,' . $id;
        } else {
            $rules['nis_nip']  = 'required|string|unique:users,nis_nip,' . $id;
            $rules['email']    = 'nullable|email|unique:users,email,' . $id;
        }
        $request->validate($rules);

        $data = ['name' => $request->name, 'level' => $request->level, 'telp' => $request->telp];
        if ($request->level == 'admin') {
            $data['username'] = $request->username;
            $data['email']    = $request->email;
            $data['nis_nip']  = $request->nis_nip ?? $user->nis_nip;
        } else {
            $data['nis_nip']  = $request->nis_nip;
            $data['email']    = $request->email;
            $data['username'] = null;
        }
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->back()->with('success', 'User berhasil diupdate!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }
        if ($user->pengaduan()->count() > 0) {
            return redirect()->back()->with('error', 'User tidak dapat dihapus karena memiliki riwayat pengaduan!');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }

    /**
     * Display laporan
     */
    public function laporan(Request $request)
    {
        $query = Pengaduan::with(['user', 'kategori', 'tanggapan']);

        if ($request->filled('start_date'))  $query->whereDate('tgl_pengaduan', '>=', $request->start_date);
        if ($request->filled('end_date'))    $query->whereDate('tgl_pengaduan', '<=', $request->end_date);
        if ($request->filled('status'))      $query->where('status', $request->status);
        if ($request->filled('kategori_id')) $query->where('kategori_id', $request->kategori_id);

        $pengaduan      = $query->latest()->get();
        $kategoris      = Kategori::all();
        $totalPengaduan = $pengaduan->count();
        $pending        = $pengaduan->where('status', '0')->count();
        $proses         = $pengaduan->where('status', '1')->count();
        $selesai        = $pengaduan->where('status', '2')->count();
        $ditolak        = $pengaduan->where('status', '3')->count();
        $totalSiswa     = User::where('level', 'siswa')->count();
        $totalKategori  = Kategori::count();

        $topKategori = Kategori::withCount('pengaduan')
            ->orderBy('pengaduan_count', 'desc')
            ->take(5)
            ->get();

        $pengaduanPerBulan = Pengaduan::selectRaw('MONTH(tgl_pengaduan) as bulan, COUNT(*) as total')
            ->whereYear('tgl_pengaduan', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('admin.laporan.index', compact(
            'pengaduan', 'kategoris', 'totalPengaduan',
            'pending', 'proses', 'selesai', 'ditolak',
            'totalSiswa', 'totalKategori', 'topKategori', 'pengaduanPerBulan'
        ));
    }

    /**
     * Export laporan ke CSV — tidak butuh library tambahan
     */
    public function exportLaporan(Request $request)
    {
        $query = Pengaduan::with(['user', 'kategori', 'tanggapan.admin']);

        // Filter opsional (diteruskan dari halaman laporan)
        if ($request->filled('start_date')) {
            $query->whereDate('tgl_pengaduan', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tgl_pengaduan', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $data = $query->latest()->get();

        // Label status
        $statusLabel = ['0' => 'Menunggu', '1' => 'Diproses', '2' => 'Selesai', '3' => 'Ditolak'];

        // Nama file dengan timestamp
        $filename = 'laporan_pengaduan_' . date('Ymd_His') . '.csv';

        // Stream CSV langsung ke browser
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($data, $statusLabel) {
            $handle = fopen('php://output', 'w');

            // BOM agar Excel bisa baca UTF-8 dengan benar
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header kolom
            fputcsv($handle, [
                'No',
                'ID Pengaduan',
                'Tanggal Pengaduan',
                'Nama Siswa',
                'NIS',
                'Kelas',
                'Kategori',
                'Judul Laporan',
                'Isi Laporan',
                'Status',
                'Tanggapan Admin',
                'Admin',
                'Tanggal Tanggapan',
            ]);

            // Baris data
            foreach ($data as $i => $item) {
                fputcsv($handle, [
                    $i + 1,
                    str_pad($item->id, 4, '0', STR_PAD_LEFT),
                    \Carbon\Carbon::parse($item->tgl_pengaduan)->format('d/m/Y H:i'),
                    $item->user->name ?? '-',
                    $item->user->nis_nip ?? '-',
                    $item->user->kelas ?? '-',
                    $item->kategori->nama_kategori ?? '-',
                    $item->judul_laporan,
                    $item->isi_laporan,
                    $statusLabel[$item->status] ?? '-',
                    $item->tanggapan->tanggapan ?? '-',
                    $item->tanggapan->admin->name ?? '-',
                    $item->tanggapan
                        ? \Carbon\Carbon::parse($item->tanggapan->tgl_tanggapan)->format('d/m/Y H:i')
                        : '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}