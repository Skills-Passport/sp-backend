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
        Schema::create('endorsements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->constrained('users');
            $table->foreignUuid('skill_id')->constrained('skills');
            $table->string('title', 255)->nullable();
            $table->text('content')->comment('endorsement content');
            $table->integer('rating');
            $table->json('data')->nullable();
            $table->foreignUuid('created_by')->constrained('users');
            $table->string('created_by_email', 255)->nullable();
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
        Schema::dropIfExists('endorsements');
    }
};
