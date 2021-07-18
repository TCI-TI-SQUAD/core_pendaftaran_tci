<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\KelasKerjasama;

class CreateKelasKerjasamas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas_kerjasamas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kelas');
            $table->foreignId('id_instansi');
            $table->enum('status',['umum','siswa','mahasiswa','instansi']);
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        KelasKerjasama::insert([
            [
                'id_kelas' => 1,
                'id_instansi' => 0,
                'status' => 'umum',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_kelas' => 1,
                'id_instansi' => 1,
                'status' => 'mahasiswa',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_kelas' => 2,
                'id_instansi' => 1,
                'status' => 'mahasiswa',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_kelas' => 3,
                'id_instansi' => 1,
                'status' => 'mahasiswa',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas_kerjasamas');
    }
}
