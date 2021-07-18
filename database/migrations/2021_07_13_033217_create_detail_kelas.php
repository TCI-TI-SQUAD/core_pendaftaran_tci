<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\DetailKelas;

class CreateDetailKelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kelas');
            $table->foreignId('id_user');
            $table->string('nomor_pelajar_kelas',10);
            $table->string('nilai',10)->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        DetailKelas::insert([
            [
                'id_kelas' => 1,
                'id_user' => 1,
                'nomor_pelajar_kelas' => 01,
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
        Schema::dropIfExists('detail_kelas');
    }
}
