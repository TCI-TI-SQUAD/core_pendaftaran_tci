<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Prodi;

class CreateProdi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_fakultas');
            $table->string('nama_prodi',50);
            $table->string('keterangan',100);
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        Prodi::insert([
            [
                'id_fakultas' => 1,
                'nama_prodi' => 'Teknologi Informasi',
                'keterangan' => 'Program Studi Teknologi Informasi Fakultas Teknik Universitas Udayana'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prodis');
    }
}
