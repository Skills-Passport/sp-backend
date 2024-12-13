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
        Schema::create('feedback_request', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('title');
            $table->enum('status', ['pending', 'answered', 'declined'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignUuid('requester_id')->constrained('users');
            $table->foreignUuid('skill_id')->constrained('skills');
            $table->foreignUuid('recipient_id')->constrained('users');
            $table->foreignUlid('group_id')->nullable()->constrained('groups');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_request');
    }
};
