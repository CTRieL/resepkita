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
        Schema::create('likes', function (Blueprint $table) {
            $table->foreignId('recipe_id')->constrained('recipes');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('type', ['thumbs_up', 'love', 'tasty']);
            $table->timestamps();
            
            $table->primary(['recipe_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
