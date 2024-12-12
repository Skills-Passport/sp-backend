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
        Schema::create('endorsement_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('title')->nullable();
            $table->foreignUuid('requester_id')->constrained('users');
            $table->foreignUuid('skill_id')->constrained('skills');
            $table->foreignUuid('requestee_id')->nullable()->constrained('users');
            $table->string('requestee_email')->nullable()->comment('email of the requestee');
            $table->enum('status', ['pending', 'approved', 'rejected', 'filled'])->default('pending');
            $table->text('data')->nullable()->comment('data of the request');
            $table->timestamp('filled_at')->nullable();
            $table->foreignUuid('approver_id')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endorsement_requests');
    }
};
