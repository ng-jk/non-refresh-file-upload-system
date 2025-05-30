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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('UNIQUE_KEY')->unique();
            $table->string('PRODUCT_TITLE');
            $table->text('PRODUCT_DESCRIPTION');
            $table->string('STYLE_NUMBER'); // STYLE# column, renamed for compatibility
            $table->string('SANMAR_MAINFRAME_COLOR');
            $table->string('SIZE');
            $table->string('COLOR_NAME');
            $table->decimal('PIECE_PRICE', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
