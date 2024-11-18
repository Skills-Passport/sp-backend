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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->text('personal_coach')->nullable();
            $table->text('job_title')->comment('Job Title')->nullable();
            $table->text('address')->comment('Address of the user')->nullable();
            $table->text('field')->comment('Field of the user')->nullable();
            $table->text('image')->nullable();
            $table->foreignId('role_id')->constrained();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('image');
            $table->dropColumn('field');
            $table->dropColumn('address');
            $table->dropColumn('job_title');
            $table->dropColumn('personal_coach');
            $table->dropForeign(['role_id']);
            $table->dropSoftDeletes();
        });
    }
};
