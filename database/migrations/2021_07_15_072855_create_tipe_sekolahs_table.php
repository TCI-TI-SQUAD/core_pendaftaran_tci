<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\TipeSekolah;

class CreateTipeSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipe_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tipe',50);
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        TipeSekolah::insert([
            [
                'nama_tipe' => 'sd',
                'created_at' => now()
            ],
            [
                'nama_tipe' => 'smp',
                'created_at' => now()
            ],
            [
                'nama_tipe' => 'sma',
                'created_at' => now()
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
        Schema::dropIfExists('tipe_sekolahs');
    }
}
