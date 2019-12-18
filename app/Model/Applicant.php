<?php

namespace App\Model;

use App\User;
use App\Model\Job;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'user_id', 'status_id', 'cover_letter'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'identifier';
    }

    /**
     * The User Model of the Applicant
     * 
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The Job Model where this Applicant Applies
     * 
     * @return App\Model\Job
     */
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /**
     * The Status of Applicant
     * 
     * @return App\Model\Job
     */
    public function status()
    {
        return $this->belongsTo(JobBoard::class, 'status_id');
    }

    /**
     * The Job Model where this Applicant Applies
     * 
     * @return App\Model\Job
     */
    public function path()
    {
        return "/application/$this->identifier";
    }
}
