<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user');
            $table->foreignId('id_admin');
            $table->foreignId('id_detail_kelas');
            $table->foreignId('id_metode_pembayaran')->nullable();
            $table->string('pembayaran_kelas',100);
            $table->string('nomor_transaksi_struct');
            $table->integer('total_pembayaran');
            $table->string('file_bukti_transaksi');
            $table->string('file_struct_pembayaran',200)->nullable();
            $table->string('nama_pemesan',100);
            $table->string('nomor_pelajar_tci',100);
            $table->datetime('tanggal_cetak_struct');
            $table->date('tanggal_mulai_kelas');
            $table->date('tanggal_selesai_kelas');
            $table->enum('status',['dibatalkan_user','ditolak_admin','memilih_metode_pembayaran','menunggu_pembayaran','menunggu_konfirmasi','lunas']);
            $table->string('keterangan_pembayaran_user',100);
            $table->string('keterangan_tambahan_in_struct',200);
            $table->string('keterangan_tambahan_out_struct',200);
            $table->string('menyetujui_admin',100);
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
