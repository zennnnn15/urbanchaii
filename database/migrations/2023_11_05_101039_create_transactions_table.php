<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Using id as the primary key from milktea_sizes table
            $table->unsignedBigInteger('milktea_id');
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('quantity');
            $table->decimal('total', 8, 2); // Assuming total is a decimal value, adjust precision and scale as needed
            $table->unsignedBigInteger('customer_id'); // Reference to the customers table
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('milktea_id')->references('id')->on('milk_tea_sizes');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }
    


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
