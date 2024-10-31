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
            $table->id();
            $table->unsignedBigInteger('direct_message_id');
            $table->string('message_id')->unique();
            $table->unsignedBigInteger('sender_id');
            $table->text('message');
            $table->string('status')->default('sent'); // sent, delivered, seen
            $table->timestamps();

            $table->foreign('direct_message_id')->references('id')->on('direct_messages')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
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
