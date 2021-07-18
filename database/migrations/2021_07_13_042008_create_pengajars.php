<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Pengajar;

class CreatePengajars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajars', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengajar',100);
            $table->string('foto_pengajar',200)->default('default.jpg');
            $table->string('keterangan_pengajar',200)->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        Pengajar::insert([
            [
                'nama_pengajar' => 'Miss Kung Lao',
                'keterangan_pengajar' => 'Miss Kung Lao From Mortal Kombat',
                'created_at' => date('Y-m-d H:i:s'),
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
        Schema::dropIfExists('pengajars');
    }
}
