<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest('created_at');

        // Filter by modul
        if ($request->filled('modul')) {
            $query->where('modul', $request->modul);
        }

        // Filter by aksi
        if ($request->filled('aksi')) {
            $query->where('aksi', $request->aksi);
        }

        // Filter by tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by search keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $logs = $query->paginate(25)->withQueryString();

        // Data untuk dropdown filter
        $modulList = ['auth', 'produk', 'lapak', 'pos', 'keuangan', 'laporan', 'profil'];
        $aksiList = ['login', 'logout', 'create', 'update', 'delete', 'export', 'toggle'];

        return view('activity-logs.index', compact('logs', 'modulList', 'aksiList'));
    }
}
