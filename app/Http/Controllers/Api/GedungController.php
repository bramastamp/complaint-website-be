<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use Illuminate\Http\Request;

class GedungController extends Controller
{
    // GET /api/gedung
    public function index()
    {
        $gedungs = Gedung::with('kelas')->get();
        return response()->json([
            'success' => true,
            'data' => $gedungs
        ]);
    }

    // GET /api/gedung/{id}
    public function show($id)
    {
        $gedung = Gedung::with('kelas')->find($id);

        if (!$gedung) {
            return response()->json(['success' => false, 'message' => 'Gedung not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $gedung]);
    }

    // POST /api/gedung
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gedung' => 'required|string|max:255',
        ]);

        $gedung = Gedung::create($validated);

        return response()->json(['success' => true, 'data' => $gedung], 201);
    }

    // PUT /api/gedung/{id}
    public function update(Request $request, $id)
    {
        $gedung = Gedung::find($id);

        if (!$gedung) {
            return response()->json(['success' => false, 'message' => 'Gedung not found'], 404);
        }

        $gedung->update($request->only('nama_gedung'));

        return response()->json(['success' => true, 'data' => $gedung]);
    }

    // DELETE /api/gedung/{id}
    public function destroy($id)
    {
        $gedung = Gedung::find($id);

        if (!$gedung) {
            return response()->json(['success' => false, 'message' => 'Gedung not found'], 404);
        }

        $gedung->delete();

        return response()->json(['success' => true, 'message' => 'Gedung deleted']);
    }

    // GET /api/gedung/{id}/kelas
    public function kelasByGedung($id)
    {
        $gedung = Gedung::with('kelas')->find($id);

        if (!$gedung) {
            return response()->json(['success' => false, 'message' => 'Gedung not found'], 404);
        }

        return response()->json([
            'success' => true,
            'gedung' => $gedung->nama_gedung,
            'kelas' => $gedung->kelas
        ]);
    }
}
