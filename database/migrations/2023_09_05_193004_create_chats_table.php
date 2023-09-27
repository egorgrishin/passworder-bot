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
            $table->string('hash', 60)->primary();
            $table->string('password')->nullable();
            $table->string('stage', 63)->nullable()->index();
            $table->bigInteger('outgoing_message_id')->unsigned()->nullable();
            $table->bigInteger('incoming_message_id')->unsigned()->nullable();
            $table->dateTime('last_activity_at')->nullable();
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
