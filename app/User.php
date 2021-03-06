<?php

namespace App;

use Helpers;
use App\Model\Job;
use App\Model\Role;
use App\Model\Skill;
use App\Model\Profile;
use App\Model\Payments;
use App\Model\UserMeta;
use App\Model\Applicant;
use App\Model\Conversation;
use App\Model\EmployerCredit;
use App\Http\Resources\MetaResource;
use App\Http\Resources\SkillsResource;
use Illuminate\Notifications\Notifiable;
use App\Http\Resources\ConversationResource;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $appends = ['name', 'title', 'meta', 'skills_bank', 'has_card', 'profile_image', 'unread_messages'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'email', 'password', 'role_id', 'stripe_id', 'card_last_four', 'card_brand'
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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'stripe_id', 'card_last_four', 'card_brand', 'email_verified_at', 'trial_ends_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The Role of user
     * 
     * @return App\Model\Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The Credit of Employer to be used in Job Posting
     * 
     * @return App\Model\EmployerCredit
     */
    public function employerCredit()
    {
        return $this->hasOne(EmployerCredit::class);
    }

     /**
     * Minus the Credit of Employer when job is posted
     * 
     * @return int
     */
    public function minusEmployerCredit()
    {
        return (!empty((int) $this->employerCredit->credit)) ? $this->employerCredit->credit - 1 : 0;
    }

    /**
     * The Profile of user
     * 
     * @return App\Model\Profile
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * The Meta Data of user
     * 
     * @return App\Model\MetaData
     */
    public function userMeta()
    {
        return $this->hasMany(UserMeta::class);
    }
    

    /**
     * Return True if user is Employer
     * 
     * @return bool
     */
    public function isEmployer()
    {
        return $this->role->id == 1;
    }

    /**
     * The Jobs of User
     * 
     * @return App\Model\Job
     */
    public function jobs()
    {
        return $this->hasMany(Job::class, 'owner_id');
    }


    /**
     * The Applications of User [Talent]
     * 
     * @return App\Model\Job
     */
    public function applications()
    {
        return $this->hasMany(Applicant::class);
    }
    
    /**
     * The Skills of User [Talent]
     * 
     * @return App\Model\Skill
     */
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    /**
     * The Payment history of user [Employer]
     * 
     * @return App\Model\Payments
     */
    public function payments()
    {
        return $this->hasMany(Payments::class);
    }

    /**
     * The Conversations History of User
     * 
     * @return App\Model\Conversations
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'owner_id');
    }

    /**
     * Get All Conversations History of User that has access to.
     * 
     * @return mixed
     */
	public function accessibleConversations()
	{
	    $conversation = Conversation::where('owner_id', $this->id)
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', $this->id);
            })
            ->get();

        return ConversationResource::collection($conversation->fresh());
    }
    
    /**
     * Output the name of user if Profile is Found to be append in User Object
     * 
     * @return string
     */
    public function getNameAttribute()
    {
        return ($this->profile) ? $this->profile->name : $this->email;
    }

    /**
     * Output the Meta of user if Profile is Found to be append in User Object
     * 
     * @return string
     */
    public function getMetaAttribute()
    {
        return MetaResource::collection($this->userMeta);
    }

    /**
     * Output the Skills of user if Profile is Found to be append in User Object
     * 
     * @return string
     */
    public function getSkillsBankAttribute()
    {
        return SkillsResource::collection($this->skills);
    }

    /**
     * Output the Skills of user if Profile is Found to be append in User Object
     * 
     * @return string
     */
    public function getTitleAttribute()
    {
        return ($this->profile) ? $this->profile->title : null;
    }

    /**
     * Output the Skills of user if Profile is Found to be append in User Object
     * 
     * @return string
     */
    public function getHasCardAttribute()
    {
        return ($this->card_last_four) ? true : false;
    }

    /**
     * Output the Profile Image
     * 
     * @return string
     */
    public function getProfileImageAttribute()
    {
        return ($this->profile->profile_image) 
                ? $this->profile->profile_image 
                :  Helpers::convertNameToImage($this->name);
    }

    /**
     * Output the Number of unread Message
     * 
     * @return string
     */
    public function getUnreadMessagesAttribute()
    {
        $unread = 0;

        foreach ($this->accessibleConversations() as $conversation) {
            if ($conversation->latestMessage()->from_id != auth()->user()->id && $conversation->read == null) {
                $unread++;
            }
        }
        return $unread;
    }

    /**
     * Determine if the Target User is Already a member of conversation
     * 
     * @return string
     */
    public function isConversationMember($user)
    {
        $this->whereIdentifier($user);
        $conversation = $this->conversations()->whereHas('members', function ($query) use ($user){
                $query->where('user_id', $this->whereIdentifier($user)->first()->id);
            })
            ->first();

        return ($conversation) ? $conversation  : null;
    }

    /**
     * Output the Company Name if Found
     * 
     * @return string
     */
    public function companyName()
    {
        return ($this->userMeta->where('name', 'company_name')->first()) ? $this->userMeta->where('name', 'company_name')->first()->value : null;
    }

    /**
     * Output the Company URL if Found [Employer]
     * 
     * @return string
     */
    public function companyUrl()
    {
        return ($this->userMeta->where('name', 'company_url')->first()) ? $this->userMeta->where('name', 'company_url')->first()->value : null;
    }

    /**
     * Output the Company URL if Found [Employer]
     * 
     * @return string
     */
    public function coverLetter()
    {
        return ($this->userMeta->where('name', 'cover_letter')->first()) ? $this->userMeta->where('name', 'cover_letter')->first()->value : null;
    }

    /**
     * Convert the skills to html entity [Talent]
     * 
     * @return string
     */
    public function convertSkillsToHtml()
    {
        $skills = "<ul class='list-inline mb-0'>";

        foreach($this->skills as $skill) {
            $name =  $skill->skill['name'];
            
            $skills .= "<li class='list-inline-item'><span class='badge badge-primary rounded-0 px-2'>$name</span></li>";
        }

        $skills .= "</ul>";

        return (!$this->skills->isEmpty()) ? $skills : null;
    }

    /**
     * Convert the skills to html entity with limit [Talent]
     * 
     * @return string
     */
    public function convertSkillsToHtmlWithLimit($limit = 2)
    {
        $skills = "<ul class='list-inline mb-0'>";

        foreach($this->skills->take($limit) as $skill) {
            $name =  $skill->skill['name'];
            
            $skills .= "<li class='list-inline-item'><span class='badge badge-primary rounded-0 px-2'>$name</span></li>";
        }

        $skills .= "</ul>";

        return (!$this->skills->isEmpty()) ? $skills : null;
    }

    /**
     * Compute the total purchase of User [Employer]
     * 
     * @return string
     */
    public function computePurchase()
    {
        $total = 0; 
        
        foreach( $this->payments->pluck('amount') as $amount ) {
            $total += $amount;
        };

        return $total;
    }
}
