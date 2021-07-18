<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilePengumumanPendaftaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_pengumuman_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengumuman_pendaftaran');
            $table->foreignId('id_admin');
            $table->string('nama_file',200);
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_pengumuman_pendaftaran');
    }
}
