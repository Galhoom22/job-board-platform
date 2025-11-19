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
        Schema::create('job_vacancies', function (Blueprint $table): void {
            $table->uuid('id')->primary();

            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->decimal('salary', 10, 2);
            $table->enum('type', ['full_time', 'part_time', 'remote', 'internship'])->default('full_time');

            // Foreign Keys
            $table->foreignUuid('company_id')->constrained('companies')->restrictOnDelete();

            $table->foreignUuid('category_id')->constrained('job_categories')->restrictOnDelete();

            // Indexes (Performance Optimization)
            $table->index('type');
            $table->index('location');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
