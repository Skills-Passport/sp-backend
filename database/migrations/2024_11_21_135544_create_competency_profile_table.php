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
        Schema::create('competency_profile', function (Blueprint $table) {
            $table->foreignUuid('competency_id')->constrained('competencies');
            $table->foreignUuid('profile_id')->constrained('profiles');
            $table->primary(['competency_id', 'profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competency_profile');
    }
};
