<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Display dashboard
     */
    public function index()
    {
        $pengaduan = Pengaduan::with(['kategori', 'tanggapan'])
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $totalPengaduan = Pengaduan::where('user_id', Auth::id())->count();
        $pending        = Pengaduan::where('user_id', Auth::id())->where('status', '0')->count();
        $proses         = Pengaduan::where('user_id', Auth::id())->where('status', '1')->count();
        $selesai        = Pengaduan::where('user_id', Auth::id())->where('status', '2')->count();
        $ditolak        = Pengaduan::where('user_id', Auth::id())->where('status', '3')->count(); 

        return view('siswa.dashboard', compact(
            'pengaduan',
            'totalPengaduan',
            'pending',
            'proses',
            'selesai',
            'ditolak'  
        ));
    }

    /**
     * Display all pengaduan milik siswa
     */
    public function pengaduan(Request $request)
    {
        $query = Pengaduan::with(['kategori', 'tanggapan'])
            ->where('user_id', Auth::id());

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by kategori
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul_laporan', 'like', '%' . $request->search . '%')
                  ->orWhere('isi_laporan', 'like', '%' . $request->search . '%');
            });
        }

        $pengaduan = $query->latest()->paginate(10);
        $kategoris = Kategori::all();

        return view('siswa.pengaduan.index', compact('pengaduan', 'kategoris'));
    }

    /**
     * Show create pengaduan form
     */
    public function createPengaduan()
    {
        $kategoris = Kategori::all();
        return view('siswa.pengaduan.create', compact('kategoris'));
    }

    /**
     * Store new pengaduan
     */
    public function storePengaduan(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'judul_laporan' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'user_id' => Auth::id(),
            'kategori_id' => $request->kategori_id,
            'judul_laporan' => $request->judul_laporan,
            'isi_laporan' => $request->isi_laporan,
            'tgl_pengaduan' => now(),
            'status' => '0' // Pending
        ];

        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pengaduan', $filename, 'public');
            $data['foto'] = $path;
        }

        Pengaduan::create($data);

        return redirect()->route('siswa.pengaduan')->with('success', 'Pengaduan berhasil dibuat!');
    }

    /**
     * Show pengaduan detail
     */
    public function showPengaduan($id)
    {
        $pengaduan = Pengaduan::with(['kategori', 'tanggapan.admin'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        
        return view('siswa.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Show edit pengaduan form
     */
    public function editPengaduan($id)
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())->findOrFail($id);
        
        // Hanya bisa edit jika status masih pending
        if ($pengaduan->status != '0') {
            return redirect()->back()->with('error', 'Pengaduan yang sudah diproses tidak dapat diedit!');
        }

        $kategoris = Kategori::all();
        return view('siswa.pengaduan.edit', compact('pengaduan', 'kategoris'));
    }

    /**
     * Update pengaduan
     */
    public function updatePengaduan(Request $request, $id)
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())->findOrFail($id);

        // Hanya bisa edit jika status masih pending
        if ($pengaduan->status != '0') {
            return redirect()->back()->with('error', 'Pengaduan yang sudah diproses tidak dapat diedit!');
        }

        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'judul_laporan' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'kategori_id' => $request->kategori_id,
            'judul_laporan' => $request->judul_laporan,
            'isi_laporan' => $request->isi_laporan,
        ];

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pengaduan->foto) {
                Storage::disk('public')->delete($pengaduan->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pengaduan', $filename, 'public');
            $data['foto'] = $path;
        }

        $pengaduan->update($data);

        return redirect()->route('siswa.pengaduan')->with('success', 'Pengaduan berhasil diupdate!');
    }

    /**
     * Delete pengaduan
     */
    public function deletePengaduan($id)
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())->findOrFail($id);

        // Hanya bisa hapus jika status masih pending
        if ($pengaduan->status != '0') {
            return redirect()->back()->with('error', 'Pengaduan yang sudah diproses tidak dapat dihapus!');
        }

        // Hapus foto jika ada
        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('siswa.pengaduan')->with('success', 'Pengaduan berhasil dihapus!');
    }
}