<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilPanenTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_panen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Relasi ke user petani
            $table->string('jenis_hasil_panen'); // Misalnya: Padi, Jagung, Ubi, Sawit
            $table->decimal('jumlah', 10, 2); // Dalam satuan ton, kg, dll
            $table->string('satuan')->default('kg'); // Satuan ukuran
            $table->decimal('harga_jual', 12, 2); // Harga total hasil panen
            $table->date('tanggal_panen');
            $table->string('lokasi_lahan');
            $table->enum('status', ['tersedia', 'dijual', 'diproses'])->default('tersedia');
            $table->string('foto')->nullable(); // Gambar hasil panen
            $table->timestamps();

            // Jika user_id digunakan, tambahkan foreign key
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_panen');
    }
}