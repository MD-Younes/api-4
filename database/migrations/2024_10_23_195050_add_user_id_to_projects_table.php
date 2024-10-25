<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToProjectsTable extends Migration
{
    public function up()
    {
        
        if (!Schema::hasColumn('projects', 'user_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->after('id')->nullable();
            });
        }
    }

    public function down()
    {
        
        if (Schema::hasColumn('projects', 'user_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }
    }
}

