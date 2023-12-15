<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkteaSizeMilkteaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milktea_size_milktea', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('milktea_id');
            $table->unsignedBigInteger('milktea_size_id');
            $table->timestamps();
            $table->foreign('milktea_id')->references('id')->on('milkteas');
            $table->foreign('milktea_size_id')->references('id')->on('milktea_sizes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milktea_size_milktea');
    }
}
