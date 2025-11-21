<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resume extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $keyType = "string";
    public $incrementing = false;
    protected $fillable = [
        'filename',
        'fileUrl',
        'summary',
        'contactDetails',
        'education',
        'experience',
        'skills',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'resume_id');
    }
}
