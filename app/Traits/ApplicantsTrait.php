<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;

trait ApplicantsTrait
{

    /**
     * Update Status of Application
     *
     * @return bool
     */
    public function updateApplicantStatus($applicant, $data)
    {
        return $applicant->update($data);
    }
}