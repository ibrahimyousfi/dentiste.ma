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
        Schema::table('tooth_findings', function (Blueprint $table) {
            if (!Schema::hasColumn('tooth_findings', 'received')) {
                $table->decimal('received', 10, 2)->default(0)->after('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tooth_findings', function (Blueprint $table) {
            //
        });
    }
};
