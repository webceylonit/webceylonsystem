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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('project_code')->unique();          
            $table->string('name');
            $table->text('description')->nullable();

            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');  // FK to clients
            $table->foreignId('category_id')->nullable()->constrained('project_categories')->onDelete('set null');

            $table->foreignId('added_by')->nullable()->constrained('employees')->onDelete('set null');  // FK to employees who added the project

            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();

            $table->enum('status', ['New', 'In Progress', 'Completed', 'On Hold', 'Cancelled'])->default('New');
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');

            $table->decimal('estimate_budget', 15, 2)->nullable();

            $table->string('attachment')->nullable();
            $table->text('additional_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
