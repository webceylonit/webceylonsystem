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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('nic')->unique()->after('email');
            $table->string('gender')->after('nic');
            $table->date('dob')->nullable()->after('gender');  
            $table->string('mobile_number')->after('dob');
            $table->string('employee_number')->unique()->after('mobile_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['nic', 'gender', 'dob', 'mobile_number', 'employee_number']);
        });
    }
};
