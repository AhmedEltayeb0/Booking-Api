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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('customr_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->date('booking_date');
            $table->date_time_set('from');
            $table->date_time_set('to');
            $table->date_time_set('period');
            $table->intger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
       
    }
};
