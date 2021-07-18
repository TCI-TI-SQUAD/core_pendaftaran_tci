<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\PengaturanSistem;

class CreatePengaturanSistems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_sistems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_admin')->nullable();
            $table->string('nama_pengaturan',50);
            $table->string('keterangan',200);
            $table->string('pengaturan',200)->nullable();
            $table->boolean('status')->default(1)->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        PengaturanSistem::insert([
            [
                'nama_pengaturan' => 'open_registration',
                'keterangan' => 'Menentukan apakah sistem menerima anggota baru atau tidak'
            ],
            [
                'nama_pengaturan' => 'open_login',
                'keterangan' => 'Menentukan apakah sistem memberikan akses masuk / login'
            ],
            [
                'nama_pengaturan' => 'open_pendaftaran',
                'keterangan' => 'Izin untuk peserta mendaftar ke dalam kelas, Kelas akan tetap dapat dilihat apabila pengaturan ini nonaktif'
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
        Schema::dropIfExists('pengaturan_sistems');
    }
}
