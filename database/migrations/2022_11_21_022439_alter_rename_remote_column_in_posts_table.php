<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRenameRemoteColumnInPostsTable extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('posts', 'remote')) {
            Schema::table('posts', static function (Blueprint $table) {
                $table->renameColumn('remote', 'remotable');
            });
        }
    }

    public function down(): void
    {
    }
}
