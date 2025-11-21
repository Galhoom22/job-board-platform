<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Job Vacancy Model
 *
 * Represents an open job vacancy posted by a company.
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $location
 * @property float|null $salary
 * @property string $type
 * @property string $company_id
 * @property string $category_id
 *
 * @property JobCategory $category
 * @property Company $company
 */
class JobVacancy extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;
    public const TYPES = ['full_time', 'part_time', 'remote', 'internship'];

    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'company_id',
        'job_category_id',
    ];

    /**
     * Job category relationship.
     */
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    /**
     * Company relationship.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    protected function casts(): array
    {
        return [
            'salary' => 'decimal:2',
        ];
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'job_vacancy_id');
    }
}
