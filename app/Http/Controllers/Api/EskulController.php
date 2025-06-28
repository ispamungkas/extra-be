<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Eskul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EskulController extends Controller
{
    // Ambil semua eskul
    public function index()
    {
        $eskuls = Eskul::with('pembina')->get();
        return response()->json($eskuls);
    }

    // Buat eskul (oleh admin)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jadwal' => 'required',
            'pembina_id' => 'required|exists:users,id',
            'tempat' => 'required',
            'admin_id' => 'required|exists:users,id',
            'img' => 'mimes:jpg,png'
        ]);

        $admin = User::find($request->admin_id);
        if (!$admin || $admin->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat membuat eskul'], 403);
        }

        $dir_img = 'images/eskul';
        $folder_img = public_path($dir_img);

        if (!File::exists($folder_img)) {
            File::makeDirectory($folder_img, 0755, true);
        }

        $file_name_img = Str::uuid() . '.png';

        if ($request->hasFile('img')) {
            $request->file('img')->move($folder_img, $file_name_img);
        }

        $img_path = $dir_img . '/' . $file_name_img;
        $eskul = Eskul::create([
            'nama' => $request->nama,
            'jadwal' => $request->jadwal,
            'pembina_id' => $request->pembina_id,
            'tempat' => $request->tempat,
            'img' => $img_path 
        ]);

        return response()->json($eskul, 201);
    }

    // Siswa mendaftar ke eskul
    public function daftarEskul(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'eskul_id' => 'required|exists:eskuls,id',
        ]);

        $eskul = Eskul::find($request->eskul_id);
        $eskul->siswa()->syncWithoutDetaching([$request->siswa_id]);

        return response()->json(['message' => 'Berhasil daftar eskul.']);
    }

    // Liat siswa ayng mendaftar eskul
public function siswaEskul($eskul_id)
{
    $eskul = \App\Models\Eskul::with(['siswa', 'pembina'])->find($eskul_id);

    if (!$eskul) {
        return response()->json(['message' => 'Eskul tidak ditemukan'], 404);
    }

    return response()->json([
        'eskul_id' => $eskul->id,
        'nama' => $eskul->nama,
        'jadwal' => $eskul->jadwal,
        'tempat' => $eskul->tempat,
        'pembina' => [
            'id' => $eskul->pembina->id ?? null,
            'name' => $eskul->pembina->name ?? '-',
            'no_telpon' => $eskul->pembina->no_telpon ?? '-',
        ],
        'jumlah_siswa' => $eskul->siswa->count(),
        'siswa' => $eskul->siswa->map(function ($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'nisn' => $s->nisn,
                'kelas' => $s->kelas,
                'no_telpon' => $s->no_telpon,
            ];
        }),
    ]);
}

    // Edit eskul (oleh admin)
    public function update(Request $request, $id)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
            'nama' => 'required',
            'jadwal' => 'required',
            'pembina_id' => 'required|exists:users,id',
            'tempat' => 'required',
            'img' => 'mimes:jpg,png'
        ]);

        $admin = User::find($request->admin_id);
        $eskul = Eskul::findOrFail($id);

        if (!$admin || $admin->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat mengedit eskul'], 403);
        }

        if ($request->hasFile('img')) {
            $dir_img = 'images/eskul';
            $folder_img = public_path($dir_img);

            if (!File::exists($folder_img)) {
                File::makeDirectory($folder_img, 0755, true);
            }

            if ($eskul->img && File::exists(public_path($eskul->img))) {
                File::delete(public_path($eskul->img));
            }

            $file_name_img = Str::uuid() . '.png';

            $request->file('img')->move($folder_img, $file_name_img);

            $eskul->img = $dir_img . '/' . $file_name_img;
        }

        $eskul->update([
            'nama' => $request->nama,
            'jadwal' => $request->jadwal,
            'pembina_id' => $request->pembina_id,
            'tempat' => $request->tempat,
            'img' => $eskul->img
        ]);

        return response()->json(['message' => 'Eskul berhasil diupdate', 'data' => $eskul]);
    }

    public function destroy(Request $request, $id)
    {
        $admin_id = $request->query('admin_id');
        $admin = User::find($admin_id);
        if (!$admin || $admin->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat menghapus eskul'], 403);
        }

        $eskul = Eskul::find($id);
        if (!$eskul) {
            return response()->json(['message' => 'Eskul tidak ditemukan'], 404);
        }

        $eskul->delete();

        return response()->json(['message' => 'Eskul berhasil dihapus']);
    }
}
