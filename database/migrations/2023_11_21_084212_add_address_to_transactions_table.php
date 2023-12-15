<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('address')->nullable()->after('comment');
        });
    }
    
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }
    
}
