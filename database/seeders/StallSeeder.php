<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stall;
use Carbon\Carbon;

class StallSeeder extends Seeder
{
    public function run(): void
    {
        Stall::create([
            'tanggal' => Carbon::today(),
            'tempat' => 'Alun-Alun',
            'status' => 'aktif',
        ]);
    }
}