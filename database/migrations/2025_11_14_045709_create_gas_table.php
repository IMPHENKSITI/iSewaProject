<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Jika diperlukan relasi ke user
            $table->string('jenis_gas'); // Misalnya: '3 kg', '5,5 kg'
            $table->decimal('harga_satuan', 12, 2);
            $table->integer('jumlah_tabung');
            $table->decimal('harga_total', 12, 2); // Harga total = harga_satuan * jumlah_tabung
            $table->integer('stok'); // Stok tersedia
            $table->enum('status', ['tersedia', 'dipesan', 'rusak']); // Status gas
            $table->string('foto')->nullable(); // Path gambar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas');
    }
}