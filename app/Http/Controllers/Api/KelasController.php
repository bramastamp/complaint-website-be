<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        return Kelas::all();
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrfail($id);

        if (auth()->user()->role === 'user' || auth()->id() !== $pengaduan->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'gedung_id' => 'required|exist:gedungs,id',
            'nama_kelas' => 'sometimes|string|max:255',
            'pic' => 'sometimes|string|max:255',
            'standar_operasional' => 'sometimes|string|max:255',
            'layout' => 'sometimes|file|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $kelas->fill($validated);
            if ($request->hasFile('layout')) {
                $path = $request->file('layout')->store('kelas', 'public');
                $kelas->layout = $path;
            }

        return response()->json([
           'message' => 'Kelas berhasil diupdate',
           'data' => $kelas
        ]);
    }

}
