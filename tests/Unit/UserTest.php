<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{   
    use RefreshDatabase;
    
    /** @test */
    public function userWillOutputEmailIfNoProfileIsFound()
    {
        $user = factory('App\User')->create(['role_id' => 2]);

        $this->assertEquals($user->name, $user->email);
    }

    /** @test */
    public function userWillOutputNameIfProfileIsFound()
    {
        $user = factory('App\User')->create(['role_id' => 2]);
        $profile = factory('App\Model\Profile')->create(['user_id' => $user->id]);
        $this->assertEquals($user->name, $profile->name);
    }

    /** @test */
    public function userWillOutputTitleIfProfileIsFound()
    {
        $user = factory('App\User')->create(['role_id' => 2]);
        $profile = factory('App\Model\Profile')->create(['user_id' => $user->id]);
        $this->assertEquals($user->title, $profile->title);
    }

    /** @test */
    public function userWillOutputNullIfNoProfileIsFound()
    {
        $user = factory('App\User')->create(['role_id' => 2]);
        $this->assertEquals($user->title, null);
    }

    /** @test */
    public function jobCreditCanBeLessenIfNotZero()
    {
        $user = $this->signInEmployer();
        $user->employerCredit()->update(['credit' => 2]);
        $this->assertEquals($user->minusEmployerCredit(), 1);
    }

    /** @test */
    public function jobCreditCannotBeLessenIfZero()
    {
        $user = $this->signInEmployer();
        $user->employerCredit()->update(['credit' => 0]);
        $this->assertEquals($user->minusEmployerCredit(), 0);
    }

    /** @test */
    public function willOutputCompanyNameIfFoundForEmployer()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployer();
        factory('App\Model\UserMeta')->create(['user_id' => $user->id, 'value' => 'Lawson Inc']);

        $this->assertEquals($user->companyName(), 'Lawson Inc');
    }

    /** @test */
    public function willOutputCompanyUrlIfFoundForEmployer()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployer();
        factory('App\Model\UserMeta')->create(['user_id' => $user->id, 'name' => 'company_url', 'value' => 'https://facebook.com']);

        $this->assertEquals($user->companyUrl(), 'https://facebook.com');
    }

    /** @test */
    public function willNotOutputCompanyUrlIfNoMetaFoundForEmployer()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployer();

        $this->assertEquals($user->companyUrl(), null);
    }

    /** @test */
    public function convertTheSkillsToHtml()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployee();

        $skill = factory('App\Model\Skill')->create(['user_id' => $user->id]);

        $this->assertEquals($user->convertSkillsToHtml(), "<ul class='list-inline mb-0'><li class='list-inline-item'><span class='badge badge-primary rounded-0 px-2'>Sales</span></li></ul>");
    }

    /** @test */
    public function ConvertTheSkillsToHtmlWillOutputNullIfNoDataFound()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployee();

        $this->assertEquals($user->convertSkillsToHtml(), null);
    }

    /** @test */
    public function CanComputeAllThePurchaseEvenIfNone()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployee();

        $this->assertEquals($user->computePurchase(), 0);
    }

    /** @test */
    public function CanComputeAllThePurchase()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployee();
        factory('App\Model\Payments')->create(['user_id' => $user->id, 'amount' => 10]);
        factory('App\Model\Payments')->create(['user_id' => $user->id, 'amount' => 20]);
        factory('App\Model\Payments')->create(['user_id' => $user->id, 'amount' => 30]);

        $this->assertEquals($user->computePurchase(), 60);
    }
}
