<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Company Model
 *
 * Represents a company entity in the Job Board Platform.
 */
class Company extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'address',
        'industry',
        'website',
        'owner_id',
    ];

    /**
     * Company belongs to an owner (User)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'company_id');
    }

    /**
     * Get all job applications for this company through job vacancies
     */
    public function applications()
    {
        return $this->hasManyThrough(JobApplication::class, JobVacancy::class);
    }
}
