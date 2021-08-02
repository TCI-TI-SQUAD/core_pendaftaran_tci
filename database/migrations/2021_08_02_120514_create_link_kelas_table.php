<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\LinkKelas;

class CreateLinkKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kelas');
            $table->string('nama_link',50);
            $table->string('icon_link',100);
            $table->string('link',200);
            $table->string('keterangan',200);
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        LinkKelas::insert([
            [
                'id_kelas' => 1,
                'nama_link' => 'link group wa',
                'icon_link' => 'default.png',
                'link' => 'ini linknya bos',
                'keterangan' => 'peserta kelas wajib untuk mengikuti kelas WA melalui link berikut ini'
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
        Schema::dropIfExists('link_kelas');
    }
}
