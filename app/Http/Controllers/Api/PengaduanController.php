<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;  // ← WAJIB ADA
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengaduan;


class PengaduanController extends Controller
{
    // =======================
    // 1. GET ALL (Admin)
    // =======================
    public function index()
    {
        return response()->json(Pengaduan::with(['user', 'kategori'])->get());
    }

    // =======================
    // 2. GET PENGADUAN USER LOGIN
    // =======================
    public function myPengaduan()
    {
        return response()->json(
            Pengaduan::where('user_id', Auth::id())->with(['kategori'])->get()
        );
    }

    // =======================
    // 3. CREATE PENGADUAN
    // =======================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori_id' => 'required|exists:kategori_pengaduans,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $pengaduan = new Pengaduan();
        $pengaduan->user_id = Auth::id();
        $pengaduan->judul = $validated['judul'];
        $pengaduan->isi = $validated['isi'];
        $pengaduan->kategori_id = $validated['kategori_id'];

        // Upload gambar bila ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar')->store('pengaduan', 'public');
            $pengaduan->gambar = $file;
        }

        $pengaduan->save();

        return response()->json([
            'message' => 'Pengaduan berhasil dibuat',
            'data' => $pengaduan
        ], 201);
    }

    // =======================
    // 4. UPDATE PENGADUAN
    // =======================
    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // HANYA PEMILIK YANG BOLEH EDIT (ADMIN TIDAK BOLEH)
        if ($user->role === 'admin' || $user->id !== $pengaduan->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'judul' => 'sometimes|string|max:255',
            'isi' => 'sometimes|string',
            'kategori_id' => 'sometimes|exists:kategori_pengaduans,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $pengaduan->fill($validated);

        // Jika ganti gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($pengaduan->gambar) {
                Storage::disk('public')->delete($pengaduan->gambar);
            }

            $file = $request->file('gambar')->store('pengaduan', 'public');
            $pengaduan->gambar = $file;
        }

        $pengaduan->save();

        return response()->json([
            'message' => 'Pengaduan berhasil diupdate',
            'data' => $pengaduan
        ]);
    }

    // =======================
    // 5. DELETE PENGADUAN
    // =======================
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Hanya pemilik yang boleh hapus (admin juga dilarang)
        if ($user->role === 'admin' || $user->id !== $pengaduan->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Hapus gambar jika ada
        if ($pengaduan->gambar) {
            Storage::disk('public')->delete($pengaduan->gambar);
        }

        $pengaduan->delete();

        return response()->json([
            'message' => 'Pengaduan berhasil dihapus'
        ]);
    }
    // =======================
// 6. SHOW DETAIL PENGADUAN
// =======================
public function show($id)
{
    $pengaduan = Pengaduan::with(['user', 'kategori'])->find($id);

    if (!$pengaduan) {
        return response()->json(['message' => 'Pengaduan tidak ditemukan'], 404);
    }

    return response()->json($pengaduan);
}

}
