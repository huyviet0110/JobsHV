<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSlugColumnUniqueInPostsTable extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('posts', 'slug')) {
            Schema::table('posts', static function (Blueprint $table) {
                $table->unique('slug');
            });
        }
    }

    public function down()
    {
    }
}
