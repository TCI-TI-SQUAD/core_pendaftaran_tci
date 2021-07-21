<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Transaksi;

class CreateTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_admin')->nullable();
            $table->foreignId('id_detail_kelas');
            $table->string('nama_kelas',100);
            $table->string('nama_pendaftaran',100);
            $table->string('nomor_transaksi_struct');
            $table->integer('total_pembayaran');
            $table->string('file_bukti_transaksi',200)->nullable();
            $table->string('file_struct_pembayaran',200)->nullable();
            $table->string('nama_pemesan',100);
            $table->string('nomor_pelajar_tci',100);
            $table->datetime('tanggal_cetak_struct')->nullable();
            $table->datetime('tanggal_expired');
            $table->date('tanggal_mulai_kelas');
            $table->date('tanggal_selesai_kelas');
            $table->enum('status',['dibatalkan_user','expired_system','ditolak_admin','memilih_metode_pembayaran','menunggu_pembayaran','menunggu_konfirmasi','lunas']);
            $table->string('keterangan_pembayaran_user',100)->nullable();
            $table->string('keterangan_tambahan_in_struct',200)->nullable();
            $table->string('keterangan_tambahan_out_struct',200)->nullable();
            $table->string('menyetujui_admin',100)->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        Transaksi::insert([
            [
            'id_detail_kelas' => 1,
            'nama_kelas' => 'Kelas Mandarin For Children',
            'nama_pendaftaran' => 'TCI International Class Batch A',
            'nomor_transaksi_struct' => 0001,
            'total_pembayaran' => 120000,
            'file_bukti_transaksi' => 'TCI-UDAYANA-1',
            'file_struct_pembayaran' => 'invoice',
            'nama_pemesan' => 'I Putu Alin Winata Gotama',
            'nomor_pelajar_tci' => 202171800001,
            'tanggal_cetak_struct' => date('Y-m-d'),
            'tanggal_expired' => '2021-07-25',
            'tanggal_mulai_kelas' => '2021-01-01',
            'tanggal_selesai_kelas' => '2021-01-07',
            'status' => 'menunggu_pembayaran',
            'keterangan_pembayaran_user' => 'halo',
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
        Schema::dropIfExists('transaksis');
    }
}
