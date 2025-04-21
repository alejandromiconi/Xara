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
		
		//Name	Description	Brand	Category	Price	Currency	Stock	EAN	Color	Size	Availability

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description');
            $table->string('brand');
            $table->string('category');
            $table->float('price');
            $table->string('currency', 10);
            $table->float('stock');
            $table->string('ean');
            $table->string('color');
            $table->string('size');
            $table->string('availability');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
