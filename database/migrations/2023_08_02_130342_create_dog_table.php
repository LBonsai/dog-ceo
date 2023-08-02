<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create('dog', function (Blueprint $oTable) {
            $oTable->bigIncrements('id');
            $oTable->string('name')->unique();
            $oTable->text('url');
            $oTable->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('dog');
    }
};
