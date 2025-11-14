<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_sewa', 12, 2);
            $table->integer('stok');
            $table->enum('status', ['tersedia', 'disewa', 'rusak']);
            $table->string('kategori')->nullable(); // Misalnya: 'Per lengkapan Acara'
            $table->string('foto')->nullable(); // Path gambar utama
            $table->string('foto_2')->nullable(); // Path gambar kedua
            $table->string('foto_3')->nullable(); // Path gambar ketiga
            $table->string('lokasi')->nullable(); // Misalnya: 'Desa Pematang Duku Timur'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
}