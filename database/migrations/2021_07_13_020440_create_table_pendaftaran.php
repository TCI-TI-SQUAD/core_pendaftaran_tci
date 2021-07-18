<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Pendaftaran;

class CreateTablePendaftaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pendaftaran',50)->unique();
            $table->datetime('tanggal_mulai_pendaftaran');
            $table->datetime('tanggal_selesai_pendaftaran');
            $table->enum('status',['aktif','tidak'])->default('aktif');
            $table->string('keterangan',200)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Pendaftaran::insert([
            [
                'nama_pendaftaran' => 'TCI International Class Batch A',
                'tanggal_mulai_pendaftaran' => '2021-07-17 00:00:00',
                'tanggal_selesai_pendaftaran' => '2021-08-18 00:00:00',
                'status' => 'aktif',
                'keterangan' => 'Kelas kerjasama International',
            ],
            [
                'nama_pendaftaran' => 'TCI International Class Batch B',
                'tanggal_mulai_pendaftaran' => '2021-07-17 00:00:00',
                'tanggal_selesai_pendaftaran' => '2021-08-18 00:00:00',
                'status' => 'aktif',
                'keterangan' => 'Kelas kerjasama International',
            ],
            [
                'nama_pendaftaran' => 'TCI International Class Batch C',
                'tanggal_mulai_pendaftaran' => '2021-07-17 00:00:00',
                'tanggal_selesai_pendaftaran' => '2021-08-18 00:00:00',
                'status' => 'aktif',
                'keterangan' => 'Kelas kerjasama International',
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
        Schema::dropIfExists('pendaftarans');
    }
}
