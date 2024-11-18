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
        Schema::create('group_members', function (Blueprint $table) {
            $table->foreignUuid('group_id')->constrained('groups');
            $table->foreignUuid('user_id')->constrained('users');
            $table->timestamps();
            $table->timestamp('left_at')->nullable();
            $table->primary(['group_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_members');
    }
};
