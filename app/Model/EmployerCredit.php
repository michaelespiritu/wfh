<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmployerCredit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'credit'
    ];

    /**
     * The Owner of Credit
     * 
     * @return App\User
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
