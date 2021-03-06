<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaftarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('daftars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('phone', false);
            $table->string('status');
            $table->string('level');
            $table->integer('nip', false);
            //kalo gak di isi nilainya 0 alias gak ada gambar
            $table->string('foto')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->rememberToken();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('daftars');
    }
}
