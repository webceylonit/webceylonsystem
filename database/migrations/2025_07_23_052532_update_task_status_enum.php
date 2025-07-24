<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        DB::statement("ALTER TABLE tasks MODIFY status ENUM('Pending', 'In Progress', 'Approval', 'Done') DEFAULT 'Pending'");
    }

    public function down(): void
    {
        // Optional: revert to original enum values
        DB::statement("ALTER TABLE tasks MODIFY status ENUM('Pending', 'In Progress', 'Done') DEFAULT 'Pending'");
    }
};
