<?php

namespace App\Traits;

trait SkillsTrait
{
    public function createSkill($user, $data)
    {
        $this->deleteSkill($user);

        foreach($data['skills'] as $skill) {
            $user->skills()->create([
                'skill' => $skill
            ]);
        }   
    }

    public function updateSkill($skill, $data)
    {
        return $skill->update($data);
    }

    public function deleteSkill($user)
    {
        return $user->skills()->delete();
    }
}