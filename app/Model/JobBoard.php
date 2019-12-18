<?php

namespace App\Model;

use App\Model\Job;
use Illuminate\Database\Eloquent\Model;

class JobBoard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'name'
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
     * Get the Job Model of Board.
     *
     * @return App\Model\Job
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
