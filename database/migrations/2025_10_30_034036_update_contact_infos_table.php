<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateContactInfosTable extends Migration
{
    public function up()
    {
        Schema::table('contact_infos', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_infos', 'input_type')) {
                $table->string('input_type')->nullable()->after('value');
            }
            if (!Schema::hasColumn('contact_infos', 'url')) {
                $table->string('url')->nullable()->after('icon');
            }
        });
    }

    public function down()
    {
        Schema::table('contact_infos', function (Blueprint $table) {
            if (Schema::hasColumn('contact_infos', 'input_type')) {
                $table->dropColumn('input_type');
            }
            if (Schema::hasColumn('contact_infos', 'url')) {
                $table->dropColumn('url');
            }
        });
    }
}
