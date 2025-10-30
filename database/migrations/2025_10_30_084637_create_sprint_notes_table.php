<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sprint_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sprint_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->string('role', 20)->nullable();   // PM, Dev, QA, etc.
            $table->string('color', 20)->nullable();  // e.g. #ffeb3b or class
            $table->date('note_date')->nullable();
            // adjust this FK to your auth schema if needed:
            $table->foreignId('created_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamps();

            $table->index(['sprint_id', 'note_date']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('sprint_notes');
    }
};
