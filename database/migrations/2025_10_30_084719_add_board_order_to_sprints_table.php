<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_board_order_to_sprints_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('sprints', function (Blueprint $table) {
            if (!Schema::hasColumn('sprints', 'board_order')) {
                $table->json('board_order')->nullable()->after('status');
            }
        });
    }

    public function down(): void {
        Schema::table('sprints', function (Blueprint $table) {
            if (Schema::hasColumn('sprints', 'board_order')) {
                $table->dropColumn('board_order');
            }
        });
    }
};
