<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRlsprovinsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rlsprovinsi', function (Blueprint $table) {
            $table->increments('rlsprovinsiid');
            $table->string('rlsprovinsivalue');
            $table->date('rlsprovinsitgl');
            $table->string('rlsprovinsiprovincekode');
            $table->string('rlsprovinsikotakode');
            $table->date('rlsprovinsicreatedate');
            $table->integer('rlsprovinsicreateby');
            $table->integer('rlsprovinsistatus');
            $table->integer('rlsprovinsilogid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rlsprovinsi');
    }
}
