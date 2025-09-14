<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // GET /api/kelas
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Kelas::with('gedung')->get()
        ]);
    }

    // GET /api/kelas/{id}
    public function show($id)
    {
        $kelas = Kelas::with('gedung')->find($id);

        if (!$kelas) {
            return response()->json(['success' => false, 'message' => 'Kelas not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $kelas]);
    }

    // POST /api/kelas
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_gedung' => 'required|exists:gedungs,id',
            'nama_kelas' => 'required|string|max:255',
            'pic' => 'nullable|string|max:255',
            'layout' => 'nullable|string|max:255',
            'standar_operasional' => 'nullable|string|max:255',
        ]);

        $kelas = Kelas::create($validated);

        return response()->json(['success' => true, 'data' => $kelas], 201);
    }

    // PUT /api/kelas/{id}
    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json(['success' => false, 'message' => 'Kelas not found'], 404);
        }

        $kelas->update($request->all());

        return response()->json(['success' => true, 'data' => $kelas]);
    }

    // DELETE /api/kelas/{id}
    public function destroy($id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json(['success' => false, 'message' => 'Kelas not found'], 404);
        }

        $kelas->delete();

        return response()->json(['success' => true, 'message' => 'Kelas deleted']);
    }
}
