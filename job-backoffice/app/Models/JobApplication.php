<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        'job_vacancy_id',
        'user_id',
        'resume_id'
    ];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class, 'resume_id');
    }
}
