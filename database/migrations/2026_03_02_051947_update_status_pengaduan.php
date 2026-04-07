<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom status menjadi enum baru dengan 4 nilai
        DB::statement("ALTER TABLE pengaduan MODIFY COLUMN status ENUM('0','1','2','3') DEFAULT '0' COMMENT '0=menunggu, 1=diproses, 2=selesai, 3=ditolak'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE pengaduan MODIFY COLUMN status ENUM('0','1','2') DEFAULT '0' COMMENT '0=pending, 1=proses, 2=selesai'");
    }
};