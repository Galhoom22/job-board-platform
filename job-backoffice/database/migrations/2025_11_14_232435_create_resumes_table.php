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
        Schema::create('resumes', function (Blueprint $table): void {
            $table->uuid('id')->primary();

            $table->string('filename');
            $table->string('file_url');
            $table->longText('contact_details');
            $table->longText('education');
            $table->longText('experience');
            $table->longText('skills');
            $table->longText('summary');

            // Relations
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
