<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function userCanRegister()
    {
        $this->withoutExceptionHandling();

        $this->userRole();

         $this->post('/register', [
            'email' => 'employer@email.com',
            'password' => 'secret12',
            'password_confirmation' => 'secret12',
            'role' => 1
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'employer@email.com',
            'role_id' => "1"
        ]);

        $this->assertDatabaseHas('employer_credits', [
            'credit' => 1,
        ]);

        $this->assertDatabaseHas('user_metas', 
            [
                'user_id' => 1,
                'name' => 'company_name',
                'value' => null
            ]
        );

        $this->assertDatabaseHas('user_metas', 
            [
                'user_id' => 1,
                'name' => 'company_url',
                'value' => null
            ]
        );

        $this->assertDatabaseHas('user_metas', 
            [
                'user_id' => 1,
                'name' => 'company_description',
                'value' => null
            ]
        );

        $this->assertDatabaseHas('user_metas', 
            [
                'user_id' => 1,
                'name' => 'company_logo',
                'value' => null
            ]
        );

        $this->assertDatabaseHas('user_metas', 
            [
                'user_id' => 1,
                'name' => 'company_hq',
                'value' => null
            ]
        );
    }

    /** @test */
    public function userCanAddProfile()
    {
        $this->withoutExceptionHandling();

        $this->signInEmployer();
        
        $profile = $this->post('/dashboard/profile', $attr = [
            'name' => 'New Name',
            'title' => 'Web Developer',
        ]);

        $profile->assertStatus(201)
        ->assertJsonFragment(['success' => 'Profile has been Updated.']);

        $this->assertDatabaseHas('profiles', $attr);
    }


    /** @test */
    public function userCantAddProfileWithoutName()
    {
        $this->signInEmployee();

        $profile = $this->post('/dashboard/profile', $attr = [
            'name' => '',
            'title' => 'Web Developer',
        ]);

        $profile->assertSessionHasErrors(['name' => 'Your Name is required.']);
    }


    /** @test */
    public function userCanUpdateProfile()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployer();

        $profile = factory('App\Model\Profile')->create(['user_id' => $user->id]);
        
        $profile = $this->post('/dashboard/profile', $attr = [
            'name' => 'User Name',
            'title' => 'Web Developer',
        ]);

        $profile->assertStatus(201)
        ->assertJsonFragment(['success' => 'Profile has been Updated.']);;

        $this->assertDatabaseHas('profiles', $attr);
    }


    /** @test */
    public function userCanUpdateTimezone()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployer();

        $profile = factory('App\Model\Profile')->create(['user_id' => $user->id]);
        
        $profile = $this->post('/dashboard/profile', $attr = [
            'name' => $profile->name,
            'timezone' => ['name' => 'America', 'value' => 'America +8'],
        ]);

        $profile->assertStatus(201)
        ->assertJsonFragment(['success' => 'Profile has been Updated.']);;

        $this->assertDatabaseHas('profiles', [
            'timezone' => json_encode(['name' => 'America', 'value' => 'America +8'])
        ]);
    }


    /** @test */
    public function userCanAddMeta()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployer();
        
        $create = $this->post("/dashboard/meta-data/{$user->identifier}", [
            'identifier' => '',
            'name' => 'cover_letter',
            'value' => 'Cover Letter Text'
        ]);

        $create->assertStatus(201)
        ->assertJsonFragment(['success' => 'Information has been updated.']);
        
        $this->assertDatabaseHas('user_metas', [
            'name' => 'cover_letter',
            'value' => 'Cover Letter Text'
        ]);
    }


    /** @test */
    public function userCantAddMetaWithoutValue()
    {
        $user = $this->signInEmployer();
        
        $create = $this->post("/dashboard/meta-data/{$user->identifier}", [
            'identifier' => '',
            'name' => 'cover_letter',
            'value' => ''
        ]);

        $create->assertSessionHasErrors(['value' => 'Value is required.']);
    }
}