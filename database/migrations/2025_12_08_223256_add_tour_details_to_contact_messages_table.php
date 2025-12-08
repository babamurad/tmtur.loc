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
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('tour_id')->nullable()->after('message');
            $table->unsignedBigInteger('tour_group_id')->nullable()->after('tour_id');
            $table->integer('people_count')->nullable()->after('tour_group_id');
            $table->json('services')->nullable()->after('people_count');

            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('set null');
            $table->foreign('tour_group_id')->references('id')->on('tour_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropForeign(['tour_id']);
            $table->dropForeign(['tour_group_id']);
            $table->dropColumn(['tour_id', 'tour_group_id', 'people_count', 'services']);
        });
    }
};
