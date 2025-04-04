<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table_name('category_'.table_name('post')), function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')
                ->constrained(table: table_name('posts'))
                ->cascadeOnDelete();
            $table->foreignId('category_id')
                ->constrained(table: table_name('categories'))
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table_name('category_'.table_name('post')));
    }
};
