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
        Schema::create('chats', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('hash', 60)->unique();
            $table->string('password')->nullable();
            $table->tinyInteger('stage_id')->nullable()->unsigned()->index();

            $table->foreign('stage_id')
                ->references('id')
                ->on('stages')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
