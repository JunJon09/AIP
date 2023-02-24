<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('count');
            $table->timestamps();
        });

        Schema::create('imgs', function (Blueprint $table) {
            $table->id();
            $table->text('path');
            $table->text('name');
            $table->timestamps();
        });

        Schema::create('img_types', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Img_id');
            $table->bigInteger('type_id');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
        Schema::dropIfExists('imgs');
        Schema::dropIfExists('img_types');
        
    }
};
