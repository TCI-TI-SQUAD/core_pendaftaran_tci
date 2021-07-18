<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Sekolah;

class CreateSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tipe_sekolah');
            $table->string('nama_sekolah',50);
            $table->string('keterangan',100);
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        Sekolah::create([
            'id_tipe_sekolah' => 3,
            'nama_sekolah' => 'SMA N 1 Denpasar',
            'keterangan' => 'SMA Kerjasama TCI Universitas Udayana sejak tanggal 2021-01-01',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sekolahs');
    }
}
