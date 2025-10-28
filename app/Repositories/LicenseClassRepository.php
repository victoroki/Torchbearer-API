<?php

namespace App\Repositories;

use App\Models\LicenseClass;
use App\Repositories\BaseRepository;

class LicenseClassRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'license_type',
        'class',
        'scope',
        'min_qualification',
        'technical_qualification',
        'experience_requirements',
        'starting_license',
        'highest_achievable'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return LicenseClass::class;
    }
}
