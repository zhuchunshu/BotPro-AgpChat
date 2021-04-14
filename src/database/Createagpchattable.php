<?php

namespace App\Plugins\agpchat\src\database;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Createagpchattable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('agpchat')) {
            Schema::create('agpchat', function (Blueprint $table) {
                $table->increments('id');
                $table->string('group')->comment('群号');
                $table->longText('content')->comment('回复内容');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agpchat');
    }
}
