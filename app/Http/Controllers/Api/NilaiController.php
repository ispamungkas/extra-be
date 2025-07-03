<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\User;
use App\Models\Eskul;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    // Buat nilai (oleh pembina)
    public function store(Request $request)
        {
            $request->validate([
                'pembina_id' => 'required|exists:users,id',
                'siswa_id' => 'required|exists:users,id',
                'eskul_id' => 'required|exists:eskuls,id',
                'tahun_ajaran' => 'required|string',
                'nilai' => 'required'
            ]);

            $pembina = User::find($request->pembina_id);
            if ($pembina->role !== 'pembina') {
                return response()->json(['message' => 'Hanya pembina yang dapat menginput nilai'], 403);
            }

            $eskul = Eskul::with('siswa')->find($request->eskul_id);
            if (!$eskul || $eskul->pembina_id !== $pembina->id) {
                return response()->json(['message' => 'Anda bukan pembina dari eskul ini'], 403);
            }

            $terdaftar = $eskul->siswa->contains('id', $request->siswa_id);
            if (!$terdaftar) {
                return response()->json(['message' => 'Siswa belum terdaftar pada eskul ini'], 422);
            }

            $nilai = Nilai::create([
                'siswa_id' => $request->siswa_id,
                'eskul_id' => $request->eskul_id,
                'tahun_ajaran' => $request->tahun_ajaran,
                'nilai' => $request->nilai,
            ]);

            return response()->json($nilai);
        }

    // Lihat semua nilai untuk siswa tertentu
    public function index($siswa_id)
    {
        $nilai = Nilai::with('eskul')->where('siswa_id', $siswa_id)->get();
        return response()->json($nilai);
    }

    // Edit nilai (oleh pembina dan hanya jika dia membina eskul tersebut)
    public function update(Request $request, $id)
    {
        $request->validate([
            'pembina_id' => 'required|exists:users,id',
            'tahun_ajaran' => 'required|string',
            'nilai' => 'required'
        ]);

        $pembina = User::find($request->pembina_id);
        if ($pembina->role !== 'pembina') {
            return response()->json(['message' => 'Hanya pembina yang dapat mengedit nilai'], 403);
        }

        $nilai = Nilai::findOrFail($id);
        $eskul = Eskul::find($nilai->eskul_id);

        if (!$eskul || $eskul->pembina_id !== $pembina->id) {
            return response()->json(['message' => 'Anda bukan pembina dari eskul ini'], 403);
        }

        $nilai->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'nilai' => $request->nilai
        ]);

        return response()->json([
            'message' => 'Nilai berhasil diubah',
            'data' => $nilai
        ]);
    }
    // Get semua nilai berdasarkan pembina
     public function getNilaiByPembina($pembina_id)
        {
            $pembina = User::find($pembina_id);

            if (!$pembina || $pembina->role !== 'pembina') {
                return response()->json(['message' => 'Hanya pembina yang dapat mengakses data nilai'], 403);
            }

            $eskul = Eskul::where('pembina_id', $pembina_id)->pluck('id');

            if ($eskul->isEmpty()) {
                return response()->json(['message' => 'Pembina belum membina eskul manapun'], 404);
            }

            $nilai = Nilai::with(['siswa', 'eskul'])
                ->whereIn('eskul_id', $eskul)
                ->orderBy('tahun_ajaran', 'desc')
                ->get();

            if ($nilai->isEmpty()) {
                return response()->json(['message' => 'Data nilai tidak ditemukan'], 404);
            }

            return response()->json($nilai);
        }
    // Hapus nilai (oleh pembina dan hanya jika membina eskul terkait)
    public function destroy(Request $request, $id)
    {
        $pembina_id = $request->query('pembina_id'); // dari ?pembina_id=...

        $pembina = User::find($pembina_id);
        if (!$pembina || $pembina->role !== 'pembina') {
            return response()->json(['message' => 'Hanya pembina yang dapat menghapus nilai'], 403);
        }

        $nilai = Nilai::findOrFail($id);
        $eskul = Eskul::find($nilai->eskul_id);

        if (!$eskul || $eskul->pembina_id !== $pembina->id) {
            return response()->json(['message' => 'Anda bukan pembina dari eskul ini'], 403);
        }

        $nilai->delete();

        return response()->json(['message' => 'Nilai berhasil dihapus']);
    }
}
