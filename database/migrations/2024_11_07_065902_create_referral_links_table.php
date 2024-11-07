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
    Schema::create('referral_links', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique();
        $table->string('stripe_account_id');
        $table->string('trainer_name'); // Aggiungiamo il nome del trainer
        $table->string('trainer_email')->nullable(); // Email opzionale per notifiche
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_links');
    }
};
