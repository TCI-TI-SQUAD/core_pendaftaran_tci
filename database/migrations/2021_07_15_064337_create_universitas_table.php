<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Universitas;

class CreateUniversitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_universitas',50)->unique();
            $table->string('keterangan',200);
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        Universitas::insert([
            [
            'nama_universitas' => 'Universitas Udayana',
            'keterangan' => 'Universitas Udayana Bali',
            ],
            [
            'nama_universitas' => 'Universitas Undiksa',
            'keterangan' => 'Universitas Pendidikan Ganesha Bali',
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
        Schema::dropIfExists('universitas');
    }
}
