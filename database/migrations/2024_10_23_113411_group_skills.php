<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('group_skills', function (Blueprint $table) {
            $table->foreignUuid('group_id')->constrained('groups');
            $table->foreignUuid('skill_id')->constrained('skills');
            $table->timestamps();
            $table->primary(['group_id', 'skill_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_skills');
    }
};
