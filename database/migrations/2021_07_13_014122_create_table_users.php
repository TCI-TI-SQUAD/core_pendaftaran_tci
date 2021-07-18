<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

use App\User;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_instansi');
            $table->enum('status',['umum','siswa','mahasiswa','instansi']);
            $table->enum('hsk',['pemula','hsk 1','hsk 2','hsk 3','hsk 4','hsk 5','hsk 6']);
            $table->string('name',100);
            $table->string('nomor_pelajar_tci',100)->unique();
            $table->string('username',100)->unique();
            $table->string('password',200);
            $table->string('email',50)->unique();
            $table->string('phone_number',15)->unique();
            $table->string('line',50)->unique();
            $table->string('wa',15)->unique();
            $table->string('user_profile_pict',200)->nullable()->default('default.jpg');
            $table->string('kartu_identitas',200);
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('hak_akses',['aktif','ban'])->default('aktif');
            $table->enum('favorite',['tidak','iya'])->default('tidak');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        User::create([
            'id_instansi' => 1,
            'status' => 'mahasiswa',
            'hsk' => 'pemula',
            'name' => 'I Putu Alin Winata Gotama',
            'nomor_pelajar_tci' => '2021210001',
            'username' => 'alsan',
            'password' => Hash::make('alsan4154'),
            'email' => 'alingotama@gmail.com',
            'phone_number' => '081246082357',
            'line' => 'alsan4154',
            'wa' => '081246082357',
            'kartu_identitas' => 'halo',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
