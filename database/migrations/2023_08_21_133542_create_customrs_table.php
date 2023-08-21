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
        Schema::create('customrs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('age');
            $table->boolean('gender');
            $table->string('password');
            $table->string('password_confirmation');
            $table->integer('reset_code')->nullable();
            $table->timestamp('code_created_at')->nullable();
            $table->timestamp('expiration_code')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customrs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
       
    }
};
