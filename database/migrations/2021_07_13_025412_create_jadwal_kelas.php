<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\JadwalKelas;

class CreateJadwalKelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kelas');
            $table->enum('hari',['sunday','monday','tuesday','wednesday','thursday','friday','saturday']);
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('keterangan',50)->nullable();
            $table->enum('zona_waktu',['wit','wita','wib'])->default('wita');
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        JadwalKelas::insert([
            [
                'id_kelas' => 1,
                'hari' => 'monday',
                'waktu_mulai' => '15:00:00',
                'waktu_selesai' => '16:00:00',
            ],
            [
                'id_kelas' => 1,
                'hari' => 'wednesday',
                'waktu_mulai' => '15:00:00',
                'waktu_selesai' => '16:00:00',
            ],
            [
                'id_kelas' => 2,
                'hari' => 'monday',
                'waktu_mulai' => '16:30:00',
                'waktu_selesai' => '17:30:00',
            ],
            [
                'id_kelas' => 2,
                'hari' => 'wednesday',
                'waktu_mulai' => '16:30:00',
                'waktu_selesai' => '17:30:00',
            ],
            [
                'id_kelas' => 3,
                'hari' => 'monday',
                'waktu_mulai' => '12:30:00',
                'waktu_selesai' => '13:30:00',
            ],
            [
                'id_kelas' => 3,
                'hari' => 'wednesday',
                'waktu_mulai' => '12:30:00',
                'waktu_selesai' => '13:30:00',
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
        Schema::dropIfExists('jadwal_kelas');
    }
}
