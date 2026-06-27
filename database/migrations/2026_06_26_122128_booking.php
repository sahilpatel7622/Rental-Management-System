<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('property_id');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('total_days');
            $table->decimal('total_amount',10,2);
            $table->string('payment_method');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('property')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
