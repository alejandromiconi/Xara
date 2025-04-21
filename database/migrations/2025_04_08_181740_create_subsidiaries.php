<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
/* 
$table->bigIncrements('id');       // Auto-incrementing UNSIGNED BIGINT
$table->boolean('active');         // BOOLEAN equivalent
$table->date('birth_date');        // DATE
$table->dateTime('created_at');    // DATETIME
$table->decimal('amount', 8, 2);   // DECIMAL with precision
$table->double('price', 8, 2);     // DOUBLE with precision
$table->enum('size', ['S', 'M', 'L']); // ENUM
$table->float('amount', 8, 2);     // FLOAT with precision
$table->integer('votes');          // INTEGER
$table->json('options');           // JSON
$table->string('email');           // VARCHAR
$table->text('description');       // TEXT
$table->time('sunrise');           // TIME
$table->timestamp('added_on');     // TIMESTAMP
$table->uuid('id');                // UUID 
// */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subsidiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tax_id', 50);
            $table->integer('company_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsidiaries');
    }
};
