<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('nama_admin',100);
            $table->string('username',50)->unique();
            $table->string('password',200);
            $table->string('email',50)->unique();
            $table->string('phone_number',15)->unique();
            $table->string('line',50)->unique();
            $table->string('wa',15)->unique();
            $table->enum('status',['aktif','ban'])->default('aktif');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
