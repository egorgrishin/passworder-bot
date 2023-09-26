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
        Schema::create('credentials', function (Blueprint $table) {
            $table->id();
            $table->string('chat_hash')->index();
            $table->string('title', 255);
            $table->string('login', 255)->nullable();
            $table->string('password', 511)->nullable();
            $table->boolean('is_saved')->default(0)->index();

            $table->foreign('chat_hash')->references('chats')->on('hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credentials');
    }
};
