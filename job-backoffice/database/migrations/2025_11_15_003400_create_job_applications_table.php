<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table): void {
            $table->uuid('id')->primary();

            // Status + indexing
            $table->enum('status', ['pending', 'accepted', 'rejected'])
                ->default('pending')
                ->index();

            // Accurate scoring
            $table->decimal('ai_generated_score', 5, 2)
                ->default(0);

            // Optional feedback
            $table->longText('ai_generated_feedback')
                ->nullable();

            // Relations
            $table->foreignUuid('job_vacancy_id')
                ->constrained('job_vacancies')
                ->restrictOnDelete();

            $table->foreignUuid('resume_id')
                ->constrained('resumes')
                ->restrictOnDelete();

            $table->foreignUuid('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
