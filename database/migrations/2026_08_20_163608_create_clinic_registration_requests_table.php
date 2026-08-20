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
        Schema::create('clinic_registration_requests', function (Blueprint $table) {
            $table->id();
            $table->string('clinic_name');
            $table->string('owner_name');
            $table->string('email');
            $table->string('phone');
            $table->enum('status', ['pending', 'contacted', 'completed', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_registration_requests');
    }
};
