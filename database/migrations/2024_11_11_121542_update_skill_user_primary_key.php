<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('skill_user', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['user_id']);
            $table->dropForeign(['skill_id']);

            // Drop the existing primary key
            $table->dropPrimary(['user_id', 'skill_id']);

            // Add the new primary key including the 'rating' column
            $table->primary(['user_id', 'skill_id', 'rating']);

            // Re-add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('skill_user', function (Blueprint $table) {
            // Drop the new primary key
            $table->dropPrimary(['user_id', 'skill_id', 'rating']);

            // Restore the original primary key
            $table->primary(['user_id', 'skill_id']);

            // Re-add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
        });
    }
};
