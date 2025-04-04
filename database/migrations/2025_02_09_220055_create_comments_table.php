<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table_name('comments'), function (Blueprint $table) {
            $table->id();
            $table->foreignId(cms_config('user.foreign_key'));
            $table->foreignId('post_id')
                ->constrained(table: table_name('posts'))
                ->cascadeOnDelete();
            $table->text('comment');
            $table->boolean('approved')->default(false);
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table_name('comments'));
    }
};
