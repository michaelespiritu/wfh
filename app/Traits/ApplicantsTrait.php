<?php

namespace App\Traits;

use App\Model\JobBoard;

trait ApplicantsTrait
{
    /**
     * Find the Job Board based on Identifier
     *
     * @return object
     */
    public function findJobBoard($identifier)
    {
        return JobBoard::whereIdentifier($identifier)->first();
    }

    /**
     * Update Status of Application
     *
     * @return bool
     */
    public function updateApplicantStatus($applicant, $data)
    {
        $data['status_id'] = $this->findJobBoard($data['status'])->id;
        
        return $applicant->update($data);
    }

    /**
     * Update Status of Application
     *
     * @return bool
     */
    public function getApplicant($jobBoard)
    {
        return $this->findJobBoard($jobBoard)->applicants->fresh();
    }
}