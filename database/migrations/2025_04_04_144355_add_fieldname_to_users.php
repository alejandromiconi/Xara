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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('company_id')->nullable();
            $table->json('preferences')->nullable(); 
            $table->string('user_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company_id')->nullable();
            $table->dropColumn('preferences')->nullable(); 
            $table->dropColumn('user_status')->nullable(); 
        });
    }
};
