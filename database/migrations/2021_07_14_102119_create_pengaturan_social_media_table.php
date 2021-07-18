<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\PengaturanSocialMedia;

class CreatePengaturanSocialMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_social_media', function (Blueprint $table) {
            $table->id();
            $table->string('nama_social_media',50);
            $table->string('link',100);
            $table->string('keterangan',200);
            $table->string('social_media_image',200);
            $table->timestamps();
            $table->softDeletes('deleted_at',0);
        });

        PengaturanSocialMedia::insert([
            [
                'nama_social_media' => 'instagram',
                'link' => 'https://www.instagram.com/tci_udayana/',
                'social_media_image' => 'logo-ig.png',
                'keterangan' => 'Akun Instagram resmi Instagram Tourism Confucius Institute Universitas Udayana'
            ],
            [
                'nama_social_media' => 'facebook',
                'link' => 'https://www.facebook.com/Tourism-Confucius-Institute-Udayana-University-111845277177762/',
                'social_media_image' => 'logo-fb.png',
                'keterangan' => 'Akun Facebook resmi Instagram Tourism Confucius Institute Universitas Udayana'
            ],
            [
                'nama_social_media' => 'Twitter',
                'link' => 'https://twitter.com/tciudayana',
                'social_media_image' => 'logo-twitter.png',
                'keterangan' => 'Akun Facebook resmi Instagram Tourism Confucius Institute Universitas Udayana'
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
        Schema::dropIfExists('pengaturan_social_media');
    }
}
