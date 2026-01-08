🚀 Enterprise Job Board Platform

A scalable, decoupled Job Board Solution engineered with a focus on separation of concerns. This repository implements a Modular Monorepo Architecture, housing two distinct applications to ensure security and logical separation between the candidate interface and the administrative backoffice.

🏗️ System Architecture

The platform is architected as two independent Laravel applications sharing a cohesive ecosystem:

1. 🌐 Candidate Portal (/job-app)

A responsive, user-centric frontend designed for high traffic and engagement.

Job Discovery: Advanced search and filtering capabilities for job vacancies.

Application Logic: Secure handling of resume uploads and job applications (JobApplication model).

Profile Management: Self-service dashboard for candidates to manage personal data and application history.

2. 🛡️ Admin Backoffice (/job-backoffice)

A restricted-access administrative panel for recruiters and platform managers.

Tenant Management: Full CRUD operations for Companies and Recruiters.

ATS Features: Application Tracking System to review, accept, or reject candidate submissions.

Taxonomy Management: Dynamic control over Job Categories and Attributes.

Data Seeding: Built-in mechanisms to populate the database with initial industry data.

💻 Technical Stack

Component

Technology

Description

Backend Framework

Laravel 12.x

Robust MVC architecture with strict typing.

Frontend

Blade + Tailwind CSS

Utility-first styling for rapid UI development.

Build Tool

Vite

Next-generation frontend tooling for optimized assets.

Database

MySQL / MariaDB

Relational data integrity with rigorous foreign key constraints.

Authentication

Laravel Breeze

Secure session-based authentication.

⚡ Installation & Local Development

Follow these steps to deploy the ecosystem locally.

Prerequisites

PHP >= 8.5

Composer

Node.js & NPM

MySQL Service

Step 1: Clone the Monorepo

git clone [https://github.com/your-username/job-board-platform.git](https://github.com/your-username/job-board-platform.git)
cd job-board-platform


Step 2: Configure the Candidate Portal (job-app)

cd job-app

# Install Dependencies
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Build Assets
npm run build

# Database Migration
php artisan migrate


Step 3: Configure the Backoffice (job-backoffice)

cd ../job-backoffice

# Install Dependencies
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Build Assets
npm run build

# Database Migration & Seeding (Crucial for Admin Data)
php artisan migrate --seed


🧪 Quality Assurance

Both applications enforce code quality standards through automated testing.

# Run Feature & Unit Tests
php artisan test

📄 License

This software is open-sourced software licensed under the MIT license.
