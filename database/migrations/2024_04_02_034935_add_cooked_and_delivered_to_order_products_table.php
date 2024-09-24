<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->boolean('is_cooked')->default(false);
            $table->boolean('is_delivered')->default(false);
        });
    }

    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropColumn('is_cooked');
            $table->dropColumn('is_delivered');
        });
    }
};
