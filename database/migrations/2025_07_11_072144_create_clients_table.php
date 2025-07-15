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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // Client Details
            $table->string('name'); // Client Name (required)
            $table->string('designation'); // Client Designation (required)
            $table->string('email')->unique(); // Client Email (required)
            $table->string('client_contact'); // Client Contact Number (required)

            // Company Details
            $table->string('company')->nullable();
            $table->string('phone')->nullable(); // Company Contact Number
            $table->string('company_email')->nullable(); // Company Email (new)
            $table->text('address')->nullable(); // Company Address

            // Other
            $table->text('notes')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->foreignId('added_by')->constrained('employees')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
