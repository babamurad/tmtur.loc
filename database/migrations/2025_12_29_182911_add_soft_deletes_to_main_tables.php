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
        Schema::table('tours', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('guides', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tour_groups', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tour_categories', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('posts', function (Blueprint $table) {
            // Check if column exists first as Post model showed signs of incomplete soft delete implementation
            if (!Schema::hasColumn('posts', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('guides', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('tour_groups', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('tour_categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
