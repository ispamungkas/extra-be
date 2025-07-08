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
    public function index()
    {
        $eskuls = Eskul::with(['pembina', 'siswa'])->get();
        return response()->json($eskuls);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admin_id'   => 'required|exists:users,id',
            'nama'       => 'required|string|max:255',
            'jadwal'     => 'required|string|max:255',
            'pembina_id' => 'required|exists:users,id',
            'tempat'     => 'required|string|max:255',
            'img'        => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $admin = User::find($validated['admin_id']);
        if (!$admin || $admin->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat membuat eskul'], 403);
        }

        $img_path = null;

        if ($request->hasFile('img')) {
            $dir_img = 'images/eskul';
            $folder_img = public_path($dir_img);

            if (!File::exists($folder_img)) {
                File::makeDirectory($folder_img, 0755, true);
            }

            $file_name = Str::uuid() . '.' . $request->file('img')->getClientOriginalExtension();
            $request->file('img')->move($folder_img, $file_name);
            $img_path = $dir_img . '/' . $file_name;
        }

        $eskul = Eskul::create([
            'nama'       => $validated['nama'],
            'jadwal'     => $validated['jadwal'],
            'pembina_id' => $validated['pembina_id'],
            'tempat'     => $validated['tempat'],
            'img'        => $img_path,
        ]);

        return response()->json([
            'message' => 'Eskul berhasil dibuat',
            'data'    => $eskul
        ], 201);
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

    public function keluarEskul(Request $request)
        {
            $request->validate([
                'siswa_id' => 'required|exists:users,id',
                'eskul_id' => 'required|exists:eskuls,id',
            ]);

            $eskul = Eskul::findOrFail($request->eskul_id);
            
            // Cek apakah siswa memang terdaftar
            if (!$eskul->siswa->contains($request->siswa_id)) {
                return response()->json(['message' => 'Siswa tidak terdaftar pada eskul ini'], 404);
            }

            // Hapus relasi siswa dari eskul
            $eskul->siswa()->detach($request->siswa_id);

            return response()->json(['message' => 'Siswa berhasil keluar dari eskul']);
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
        $validated = $request->validate([
            'admin_id'   => 'required|exists:users,id',
            'nama'       => 'required|string|max:255',
            'jadwal'     => 'required|string|max:255',
            'pembina_id' => 'required|exists:users,id',
            'tempat'     => 'required|string|max:255',
            'img'        => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $admin = User::find($validated['admin_id']);
        $eskul = Eskul::findOrFail($id);

        if (!$admin || $admin->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat mengedit eskul'], 403);
        }

        // Jika ada file baru
        if ($request->hasFile('img')) {
            $dir_img = 'images/eskul';
            $folder_img = public_path($dir_img);

            if (!File::exists($folder_img)) {
                File::makeDirectory($folder_img, 0755, true);
            }

            // Hapus file lama
            if ($eskul->img && File::exists(public_path($eskul->img))) {
                File::delete(public_path($eskul->img));
            }

            $file_name = Str::uuid() . '.' . $request->file('img')->getClientOriginalExtension();
            $request->file('img')->move($folder_img, $file_name);
            $eskul->img = $dir_img . '/' . $file_name;
        }

        // Update nilai lainnya
        $eskul->nama       = $validated['nama'];
        $eskul->jadwal     = $validated['jadwal'];
        $eskul->pembina_id = $validated['pembina_id'];
        $eskul->tempat     = $validated['tempat'];
        $eskul->save();

        return response()->json([
            'message' => 'Eskul berhasil diperbarui',
            'data'    => $eskul
        ]);
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
