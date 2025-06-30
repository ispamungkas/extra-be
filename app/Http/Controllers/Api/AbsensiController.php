<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // Input absensi (oleh pembina)
    public function store(Request $request)
{
    $request->validate([
        'pembina_id' => 'required|exists:users,id',
        'eskul_id' => 'required|exists:eskuls,id',
        'siswa_id' => 'required|exists:users,id',
        'tanggal' => 'required|date',
        'status' => 'required|in:hadir,alfa,izin,sakit',
    ]);

    $pembina = User::find($request->pembina_id);
    if (!$pembina || $pembina->role !== 'pembina') {
        return response()->json(['message' => 'Hanya pembina yang dapat menginput absensi'], 403);
    }

    // Cek apakah pembina adalah pembina eskul tersebut
    if ($pembina->id !== \App\Models\Eskul::find($request->eskul_id)?->pembina_id) {
        return response()->json(['message' => 'Anda bukan pembina dari eskul ini'], 403);
    }

    $absensi = Absensi::create([
        'eskul_id' => $request->eskul_id,
        'siswa_id' => $request->siswa_id,
        'tanggal' => $request->tanggal,
        'status' => $request->status,
    ]);

    return response()->json($absensi, 201);
}

    // Lihat absensi siswa (oleh siswa)
    public function show($siswa_id)
    {
        $absensi = Absensi::where('siswa_id', $siswa_id)->with('eskul')->get();
        return response()->json($absensi);
    }

    // Edit absensi (oleh pembina)
    public function update(Request $request, $id)
{
    $request->validate([
        'pembina_id' => 'required|exists:users,id',
        'status' => 'required|in:hadir,alfa,izin,sakit',
        'tanggal' => 'required|date'
    ]);

    $pembina = User::find($request->pembina_id);
    if (!$pembina || $pembina->role !== 'pembina') {
        return response()->json(['message' => 'Hanya pembina yang dapat mengedit absensi'], 403);
    }

    $absensi = Absensi::findOrFail($id);
    $eskul = \App\Models\Eskul::find($absensi->eskul_id);

    if ($eskul->pembina_id !== $pembina->id) {
        return response()->json(['message' => 'Anda bukan pembina dari eskul ini'], 403);
    }

    $absensi->update([
        'tanggal' => $request->tanggal,
        'status' => $request->status
    ]);

    return response()->json($absensi    );
}

    // Hapus absensi (oleh pembina)
    public function destroy(Request $request, $id)
{
    $request->validate([
        'pembina_id' => 'required|exists:users,id'
    ]);

    $pembina = User::find($request->pembina_id);
    if (!$pembina || $pembina->role !== 'pembina') {
        return response()->json(['message' => 'Hanya pembina yang dapat menghapus absensi'], 403);
    }

    $absensi = Absensi::findOrFail($id);
    $eskul = \App\Models\Eskul::find($absensi->eskul_id);

    if ($eskul->pembina_id !== $pembina->id) {
        return response()->json(['message' => 'Anda bukan pembina dari eskul ini'], 403);
    }

    $absensi->delete();

    return response()->json(['message' => 'Absensi berhasil dihapus']);
}
}
