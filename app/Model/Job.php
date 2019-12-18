<?php

namespace App\Model;

use App\User;
use Carbon\Carbon;
use App\Model\Category;
use App\Model\JobBoard;
use App\Model\Applicant;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_openings';

    protected $appends = ['path'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'expiration', 'owner_id', 'category_id', 'title', 'type', 'region_restriction', 'notify_email', 'budget', 'skills','description'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expiration' => 'datetime',
        'skills' => 'json',
        'budget' => 'json',
        'notify_email' => 'json'
    ];


    /**
     * The Owner of Job Post
     * 
     * @return App\User
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The Owner of Job Post
     * 
     * @return App\User
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * The Owner of Job Post
     * 
     * @return App\Model\JobBoard
     */
    public function jobBoards()
    {
        return $this->hasMany(JobBoard::class);
    }

    /**
     * The Owner of Job Post
     * 
     * @return App\Model\Applicant
     */
    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    /**
     * Transform the Days Active Remaning of job.
     *
     * @return string
     */
    public function daysRemaining()
    {
        $expiration = Carbon::parse($this->expiration);

        $now = Carbon::now();

        $days = $expiration->diffInDays($now);

        return (($expiration->isPast() || $days == 0) ? 'Job Expired.' : (($days >=2 ) ? "$days Days" : "$days Day")) ;
    }

    /**
     * Transform the Budget of Job.
     *
     * @return string
     */
    public function allotedBudget()
    {
        if($this->budget['type'] == 'Per Hour' || $this->budget['type'] == 'Per Day'|| $this->budget['type'] == 'Fixed'):
            return '$'.$this->budget['amount'] . ' '  . $this->budget['type'];
        endif;

        if($this->budget['type'] == 'DOE' || $this->budget['type'] == 'TBD'|| $this->budget['type'] == 'Negotiable'):
            return $this->budget['type'];
        endif;
    }
    
    /**
     * Transform the Applicant Count.
     *
     * @return string
     */
    public function applicantCountTextOutput($type = null)
    {
        $count = ($type) ? count($this->jobBoards()->whereIdentifier($type)->first()->applicants) : count($this->applicants);
        
        return ($count > 1) ? "$count Applicants" : "$count Applicant";
    }

    /**
     * Get the path of Model.
     *
     * @return string
     */
    public function path()
    {
        return "/jobs/$this->identifier";
    }


    /**
     * Appends the path of Model.
     *
     * @return string
     */
    public function getPathAttribute()
    {
        return "/jobs/$this->identifier";
    }

    /**
     * Get the path of Model.
     *
     * @return string
     */
    public function applicantPath()
    {
        return "/app/jobs/$this->identifier";
    }

    /**
     * Get the path of Apply to Job.
     *
     * @return string
     */
    public function jobApplyPath()
    {
        return "/app/jobs/apply/$this->identifier";
    }
}
