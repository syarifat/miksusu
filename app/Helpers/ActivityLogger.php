<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Catat aktivitas ke database.
     *
     * @param string $aksi       Jenis aksi: login, logout, create, update, delete, export, toggle
     * @param string $modul      Nama modul: auth, produk, lapak, pos, keuangan, laporan, profil
     * @param string $deskripsi  Deskripsi singkat aktivitas
     * @param array|null $dataLama  Data sebelum perubahan (untuk update/delete)
     * @param array|null $dataBaru  Data setelah perubahan (untuk create/update)
     */
    public static function log(
        string $aksi,
        string $modul,
        string $deskripsi,
        ?array $dataLama = null,
        ?array $dataBaru = null
    ): void {
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => $aksi,
            'modul'      => $modul,
            'deskripsi'  => $deskripsi,
            'data_lama'  => $dataLama,
            'data_baru'  => $dataBaru,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
