<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('friend_requests', 'status')) {
            Schema::table('friend_requests', function (Blueprint $table) {
                $table->string('status')->default('pending')->after('receiver_id');
            });
        }
    }
public function down()
{
    Schema::table('friend_requests', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

};
