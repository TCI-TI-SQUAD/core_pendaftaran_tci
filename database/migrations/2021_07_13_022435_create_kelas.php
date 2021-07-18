<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Kelas;

class CreateKelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pendaftaran');
            $table->foreignId('id_pengajar');
            $table->enum('hsk',['pemula','hsk 1','hsk 2','hsk 3','hsk 4','hsk 5','hsk 6']);
            $table->string('nama_kelas',50)->unique();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('isBerbayar');
            $table->integer('harga')->default(0);
            $table->integer('kuota')->default(0);
            $table->enum('status',['buka','tutup']);
            $table->string('logo_kelas',100)->default('default.jpg');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        Kelas::insert([
            [
                'id_pendaftaran' => 1,
                'id_pengajar' => 1,
                'hsk' => 'hsk 1',
                'nama_kelas' => 'Kelas Mandarin For Children',
                'tanggal_mulai' => '2021-07-18',
                'tanggal_selesai' => '2021-08-20',
                'isBerbayar' => 1,
                'harga' => 120000,
                'kuota' => 50,
                'logo_kelas' => 'mandarin_class_1.jpg',
                'status' => 'buka',
            ],
            [
                'id_pendaftaran' => 1,
                'id_pengajar' => 1,
                'hsk' => 'hsk 1',
                'nama_kelas' => 'Kelas B',
                'tanggal_mulai' => '2021-07-18',
                'tanggal_selesai' => '2021-08-20',
                'isBerbayar' => 0,
                'harga' => 0,
                'kuota' => 50,
                'logo_kelas' => 'default.jpg',
                'status' => 'buka',
            ],
            [
                'id_pendaftaran' => 1,
                'id_pengajar' => 1,
                'hsk' => 'hsk 1',
                'nama_kelas' => 'Kelas C',
                'tanggal_mulai' => '2021-07-18',
                'tanggal_selesai' => '2021-08-20',
                'isBerbayar' => 0,
                'harga' => 0,
                'kuota' => 50,
                'logo_kelas' => 'default.jpg',
                'status' => 'buka',
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
        Schema::dropIfExists('kelas');
    }
}
