<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeProfileTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function employeeCanAddSkill()
    {
        $this->withoutExceptionHandling();

        $this->signInEmployee();

        $skills = [
            [
                'name' => 'Laravel',
                'level' => 10
            ],
            [
                'name' => 'Nuxt',
                'level' => 2
            ],
        ];

        $create = $this->post('/dashboard/skills', $attr =[
            'skills' => $skills
        ]);

        $create->assertStatus(200)
        ->assertJsonFragment(['success' => 'Skills has been updated.']);

        $this->assertDatabaseHas('skills', ['skill' =>  json_encode([ 'name' => 'Laravel','level' => 10 ]) ] );
        $this->assertDatabaseHas('skills', ['skill' =>  json_encode([ 'name' => 'Nuxt','level' => 2 ]) ] );
    }


    /** @test */
    public function employeeSkillWillBeDeletedThenAddedUponUpdate()
    {
        $this->withoutExceptionHandling();

        $user = $this->signInEmployee();
        
        $skill = factory('App\Model\Skill')->create(['user_id' => $user->id]);

        $skills = [
            [
                'name' => 'Nuxt',
                'level' => 2
            ],
        ];

        $update = $this->post('/dashboard/skills', [
            'skills' => $skills
        ]);

        $update->assertStatus(200)
        ->assertJsonFragment(['success' => 'Skills has been updated.']);

        $this->assertDatabaseMissing('skills', ['id' => $skill->id, 'skill' =>  json_encode([ 'name' => $skill->skill['name'],'level' => $skill->skill['level'] ]) ]);
        $this->assertDatabaseHas('skills', ['skill' =>  json_encode([ 'name' => 'Nuxt','level' => 2 ]) ] );
    }

}
