<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('periode', function (Blueprint $table) {
            $table->bigIncrements('id_periode');
            $table->string('periode');
            $table->string('status');
            $table->decimal('dana',20,2);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('dana_operasional', function (Blueprint $table) {
            $table->bigIncrements('id_dana_operasional');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_periode');
            $table->string('nama_dana');
            $table->string('penanggung_jawab');
            $table->string('file');
            $table->string('jumlah');
            $table->string('keterangan');
            $table->string('tanggal');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_periode')->references('id_periode')->on('periode');
            $table->foreign('id_user')->references('id_user')->on('users');   
        });
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
