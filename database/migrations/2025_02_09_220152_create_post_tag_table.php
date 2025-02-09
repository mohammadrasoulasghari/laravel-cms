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
        Schema::create(table_name('post_' . table_name('tag')), function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')
                ->constrained(table: table_name('posts'))
                ->cascadeOnDelete();
            $table->foreignId('tag_id')
                ->constrained(table: table_name('tags'))
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table_name('post_' . table_name('tag')));
    }
};
