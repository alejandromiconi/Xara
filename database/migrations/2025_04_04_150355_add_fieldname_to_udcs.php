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
        Schema::table('udcs', function (Blueprint $table) {
            $table->boolean('udc_inactive')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('udcs', function (Blueprint $table) {
            $table->dropColumn('udc_inactive')->nullable();
        });
    }
};
