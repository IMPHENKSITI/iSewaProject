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
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->string('jenis_hasil_panen'); 
            $table->decimal('jumlah', 10, 2); 
            $table->string('satuan')->default('kg'); 
            $table->decimal('harga_jual', 12, 2); 
            $table->date('tanggal_panen');
            $table->string('lokasi_lahan');
            $table->enum('status', ['tersedia', 'dijual', 'diproses'])->default('tersedia');
            $table->string('foto')->nullable(); // Gambar hasil panen
            $table->timestamps();

            
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