<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JobCategory;
use App\Models\Company;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\JobApplication;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // seed the root admin user
        User::firstOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'id' => Str::uuid(),
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Seed Data to test with
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobApplications = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        // create job categories
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category
            ]);
        }

        // Create Companies
        foreach ($jobData['companies'] as $company) {
            // create company owner
            $companyOwner = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail()
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('12345678'),
                'role' => 'company-owner',
                'email_verified_at' => now()
            ]);

            // create company
            Company::firstOrCreate([
                'name' => $company['name']
            ], [
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'owner_id' => $companyOwner->id
            ]);
        }

        // create job vacancies
        foreach ($jobData['jobVacancies'] as $job) {
            // Get the created company
            $company = Company::where('name', $job['company'])->firstOrFail();

            // get the created job category
            $jobCategory = JobCategory::where('name', $job['category'])->firstOrFail();

            JobVacancy::firstOrCreate([
                'title' => $job['title'],
                'company_id' => $company->id
            ], [
                'description' => $job['description'],
                'location' => $job['location'],
                'type' => $job['type'],
                'salary' => $job['salary'],
                'category_id' => $jobCategory->id,
            ]);
        }

        // create job applications
        foreach ($jobApplications['jobApplications'] as $application) {
            // get random job vacancy
            $jobVacancy = JobVacancy::inRandomOrder()->first();

            // create applicant (job seeker)
            $applicant = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail()
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('12345678'),
                'role' => 'job-seeker',
                'email_verified_at' => now()
            ]);

            // create resume
            $resume = Resume::create([
                'user_id' => $applicant->id,
                'filename' => $application['resume']['filename'],
                'file_url' => $application['resume']['fileUri'],
                'contact_details' => $application['resume']['contactDetails'],
                'education' => $application['resume']['education'],
                'experience' => $application['resume']['experience'],
                'skills' => $application['resume']['skills'],
                'summary' => $application['resume']['summary'],
            ]);

            // create job application
            JobApplication::create([
                'job_vacancy_id' => $jobVacancy->id,
                'user_id' => $applicant->id,
                'resume_id' => $resume->id,
                'status' => $application['status'],
                'ai_generated_score' => $application['aiGeneratedScore'],
                'ai_generated_feedback' => $application['aiGeneratedFeedback'],
            ]);
        }
    }
}
